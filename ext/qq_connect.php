<?php
header("Content-type:text/html;charset=utf-8");
	include('./encrypt.php');
	$config=include('../Conf/config.php');
	define("url_site",$config['SITE']);
	$app_config=include('../Conf/qq.config.php');
  //应用的APPID
  $app_id = $app_config['app_id'];
  //应用的APPKEY
  $app_secret = $app_config['app_secret'];
  //成功授权后的回调地址
  $my_url = url_site."/ext/qq_connect.php";
 
  //Step1：获取Authorization Code
  session_start();
  $code = @$_REQUEST["code"];
  if(empty($code))
  {
     //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); 
     //拼接URL     
     $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'];
     echo("<script> top.location.href='" . $dialog_url . "'</script>");
  }
 
  //Step2：通过Authorization Code获取Access Token
  if($_REQUEST['state'] == $_SESSION['state']) 
  {
     //拼接URL   
     $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
     . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
     . "&client_secret=" . $app_secret . "&code=" . $code;
     $response = file_get_contents($token_url);
     if (strpos($response, "callback") !== false)
     {
        $lpos = strpos($response, "(");
        $rpos = strrpos($response, ")");
        $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        $msg = json_decode($response);
        if (isset($msg->error))
        {
           echo "<h3>error:</h3>" . $msg->error;
           echo "<h3>msg  :</h3>" . $msg->error_description;
           exit;
        }
     }
 
     //Step3：使用Access Token来获取用户的OpenID
     $params = array();
     parse_str($response, $params);
     $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
     $str  = file_get_contents($graph_url);
     if (strpos($str, "callback") !== false)
     {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
     }
     $user = json_decode($str);
     if (isset($user->error))
     {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
     }
     
      //get userInfo
     $graph_url="https://graph.qq.com/user/get_user_info?access_token="
     .$params['access_token']."&oauth_consumer_key=".$app_id
     ."&openid=".$user->openid."&format=json";
     $str  = file_get_contents($graph_url);
     $userInfo=json_decode($str);
     $user_id="qq_".$user->openid;
     $nick=addslashes(htmlspecialchars(trim($userInfo->nickname), ENT_QUOTES, "UTF-8"));
     $nick=mb_substr($nick,0,7,'utf-8');
  if(!empty($user->openid)){
		 $db = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pwd']);
		 $db->exec("set names utf8");
		 $db->exec("SET sql_mode=''");
     $sql = "SELECT * FROM ".$config['db_prefix']."user where openid='".$user_id."'";
     $res = $db->query($sql);
     $row_num = $db->query("SELECT COUNT(*) FROM ".$config['db_prefix']."user where openid='".$user_id."'")->fetchColumn();
     if ($row_num == 0){
     		if(mb_strlen($nick,'utf8')>7 || mb_strlen($nick,'utf8')<2){
		    	echo "用户名长度必须在2~7个字符之间";
		      	exit;
		    }
		    if(mb_substr($nick,0,1,'utf-8')==' '){
		    	echo "用户名首字符不能为空";
		      	exit;
		    }
		    if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$nick)){
		    	echo "QQ用户名中含有非法字符";
		    	exit;
		    }
		    $row_num_user = $db->query("SELECT COUNT(*) FROM ".$config['db_prefix']."user where user='".$nick."'")->fetchColumn();
     		if($row_num_user > 0){
     			echo "QQ用户名与当前系统已有的用户名重复，建议更改QQ用户名以完成注册。";
     			exit;
     		}else{
$url=$userInfo->figureurl_qq_2;
$curl = curl_init($url);
$time=time();
$filename = "../Public/pic/upload/".$time.".jpg";
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$imageData = curl_exec($curl);
curl_close($curl);
$tp = @fopen($filename, 'a');
fwrite($tp, $imageData);
fclose($tp);
$face="upload/".$time.".jpg";
       	 $sql="insert into ".$config['db_prefix']."user(user,pass,status,face,bid,user_group,openid,time) values('".$nick."','".cc_encrypt("")."','3','".$face."','100','".$config['default_user_group']."','".$user_id."',now())";
      	 $db->exec($sql);
      	 $_SESSION['youyax_user'] = $nick;
     		}
     }else{
     	 $arr = $res->fetch();
     	 if($arr['status'] == 2){
     	 	echo '当前所在的QQ账号已被禁言！';
     	 	exit;
     	 }else{
     	 	$_SESSION['youyax_user'] = $arr['user'];
     	 }
     }
     /*
     else{
     		$sql="update ".$config['db_prefix']."user set user='".$nick."' where openid='".$user_id."'";
     		mysql_query($sql);
    }*/
	 //login it
   $cookieid = md5(microtime(true));
   $db->exec("update " . $config['db_prefix'] . "user set cookieid='".$cookieid."' where user='".$_SESSION['youyax_user']."'");
   @setcookie('youyax_user',$_SESSION['youyax_user'],time()+(60*60*24*30),"/");
   @setcookie('youyax_cookieid',$cookieid,time()+(60*60*24*30),"/");
 	 }
 	 //echo '<script>window.location.href="'+url_site+'";</script>';
   header("location:".url_site);
	 // redirect it	 
  }
  else 
  {
     echo("The state does not match. You may be a victim of CSRF.");
  }
?>