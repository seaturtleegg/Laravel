<?php

namespace App\Http\Controllers;

use App\sys_User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Session;

class LoginController extends Controller
{
	public function index(){
		$users = \DB::table('sys_User')->get();
		echo $users->Password;
	}
	
	
	public function checkLogin(Request $request){
		
		$this->validate($request, [
			'userName' => 'required',
			'password' => 'required'
		]);
		
		$username = $request->userName;
		$user = sys_User::where('UserName','=', $username)->first();
		if ($user == null){
			echo '<script language="javascript">alert("用户名不存在，请重新输入！");</script>';
			echo '<script language="javascript">location.replace("./login");</script>';
		}
		else{
			$storedPwd = $user->Password;
			$inputPwd = $request->password;
			$userId = $user->Id;
			$userRoles = DB::select('select * from sys_UserRole where UserId = ?',[$userId]);
			$userName = DB::select('select UserName from sys_User where Id = ?',[$userId])[0]->UserName;
			//Session::put('userId',$userId);
			Session::put(['userId'=>$userId, 'userRoles'=>$userRoles, 'userName'=>$userName]);
			//Session::set('userRoles',$userRoles);
			if ($storedPwd === md5($inputPwd)){
				return view('workorderindex', compact('userId','userRoles'));
			}
			else{
				echo '<script language="javascript">alert("密码不正确，请重新输入！");</script>';
				echo '<script language="javascript">location.replace("./login");</script>';
			}
		}
		return redirect()->intended('login');
	}
}
