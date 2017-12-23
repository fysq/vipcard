<?php 

include "init.php";
$a = $a?$a:"home";

if(!in_array($a,array('log'))){
	if(!isset($_SESSION['vip_admin_login'])){
		header("Location:".AROOT.":admin&a=log");
	}
}

$page = $page?$page:"1";
$pagesize = "20";
$limit = " LIMIT ".($page-1)*$pagesize.",".$pagesize." ";

switch ($a) {
	case 'home':
		include template("vipcard:admin/home");
		break;
	case 'log':
		include template("vipcard:admin/log");
		break;
	case 'logout':
		unset($_SESSION['vip_admin_login']);
			header("Location:".AROOT.":admin&a=log");
		break;
	case 'user':
		$list = DB::fetch_all("SELECT * FROM m_vipcard_uinfo ORDER BY addtime DESC");
		include template("vipcard:admin/".$a);
		break;
	case 'setting':
		$list = DB::fetch_all("SELECT * FROM m_vipcard_setting");
		$setting = array();
		foreach ($list as $k => $v) {
			$setting[$v['skey']]=$v['val'];
		}
		include template("vipcard:admin/".$a);
		break;
	case 'recharge':
		$list  = DB::fetch_all("SELECT a.*,b.* FROM m_vipcard_chargelist a LEFT JOIN m_vipcard_uinfo b ON a.uid=b.uid ORDER BY a.addtime DESC"); 
		$allin = DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum>0"); 
		$allpay= DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum<0");
		include template("vipcard:admin/".$a);
		break;
	case 'panel':
		$today = strtotime(date("Y-m-d"));
		$allusernum = DB::fetch_first("SELECT COUNT(uid) AS num FROM m_vipcard_uinfo");
		$todayusernum = DB::fetch_first("SELECT COUNT(uid) AS num FROM m_vipcard_uinfo WHERE addtime>'$today'");

		$allcin = DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum > 0");
		$todayin= DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum > 0 AND  addtime>'$today'");

		$allcpay = DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum < 0");
		$todaypay= DB::fetch_first("SELECT SUM(cnum) AS num FROM m_vipcard_chargelist WHERE cnum < 0 AND  addtime>'$today'");
		include template("vipcard:admin/".$a);
		break;
	default:
		include template("vipcard:admin/".$a);
		break;
}



 ?>