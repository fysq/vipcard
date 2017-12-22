<?php 

include "init.php";
$a = $a?$a:"home";

if(!in_array($a,array('log'))){
	if(!isset($_SESSION['vip_admin_login'])){
		// header("Location:".AROOT.":admin&a=log");
	}
}


switch ($a) {
	case 'home':

		include template("vipcard:admin/home");
		break;
	case 'log':
		include template("vipcard:admin/log");
		break;
	default:
		# code...
		break;
}



 ?>