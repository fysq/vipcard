<?php 
include "init.php";

$res = [];
$res['code']="0";
$res['msg']="error";


switch ($m) {
	case 'reg':
		$ex = DB::fetch_first("SELECT COUNT(uid) AS num FROM m_vipcard_uinfo WHERE phone = '$phone'");
		if($ex['num']=="0"){
			DB::query("INSERT INTO m_vipcard_uinfo VALUES('','$phone','$wxid','$uname','$phone','$sex','$birthday','0','0','0','".time()."','0')");
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
			$lscode = "C".date('ymdHis').mt_rand('1000','9999');
			DB::query("INSERT INTO m_vipcard_chargelist VALUES ('','admin_cz','$uid','$adminid','$cznum','0','$cztype','".time()."','$lscode')");
			DB::query("UPDATE m_vipcard_uinfo SET balance = balance + $cznum WHERE uid = '$uid'");
			$res['code']="1";
			$res['msg']="充值成功";
			echo json_encode($res);
		break;
	case 'scanxf':
			$balance = DB::fetch_first("SELECT balance FROM m_vipcard_uinfo WHERE uid = '$uid'");
			if($balance['balance']>=$consumenum){
				$lscode = "P".date('ymdHis').mt_rand('1000','9999');
				$balance = $balance['balance']-$consumenum;
				$point = floor($consumenum/$setting['pointbl']);
				DB::query("UPDATE m_vipcard_uinfo SET balance = balance - $consumenum,point_all = point_all+$point,point_left = point_left+$point WHERE uid = '$uid'");
				DB::query("INSERT INTO m_vipcard_chargelist VALUES ('','admin_xf','$uid','$adminid','-$consumenum','$point','余额消费','".time()."','$lscode')");
				$res['code']="1";
				$res['msg']="余额消费成功";
			}else{
				$res['msg']="余额不足";
			}
			echo json_encode($res);
		break;
	case 'fukuancode':
			$res['code']="1";
			$res['msg']=urlencode(dirname($_SERVER['HTTP_REFERER'])."/plugin.php?id=vipcard&a=consume&uid=".$uid);
			echo json_encode($res);
		break;
	case 'chargecode':
			$res['code']="1";
			$res['msg']=urlencode(dirname($_SERVER['HTTP_REFERER'])."/plugin.php?id=vipcard&a=recharge&uid=".$uid);
			echo json_encode($res);
		break;
	case 'editshopinfo':
			DB::query("UPDATE m_vipcard_setting SET val = '$shopinfo' WHERE skey = 'shopinfo'");
			$res['code']="1";
			$res['msg']="编辑成功";
			echo json_encode($res);
		break;
	case 'editbase':
			DB::query("UPDATE m_vipcard_setting SET val = '$cardname' WHERE skey = 'cardname'");
			DB::query("UPDATE m_vipcard_setting SET val = '$pointbl' WHERE skey = 'pointbl'");
			DB::query("UPDATE m_vipcard_setting SET val = '$shopname' WHERE skey = 'shopname'");
			DB::query("UPDATE m_vipcard_setting SET val = '$shopaddress' WHERE skey = 'shopaddress'");
			DB::query("UPDATE m_vipcard_setting SET val = '$cardbg' WHERE skey = 'cardbg'");
			DB::query("UPDATE m_vipcard_setting SET val = '$cardlogo' WHERE skey = 'cardlogo'");
			$res['code']="1";
			$res['msg']="编辑成功";
			echo json_encode($res);
		break;
	case 'uploadimg':
		$obj = array();
		$id= $_POST["fid"];
		$randname = date("YmdHis",time()).mt_rand(10,99);
		$imgtype = substr(strrchr($_FILES[$id]['name'], '.'), 1);
		// $upFilePath = "http://localhost/dz32u/".PROOT."attachment/".$randname.".".$imgtype;
		$upFilePath = dirname(__FILE__)."/attachment/".$randname.".".$imgtype;
		$ok=move_uploaded_file($_FILES[$id]['tmp_name'],$upFilePath);
		 if($ok === FALSE){
		  $obj['statue']='0';
		  $obj['msg']=$_FILES;
		 }else{
		  $obj['statue']='1';
		  $obj['url']='http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/".PROOT."attachment/".$randname.".".$imgtype;
		 }
		  echo json_encode($obj);
		  exit;
		break;
	case 'editadmin':
			DB::query("UPDATE m_vipcard_setting SET val = '$adminname' WHERE skey = 'adminname'");
			if($adminpassword){
				DB::query("UPDATE m_vipcard_setting SET val = '$adminpassword' WHERE skey = 'adminpassword'");
			}
			$res['code']="1";
			$res['msg']="编辑成功";
			echo json_encode($res);
		break;
	case 'editvip':
		unset($_POST['m']);
		$vipsetting = serialize($_POST);
		DB::query("UPDATE m_vipcard_setting SET val = '$vipsetting' WHERE skey = 'vipsetting'");
		$res['code']="1";
		$res['msg']="编辑成功";
		echo json_encode($res);
		break;
	default:
		echo json_encode($_POST);
		break;
}








?>