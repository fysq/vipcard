<?php 
include "init.php";

$res = [];
$res['code']="0";
$res['msg']="error";

switch ($m) {
	case 'reg':
		$ex = DB::fetch_first("SELECT COUNT(uid) AS num FROM x_vipcard_uinfo WHERE phone = '$phone'");
		if($ex['num']=="0"){
			DB::query("INSERT INTO x_vipcard_uinfo VALUES('','$phone','$wxid','$uname','$phone','$sex','$birthday','0','0','0')");
			$res['code']="1";
			$res['msg']="激活成功";
		}else{
			$res['msg']="该手机号已经激活过，请勿重复激活。";
		}
		echo json_encode($res);
		break;
	case 'adminlog':
		$adminname = DB::fetch_first("SELECT val FROM x_vipcard_setting WHERE skey = 'adminname'");
		$adminpassword = DB::fetch_first("SELECT val FROM x_vipcard_setting WHERE skey = 'adminpassword'");
		if($adminname['val']==$username && $adminpassword['val'] ==$password){
			$res['code']="1";
			$res['msg']="登录成功";
		}else{
			$res['msg']="用户名密码不正确";
		}
		echo json_encode($res);
		break;
	default:
		# code...
		break;
}








?>