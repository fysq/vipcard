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



$list = DB::fetch_all("SELECT * FROM m_vipcard_setting");
$setting = array();
foreach ($list as $k => $v) {
	$setting[$v['skey']]=$v['val'];
}
$setting['vipsetting'] = unserialize($setting['vipsetting']);
function adminimgupload($name,$src){
	if($src==""){$src="./source/plugin/vipcard/images/icon.jpg";}
	$res = '';
	$res.= '<img alt="" class="previmg" src="'.$src.'" height="80px">';
	$res.= '<input id="'.$name.'" name="'.$name.'" type="file" class="hide upload" data-class="'.$name.'" onchange="preview(this)">';
	$res.= '<input type="hidden"  class="'.$name.'" value="'.$src.'">';
	return $res;
}

 ?>
