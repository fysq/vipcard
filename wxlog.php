<?php 
session_start();
// session_destroy();
// var_dump($_SESSION);
// exit();
define("APPID","wxc2b4906541e812c6");
define("SECRET","b702f0cd52f11f13668e52450969a6ac");
// define("SCOPE","snsapi_base");
define("SCOPE","snsapi_userinfo");

$wx_res = $_SESSION['loveshang_wx_res'];
$wx_log_type_now = empty($wx_res['type'])?SCOPE:$wx_res['type'];

if(empty($wx_res) || $wx_log_type_now != SCOPE){
    $url_this = "http://".$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $url_this1 = urlencode($url_this);
    $code = $_GET["code"];

     if(!$code){
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=";
         $url.= $url_this1;
         $url.="&response_type=code&scope=".SCOPE."&state=".$url_this1."#wechat_redirect";
         echo "<script language='javascript'>";
         echo "location.href='".$url."'";
         echo "</script>";
        exit;
     }

     $url = sprintf("https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code",APPID,SECRET,$code);
     $res = file_get_contents($url);
     $res = json_decode($res,true);
    if(SCOPE != "snsapi_base"){
         $url = sprintf("https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s",$res["access_token"],$res["openid"]);
         $res = file_get_contents($url);
         $res = json_decode($res, true);
    }

    $res['type'] = SCOPE;
    $_SESSION['loveshang_wx_res'] = $res;
    header("Location:".$state);
}

// print_r($wx_res);exit;
// $wx_res = Array(
//     'openid' => 'o-MQIuHyjJdknxd7tfBDdcTMXvSI',
//     'nickname' => '是短发是',
//     'sex' => '1',
//     'language' => 'zh_CN',
//     'city' => 'Wuxi',
//     'province' => 'Jiangsu',
//     'country' => 'CN',
//     'headimgurl' => 'http://wx.qlogo.cn/mmopen/aAHv0PkAj4kuLic0UqTfX8jXjzYBNOicgRxp3P3VEXxE3Yn70bWk7bHtjCTQ58xYuOrHdLvYRcCDRZYcLFBiakwprBpFBoKYwq8/132',
//     'privilege' => Array
//         (
//         )
// 	);
 ?>
