<?php 
include "init.php";

$res = [];
$res['code']="0";
$res['msg']="error";

switch ($m) {
	case 'reg':
		$ex = DB::fetch_first("SELECT COUNT(uid) AS num FROM m_vipcard_uinfo WHERE phone = '$phone'");
		if($ex['num']=="0"){
			DB::query("INSERT INTO m_vipcard_uinfo VALUES('','$phone','$wxid','$uname','$phone','$sex','$birthday','0','0','0','".time()."','1')");
			$res['code']="1";
			$res['msg']="激活成功";
		}else{
			$res['msg']="该手机号已经激活过，请勿重复激活。";
		}
		echo json_encode($res);
		break;
	case 'adminlog':
		$adminname = DB::fetch_first("SELECT val FROM m_vipcard_setting WHERE skey = 'adminname'");
		$adminpassword = DB::fetch_first("SELECT val FROM m_vipcard_setting WHERE skey = 'adminpassword'");
		if($adminname['val']==$username && $adminpassword['val'] ==$password){
			$res['code']="1";
			$res['msg']="登录成功";
			$_SESSION['vip_admin_login']="1";
		}else{
			$res['msg']="用户名密码不正确";
		}
		echo json_encode($res);
		break;
	case 'addadminphone':
		$ex = DB::fetch_first("SELECT COUNT(uid) AS num FROM m_vipcard_uinfo WHERE phone = '$addphone'");
		if($ex['num']=="0"){
			$res['msg']="用户不存在，请先激活会员卡";
		}else{
			$list = DB::fetch_first("SELECT val FROM m_vipcard_setting WHERE skey = 'adminlist'");
			if(in_array($addphone,array_filter(explode("|",$list['val'])))){
				$res['msg']="管理员已存在";
			}else{
				$val = $list['val'] . "|" . $addphone;
				DB::query("UPDATE m_vipcard_setting SET val = '$val' WHERE skey = 'adminlist'");
				$res['code']="1";
				$res['msg']="新增管理员成功";
			}
		}
		echo json_encode($res);
		break;
	case 'deladminphone':
		$list = DB::fetch_first("SELECT val FROM m_vipcard_setting WHERE skey = 'adminlist'");
		$list = array_filter(explode("|",$list['val']));
		$val = array_merge(array_diff($list, array($delphone)));
		$val = join("|",$val);
		DB::query("UPDATE m_vipcard_setting SET val = '$val' WHERE skey = 'adminlist'");
		$res['code']="1";
		$res['msg']="删除管理员成功";
		echo json_encode($res);
		
		break;
	case 'scancz':
			DB::query("INSERT INTO m_vipcard_chargelist VALUES ('','admin_cz','$uid','$adminid','$cznum','0','$cztype','".time()."')");
			// $balance = DB::fetch_first('')
			DB::query("UPDATE m_vipcard_uinfo SET balance = balance + $cznum WHERE uid = '$uid'");
			$res['code']="1";
			$res['msg']="充值成功";
			echo json_encode($res);
		break;
	case 'scanxf':
			$balance = DB::fetch_first("SELECT balance FROM m_vipcard_uinfo WHERE uid = '$uid'");
			if($balance['balance']>=$consumenum){
				$balance = $balance['balance']-$consumenum;
				$point = floor($consumenum/$pointbl);
				DB::query("UPDATE m_vipcard_uinfo SET balance = balance - $consumenum,point_all = point_all+$point,point_left = point_left+$point WHERE uid = '$uid'");
				DB::query("INSERT INTO m_vipcard_chargelist VALUES ('','admin_xf','$uid','$adminid','$consumenum','$point','余额消费','".time()."')");
				$res['code']="1";
				$res['msg']="余额消费成功";
			}else{
				$res['msg']="余额不足";
			}
			echo json_encode($res);
		break;
	default:
		echo json_encode($_POST);
		break;
}








?>