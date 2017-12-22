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
	default:
		include template("vipcard:admin/".$a);
		break;
}



 ?>