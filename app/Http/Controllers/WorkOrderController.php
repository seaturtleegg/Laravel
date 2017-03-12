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

class WorkOrderController extends Controller
{
	public function index(Request $request){
		$states = data_State::all();
		$woInfo = client_WorkOrder::all();
		$userId = Session::get('userId');
		$woCategories = DB::select('select * from data_WOCategory');
		$receivers = DB::select('select * from client_Receiver where CreateUserId = ?',[$userId]);
		return view('workorder',['allState' => $states, 'woInfo' => $woInfo, 'receivers' => $receivers, 'woCategories' => $woCategories]);
	}
	
	public function getCity(){
		$stateId = Input::get('stateId');
		
		$city = data_City::where('stateId','=',$stateId)->get();
		
		return \Response::json($city);
	}

	
	public function createWO(Request $request){
		$wonum = $request -> wonum;
		$senderName = $request -> senderName;
		$senderPhone = $request -> senderPhone;
		$senderAddress = $request -> senderAddress;
		$receiverName = $request -> receiverName;
		$receiverPhone = $request -> receiverPhone;
		$receiverAddress = $request -> receiverAddress;
		$email = $request -> email;
		$description = $request -> description;
		//$region = $request -> region;
		$cityId =$request -> city;
		$stateId = $request -> state;
		$zipCode = $request -> zipCode;
		$woCategoryId = $request -> woCategory;
		$woTypeId = DB::select('select WOTypeId from data_WOCategory where Id = ?',[$woCategoryId])[0]->WOTypeId;
		$cityentity = DB::select('SELECT a.Id, a.Name, a.WONumOrder FROM data_City a WHERE Id = ?',[$cityId]);
		foreach ($cityentity as $city){
			if($city == null){
				$woNumOrder = 0;
			}
			else{
				$woNumOrder = $city->WONumOrder;
			}
		}
		$batchNumber = "HS".str_pad($cityId, 4, '0', STR_PAD_LEFT);
		$batchNumber = $batchNumber.date("ymd");
		$batchNumber = $batchNumber.str_pad($woNumOrder, 4, '0', STR_PAD_LEFT);
		$userId = Session::get('userId');
		DB::insert('INSERT INTO client_WorkOrder(WONum, SenderName, SenderPhoneNumber, SenderAddress, ReceiverName, ReceiverPhoneNumber, ReceiverAddress, ReceiverEmail, 
							Description, CityId, StateId, ZipCode, WOCategoryId, WOTypeId, BatchNumber, StatusId, CreateDate, CreateUserId, ModifyDate)values
					(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,now(),?,now())',[$wonum, $senderName, $senderPhone, $senderAddress, $receiverName, $receiverPhone, $receiverAddress, $email,
					$description, $cityId, $stateId, $zipCode, $woCategoryId, $woTypeId, $batchNumber, $userId]);
		$woNumOrder = $woNumOrder+1;	
		DB::update('UPDATE data_City SET WONumOrder = ? where Id = ?',[$woNumOrder, $cityId]);	

		
		if (!empty($request -> saveReceiver)){
			DB::insert('INSERT INTO client_Receiver(Name, Address, PhoneNumber, Email, CityId, StateId, ZipCode, CreateDate, CreateUserId) values (?,?,?,?,?,?,?,now(),?)',
			[$receiverName, $receiverAddress, $receiverPhone, $email, $cityId, $stateId, $zipCode, $userId]);
		}
		
		return app('App\Http\Controllers\WOManagementController')->getWOInfo();;
	}
	
	
	
	
	
	public function uploadWO(Request $request){
		if(Input::hasFile('file')){
		$filename=$_FILES["file"]["tmp_name"];
		$file = $_FILES['file']['tmp_name'];
		$handle = fopen($file, "r");
		$c = 0;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{
			if ($c > 0){
				$wonum = $filesop[0];
				$senderName = "test";
				$senderPhone = 123456789;
				$senderAddress = "test";
				$receiverName = $filesop[2];
				$receiverPhone = $filesop[3];
				$receiverAddress = $filesop[4];
				$email = $filesop[8];
				$description = "test";
				$cityId = DB::select('select Id from data_City where Name = ?',[$filesop[6]])[0]->Id;
				$stateId = DB::select('select Id from data_State where Name = ?',[$filesop[5]])[0]->Id;
				$zipCode = $filesop[7];
				echo $filesop[1];
				echo $cityId;
				$woCategoryId = DB::select('select Id from data_WOCategory where Name = ?',[$filesop[1]])[0]->Id;
				if ($woCategoryId == ''){
					$woCategoryId = "null";
					$woTypeId = 'null';
				}
				else{
					$woTypeId = DB::select('select WOTypeId from data_WOCategory where Id = ?',[$woCategoryId])[0]->WOTypeId;
				}
				foreach ($cityentity as $city){
					if($city == null){
						$woNumOrder = 0;
					}
					else{
						$woNumOrder = $city->WONumOrder;
					}
				}
				$batchNumber = "HS".str_pad($cityId, 4, '0', STR_PAD_LEFT);
				$batchNumber = $batchNumber.date("ymd");
				$batchNumber = $batchNumber.str_pad($woNumOrder, 4, '0', STR_PAD_LEFT);
				$userId = Session::get('userId');
				DB::insert('INSERT INTO client_WorkOrder(WONum, SenderName, SenderPhoneNumber, SenderAddress, ReceiverName, ReceiverPhoneNumber, ReceiverAddress, ReceiverEmail, 
									Description, CityId, StateId, ZipCode, WOCategoryId, WOTypeId, BatchNumber, StatusId, CreateDate, CreateUserId, ModifyDate)values
							(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,now(),?,now())',[$wonum, $senderName, $senderPhone, $senderAddress, $receiverName, $receiverPhone, $receiverAddress, $email,
							$description, $cityId, $stateId, $zipCode, $woCategoryId, $woTypeId, $batchNumber, $userId]);
				$woNumOrder = $woNumOrder+1;	
				DB::update('UPDATE data_City SET WONumOrder = ? where Id = ?',[$woNumOrder, $cityId]);
			}
			$c = $c + 1;
		}
		
			if($c!=0){
				echo "Success! You have uploaded ". $c ." recoreds";
			}else{
				echo "Sorry! There is some problem.";
			}

	}
	}

	

}
