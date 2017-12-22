<?php 

if(!defined("IN_DISCUZ")){
	exit("!");
}
session_start();
foreach ($_GET as $key => $value) {
	$$key = $value;
}

foreach ($_POST as $key => $value) {
	$$key = $value;
}

define("PNAME","vipcard");
define("PROOT","./source/plugin/".PNAME."/");
define("AROOT","plugin.php?id=".PNAME);

define("AJAX",AROOT.":deal");


define("CARD_NAME","会员卡");
 ?>
