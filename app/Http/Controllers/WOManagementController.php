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
	
	public function getWOInfo($status = null,$wonum=null,$receiver=null,$city=null){
		$states = data_State::all();
		$userId = Session::get('userId');
		$woCategories = DB::select('select * from data_WOCategory');
		
		$woStatus = DB::select('select * from data_WOStatus');
		$allWoInfo = DB::table('client_WorkOrder')->get();
		
		$woInfo = DB::table('client_WorkOrder')
				-> leftJoin ('data_WOStatus', 'client_WorkOrder.StatusId','=','data_WOStatus.Id')
				-> leftJoin ('data_City','client_WorkOrder.CityId','=','data_City.Id')
				-> leftJoin ('data_WOType','client_WorkOrder.WOTypeId','=','data_WOType.Id')
				-> leftJoin ('data_WOCategory','client_WorkOrder.WOCategoryId','=','data_WOCategory.Id')
				-> select('data_WOCategory.Name as WOCategoryName','data_WOType.Name as WOTypeName','data_City.Name as CityName','data_WOStatus.Name as StatusName','client_WorkOrder.*');
		
		if($status != null){
			$woInfo->where('StatusId','=',$status);
		}
		if($wonum != null){
			$woInfo->where('WONum','=',$wonum);
		}
		if($receiver != null){
			echo $receiver;
			$woInfo->where('ReceiverName','=',$receiver);
		}
		if($city != null){
			$cityId= DB::select('select Id from data_City where Name = ?', [$city])[0]->Id;
			echo $cityId;
			$woInfo->where('CityId','=',$cityId);
		}
		
		$woInfo -> orderby('ModifyDate', 'desc');
		
		
		$woInfo= $woInfo->get();
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
		return view('womanagement',['allWoInfo' => $allWoInfo, 'woInfo' => $woInfo, 'collection' => $collection, 'mergedWOInfo'=>$mergedWOInfo,'woStatus'=>$woStatus, 'woCategories' => $woCategories
		, 'allState' => $states]);
	}
	
	
	
	public function searchWO(Request $request){
		$status = null;
		$wonum = null;
		$receiver = null;
		$city = null;
		if(isset($request->status)&&$request->status!=0){
			$status = $request->status;
		}
		else{
			$status = null;
		}
		

		if(isset($request->filter)){
			$filter = $request->filter;
			if($filter == 1){
				$wonum = $request->filter1;
			}
			if($filter == 2){
				$receiver = $request->filter1;
			}
			if($filter == 3){
				$city = $request->filter1;
			}
		}
		
		return $this->getWOInfo($status,$wonum,$receiver,$city);
	}
	
	
	
	public function editWO(Request $request){
		if(Input::get('mergeWO')){
			$this->mergeWO();
		}
		if(Input::get('quickUpdate')){
			$this->quickUpdate($request);
		}
		if(Input::get('updateWO')){
			echo "tets";
			$this->updateWO($request);
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

	public function quickUpdate(Request $request){
		//update weight, tracking number, woStatus

		$IdCount = $request -> WOCount;
		
		for($i=0; $i<$IdCount; $i++){
			$checkIndex = 'checked'.$i;
			if (!empty($request->$checkIndex)){
				$woId = $request->$checkIndex;
				$weightIndex = 'weight'.$i;
				$woStatusIndex = 'status'.$i;
				$weight = $request -> $weightIndex;
				$woStatus = $request -> $woStatusIndex;
				echo $woId;
				DB::update('update client_WorkOrder set Weight = ?, StatusId = ?, ModifyDate = now() where Id = ?',[$weight, $woStatus, $woId]);
			}
		}
		
// foreach($workOrderInfo as $workOrder){
		// if (!empty($_POST['checked'.$i])){
			// $weight = $_POST['weight'.$i];
			// $woType = $woTypeQuery -> getWOTypeByWOId($workOrder[0]);
			// //calculate price
			// if ($weight == 0){
				// $price = 0;
			// }
			// else if ($woType[0][0] == 1){ //标准货
				// if ($weight <= 20 ){
					// $price = 17.99 + ceil($weight - 1) * 8.99;
				// }
				// else{
					// $price = ceil($weight) * 7.99;
				// }
			// }
			// else if ($woType[0][0] == 2){ //非敏感货
				// if ($weight <= 20 ){
					// $price = 16.99 + ceil($weight - 1) * 6.99;
				// }
				// else if ($weight <= 42){
					// $price = ceil($weight) * 6.49;
				// }
				// else if ($weight <= 140){
					// $price = ceil($weight) * 5.99;
				// }
				// else {
					// $price = ceil($weight) * 5.49;
				// }
			// }
			// else {
				// $price = null;
				// //echo '<script language="javascript">alert("请选择货物类型");</script>';
			// }
			
			// $query -> updateWeightPrice($workOrder[1], $weight, $price, $userids[0][0]);
		// }
		
		// $i++;
	// }
	}
	
	public function updateWO(Request $request){
		//update all
		echo $wonum;
		$i = $request -> index;
			$wonum = $request -> wonum;
			
			// $senderName = $request -> senderName;
			// $senderPhone = $request -> senderPhone;
			// $senderAddress = $request -> senderAddress;
			// $receiverName = $request -> receiverName;
			// $receiverPhone = $request -> receiverPhone;
			// $receiverAddress = $request -> receiverAddress;
			// $email = $request -> email;
			// $description = $request -> description;
			// $cityId =$request -> city;
			// $stateId = $request -> state;
			// $zipCode = $request -> zipCode;
			// $woCategoryId = $request -> woCategory;
			// $woTypeId = DB::select('select WOTypeId from data_WOCategory where Id = ?',[$woCategoryId])[0]->WOTypeId;
			// $cityentity = DB::select('SELECT a.Id, a.Name, a.WONumOrder FROM data_City a WHERE Id = ?',[$cityId]);
			// foreach ($cityentity as $city){
				// if($city == null){
					// $woNumOrder = 0;
				// }
				// else{
					// $woNumOrder = $city->WONumOrder;
				// }
			// }
			
			
				// $woId = $request->$checkIndex;
				// $weightIndex = 'weight'.$i;
				// $woStatusIndex = 'status'.$i;
				// $weight = $request -> $weightIndex;
				// $woStatus = $request -> $woStatusIndex;
				// echo $woId;
				// DB::update('update client_WorkOrder set Weight = ?, StatusId = ?, ModifyDate = now() where Id = ?',[$weight, $woStatus, $woId]);

	}
}
