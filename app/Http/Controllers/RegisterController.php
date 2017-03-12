<?php

namespace App\Http\Controllers;

use Session;
use File;
use App\Http\Controllers\PhpmailerController;
use Illuminate\Support\Facades\DB;
use App\client_WorkOrder;
use App\data_State;
use App\data_City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
{
	public function index(Request $request){
		$states = data_State::all();
		$woInfo = client_WorkOrder::all();
		$userId = Session::get('userId');
		$woCategories = DB::select('select * from data_WOCategory');
		$receivers = DB::select('select * from client_Receiver where CreateUserId = ?',[$userId]);
		return view('workorder',['allState' => $states, 'woInfo' => $woInfo, 'receivers' => $receivers, 'woCategories' => $woCategories]);
	}
	
	
	public function registerUser(Request $request){
		$userName = stripslashes(trim($request->userName));
		$num = DB::select('select count(1) Num from sys_User where username = ?', [$userName])[0]->Num;
		
		if(!empty($request->contract)){

			//检测用户名是否存在
			if($num>=1){
				echo '<script>alert("用户名已存在，请换个其他的用户名");window.history.go(-1);</script>';
				exit;
			}
			$password = md5(trim($request->password));
			$email = trim($request->email);
			$createdate = time();

			$token = md5($userName.$password.$createdate); //创建用于激活识别码
			$token_exptime = time()+60*30;//过期时间为30min
			
			DB::insert('insert into sys_User(UserName,Password,Email,Token,Token_exptime,CreateDate, PwdUpdated) values( ?,?,?,?,?,now(),1)',[$userName,$password,$email,$token,$token_exptime]);
			
			$newUser=DB::select('select count(1) Num from sys_User where UserName = ?', [$userName])[0]->Num;
if($newUser==1){//写入成功，发邮件
	 
	$mail = new PhpmailerController(); //实例化 
	$mail->IsSMTP(); // 启用SMTP 
	$mail->SMTPSecure = "tls";
	$mail->Host = "smtp.gmail.com"; //SMTP服务器
	$mail->Port = 587;  //邮件发送端口 
	$mail->SMTPAuth   = true;  //启用SMTP认证 
	 
	$mail->CharSet  = "UTF-8"; //字符集 
	$mail->Encoding = "base64"; //编码方式 
	 
	$mail->Username = "yhuspothero4@gmail.com";  //你的邮箱 
	$mail->Password = "sms123456";  //你的密码 
	$mail->Subject = "你好"; //邮件标题 
	 
	$mail->From = "yhuspothero4@gmail.com";  //发件人地址（也就是你的邮箱） 
	$mail->FromName = "test";  //发件人姓名 
	 
	$address = $email;//收件人email 
	$mail->AddAddress($address, "亲");//添加收件人（地址，昵称） 
	 
//	$mail->AddAttachment('xx.xls','我的附件.xls'); // 添加附件,并指定名称 
	$mail->IsHTML(true); //支持html格式内容 
//	$mail->AddEmbeddedImage("logo.jpg", "my-attach", "logo.jpg"); //设置邮件中的图片 
	$mail->Body = "亲爱的".$userName."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/> 
    <a href='localhost/howdy/active.php?verify=".$token."' target= 
'_blank'>localhost/howdy/active.php?verify=".$token."</a><br/> 
    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接30分钟内有效。";  //邮件主体内容 
	 
	//发送 
	if(!$mail->Send()) { 
	  echo "Mailer Error: " . $mail->ErrorInfo; 
	} else { 
	  echo "Message sent!"; 
	} 
}
}
else {
	echo '<script>alert("您必须同意用户协议。");window.history.go(-1);</script>';
}
	}
	
	

}
