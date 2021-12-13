<?php
header('Content-Type: text/html; charset=UTF-8');
$weiconf=require("../../Conf/weibo.config.php");
define( "WB_AKEY" ,  $weiconf['app_id']);
define( "WB_SKEY" ,  $weiconf['app_secret']);
define( "WB_CALLBACK_URL" ,  $weiconf['callback']);
?>