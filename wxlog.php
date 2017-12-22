<?php 
session_start();
// aaa
// $wx_log_type_want = "1" == "1"?"snsapi_userinfo":"snsapi_base";
// $wx_res = $_SESSION['loveshang_wx_res'];
// $wx_log_type_had = empty($wx_res['type'])?$wx_log_type_want:$wx_res['type'];
// if(empty($wx_res) || $wx_log_type_had != $wx_log_type_want){
//     $url_this = "http://".$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//     $url_this1 = urlencode($url_this);
//   	get_userinfo($url_this1,$wx_log_type_want);
//   }
// function get_userinfo($url,$scope,$dealurl=""){
//   $dealurl=$dealurl?:"http://a.zjglsw.com/plugin.php?id=eat_act:wxtrans_v2";
// 	echo "<script>";
// 	echo "location.href='".$dealurl."&state=".$url."&scope=".$scope."'";
// 	echo "</script>";
// }


$wx_res = Array(
    'openid' => 'o-MQIuHyjJdknxd7tfBDdcTMXvSI',
    'nickname' => '是短发是',
    'sex' => '1',
    'language' => 'zh_CN',
    'city' => 'Wuxi',
    'province' => 'Jiangsu',
    'country' => 'CN',
    'headimgurl' => 'http://wx.qlogo.cn/mmopen/aAHv0PkAj4kuLic0UqTfX8jXjzYBNOicgRxp3P3VEXxE3Yn70bWk7bHtjCTQ58xYuOrHdLvYRcCDRZYcLFBiakwprBpFBoKYwq8/132',
    'privilege' => Array
        (
        )
	);
 ?>
