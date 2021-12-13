<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include('../encrypt.php');
$config=include('../../Conf/config.php');
define("url_site",$config['SITE']);
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	//$_SESSION['token'] = $token;
	//setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
	$ms  = $c->home_timeline(); // done
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
	if(!empty($uid)){
		 $db = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pwd']);
		 $db->exec("set names utf8");
		 $db->exec("SET sql_mode=''");
     $sql = "SELECT * FROM ".$config['db_prefix']."user where weiboid='".$uid."'";
     $res = $db->query($sql);
     $row_num = $db->query("SELECT COUNT(*) FROM ".$config['db_prefix']."user where weiboid='".$uid."'")->fetchColumn();
     if ($row_num == 0){
     		if(mb_strlen($user_message['name'],'utf8')>7 || mb_strlen($user_message['name'],'utf8')<2){
		    	echo "用户名长度必须在2~7个字符之间";
		      	exit;
		    }
		    if(mb_substr($user_message['name'],0,1,'utf-8')==' '){
		    	echo "用户名首字符不能为空";
		      	exit;
		    }
		    if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$user_message['name'])){
		    	echo "微博用户名中含有非法字符";
		    	exit;
		    }
		    $row_num_user = $db->query("SELECT COUNT(*) FROM ".$config['db_prefix']."user where user='".$user_message['name']."'")->fetchColumn();
     		if($row_num_user > 0){
     			echo "微博用户名与当前系统已有的用户名重复，建议更改微博用户名以完成注册。";
     			exit;
     		}else{
$url=$user_message['avatar_large'];
$curl = curl_init($url);
$time=time();
$filename = "../../Public/pic/upload/".$time.".jpg";
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$imageData = curl_exec($curl);
curl_close($curl);
$tp = @fopen($filename, 'a');
fwrite($tp, $imageData);
fclose($tp);
 list($width, $height) = getimagesize($filename);
        if ($width >= $height && $width > 120) {
            $newwidth  = 120;
            $newheight = $newwidth * $height / $width;
        } else if ($height >= $width && $height > 120) {
            $newheight = 120;
            $newwidth  = $newheight * $width / $height;
        } else {
            $newwidth  = $width;
            $newheight = $height;
        }
        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($thumb, $filename);     
	   $face="upload/".$time.".jpg";
        $sql="insert into ".$config['db_prefix']."user(user,pass,status,face,bid,user_group,weiboid,time) values('".$user_message['name']."','".cc_encrypt("")."','4','".$face."','100','".$config['default_user_group']."','".$uid."',now())";
        $db->exec($sql);
        $_SESSION['youyax_user'] = $user_message['name'];
      }
     }else{
     	 $arr = $res->fetch();
     	 if($arr['status'] == 2){
     	 	echo '当前所在的微博账号已被禁言！';
     	 	exit;
     	 }else{
     	 	$_SESSION['youyax_user'] = $arr['user'];
     	 }
     }
     /*
     else{
     		$sql="update ".$config['db_prefix']."user set user='".$user_message['name']."' where openid='".$user_id."'";
     		mysql_query($sql);
    }*/
	 //login it
   $cookieid = md5(microtime(true));
   $db->exec("update " . $config['db_prefix'] . "user set cookieid='".$cookieid."' where user='".$_SESSION['youyax_user']."'");
   @setcookie('youyax_user',$_SESSION['youyax_user'],time()+(60*60*24*30),"/");
   @setcookie('youyax_cookieid',$cookieid,time()+(60*60*24*30),"/");	
	}
	header("location:".url_site);
} else {
?>
授权失败。
<?php
}
?>
