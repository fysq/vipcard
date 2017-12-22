<?php 

include "wxlog.php";
include "init.php";


$a=$a?$a:"home";

switch ($a) {
	case 'home':
		$uinfo = DB::fetch_first("SELECT * FROM x_vipcard_uinfo WHERE wxid = '$wx_res[openid]'");
		if(count($uinfo)=="0"){
			header("Location:".AROOT."&a=reg");
			exit;
		}
		include template("vipcard:app/home");
		break;
	case 'reg':
		$uinfo = DB::fetch_first("SELECT * FROM x_vipcard_uinfo WHERE wxid = '$wx_res[openid]'");
		if(count($uinfo)!="0"){
			header("Location:".AROOT."&a=home");
			exit;
		}
		include template("vipcard:app/reg");
		break;
	default:
		# code...
		break;
}






?>