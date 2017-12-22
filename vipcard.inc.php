<?php 

include "wxlog.php";
include "init.php";


$a=$a?$a:"home";

switch ($a) {
	case 'home':
		$uinfo = DB::fetch_first("SELECT * FROM m_vipcard_uinfo WHERE wxid = '$wx_res[openid]'");
		if(count($uinfo)=="0"){
			header("Location:".AROOT."&a=reg");
			exit;
		}
		include template("vipcard:app/home");
		break;
	case 'reg':
		$uinfo = DB::fetch_first("SELECT * FROM m_vipcard_uinfo WHERE wxid = '$wx_res[openid]'");
		if(count($uinfo)!="0"){
			header("Location:".AROOT."&a=home");
			exit;
		}
		include template("vipcard:app/reg");
		break;
	case 'recharge':
	case 'consume':
		$acttype = $a;
		$uinfo = DB::fetch_first("SELECT * FROM m_vipcard_uinfo WHERE uid = '$uid'");
		$admininfo = DB::fetch_first("SELECT * FROM m_vipcard_uinfo WHERE wxid = '$wx_res[openid]'");
		$isadmin  = DB::fetch_first("SELECT COUNT(id) AS num FROM m_vipcard_setting WHERE skey='adminlist' AND val LIKE '%".$admininfo['phone']."%'");
		include template("vipcard:app/wxscan");
		break;
	default:
		# code...
		break;
}






?>