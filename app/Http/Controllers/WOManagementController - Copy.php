<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use App\client_WorkOrder;
use App\data_State;
use App\data_City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class WOManagementController extends Controller
{
	public function index(){
		return view('womanagement');
	}
	
	public function getWOInfo(){
		$allWoInfo = client_WorkOrder::all();
		$woInfo = DB::select('select * from client_WorkOrder where MergedWOId is null');
		$mergedWOInfo = DB::select('select * from client_MergedWorkOrder');
		$collection = collect();
		foreach($mergedWOInfo as $mergedWO){
			$subWOInfo = DB::select('select * from client_WorkOrder where MergedWOId = ?',[$mergedWO->Id]);
			$collection->put($mergedWO->Id,$subWOInfo);
		}
		
		$mergedWOInfos = DB::table('client_MergedWorkOrder')
							->join ('client_WorkOrder', 'client_MergedWorkOrder.Id', '=', 'client_WorkOrder.MergedWOId')
							->select('client_MergedWorkOrder.SenderAddress', 'client_WorkOrder.SenderAddress')
							->get('client_MergedWorkOrder.BatchNumber as MergedBatchNumber', 'client_WorkOrder.*');
		return view('womanagement',['allWoInfo' => $allWoInfo, 'woInfo' => $woInfo, 'collection' => $collection, 'mergedWOInfo'=>$mergedWOInfo]);
	}
	
	
	public function editWO(){
		if(Input::get('mergeWO')){
			$this->mergeWO();
		}
	}
	
	public function mergeWO(){
		$woIds = Input::get('checked');
		$mergedWOId = DB::select('select max(Id) Id from client_MergedWorkOrder')[0]->Id;
		$mergedWOId = $mergedWOId + 1;
		$woInfo = DB::select('select * from client_WorkOrder where Id = ?',[$woIds[0]])[0];
		$senderName = $woInfo -> SenderName;
		$senderPhone = $woInfo -> SenderPhoneNumber;
		$senderAddress = $woInfo -> SenderAddress;
		$receiverName = $woInfo -> ReceiverName;
		$receiverPhone = $woInfo -> ReceiverPhoneNumber;
		$receiverAddress = $woInfo -> ReceiverAddress;
		$email = $woInfo -> ReceiverEmail;
		$description = $woInfo -> Description;
		//$region = $request -> region;
		$cityId =$woInfo -> CityId;
		$stateId = $woInfo -> StateId;
		$zipCode = $woInfo -> ZipCode;
		$woCategoryId = $woInfo -> WOCategoryId;
		$woTypeId = $woInfo -> WOTypeId;
		$batchNumber = "HS".str_pad($cityId, 4, '0', STR_PAD_LEFT);
		$batchNumber = $batchNumber.date("ymd");
		$batchNumber = $batchNumber.str_pad($mergedWOId, 4, '0', STR_PAD_LEFT);
		$userId = session::get('userid');
		DB::insert('INSERT INTO client_MergedWorkOrder(Id, SenderName, SenderPhoneNumber, SenderAddress, ReceiverName, ReceiverPhoneNumber, ReceiverAddress, ReceiverEmail, 
							Description, CityId, StateId, ZipCode, WOCategoryId, WOTypeId, BatchNumber, StatusId, CreateDate, CreateUserId, ModifyDate)values
					(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,now(),?,now())',[$mergedWOId, $senderName, $senderPhone, $senderAddress, $receiverName, $receiverPhone, $receiverAddress, $email,
					$description, $cityId, $stateId, $zipCode, $woCategoryId, $woTypeId, $batchNumber, $userId]);
		foreach ($woIds as $woId){
			DB::update('update client_WorkOrder set MergedWOId = ? where Id = ?',[$mergedWOId, $woId]);
		}
	}
	
	
	public function checkLogin(Request $request){
		
		
		$username = $request->user;
		$user = sys_User::where('UserName','=', $username)->first();
		if ($user == null){
			echo '<script language="javascript">alert("用户名不存在，请重新输入！");</script>';
			echo '<script language="javascript">location.replace("./login");</script>';
		}
		else{
			$storedPwd = $user->Password;
			$inputPwd = $request->pwd;
			$userId = $user->Id;
			Session::put('userId',$userId);
			if ($storedPwd === md5($inputPwd)){
				return view('workorderindex', compact('userId'));
			}
			else{
				echo '<script language="javascript">alert("密码不正确，请重新输入！");</script>';
				echo '<script language="javascript">location.replace("./login");</script>';
			}
		}
	}
}
