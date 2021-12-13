<?php
$config=include('../../../../Conf/config.php');
$db = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pwd']);
$db->exec("set names utf8");
$db->exec("SET sql_mode=''");
$user = $_POST['uploaduser'];
$cookieid = $_POST['uploadcookieid'];
$num = $db->query("select count(*) from " . $config['db_prefix'] . "user where binary user='" . addslashes($user) . "'  and cookieid='" . addslashes($cookieid) . "' and status in (1,3,4) and complete=0")->fetchColumn();
if ($num == 1) {
    
} else {
    $num = $db->query("select count(*) from " . $config['db_prefix'] . "user where binary user='" . addslashes($user) . "' and status in (1,3,4) and complete=0")->fetchColumn();
    if ($num == 1) {
        echo '<script>alert("帐号已在其他设备登录过，请退出后重新登录");</script>';
        exit;
    } else {
        echo '<script>alert("请先登录！");</script>';
        exit;
    }
}
class Upload
{
    public $size = '';
    public $type = '';
    public $path = '';
    public $conf = '';
    public function __construct()
    {
        $this->type = array();
        $this->type2 = array();
        $this->conf = array();
    }
    public function upload_limit()
    {
		$hz = substr(strrchr($_FILES["file"]["name"],"."),1);  
        if (in_array($_FILES["file"]["type"], $this->type) && in_array(strtolower($hz),$this->type2) && ($_FILES["file"]["size"] < $this->size)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
            } else {
                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
                if (!file_exists($this->path)) {
                    mkdir($this->path);
                }
                if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    //list($font, $back) = explode(".", $_FILES["file"]["name"]);
                    $newpic = time() . "." . $hz;
                    move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $newpic);
                    $info = getimagesize($this->path . "/" . $newpic);
        						$ext = image_type_to_extension($info[2]);
        						if(stripos($this->type3,$ext)) {
        			if (stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') || stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
        			 	$mphoto = require("../../../../Conf/mobile.photo.config.php");
        			 	if($mphoto['mobile_photo_allow']){
						if ($info[0] >= $info[1] && $info[0] > $mphoto['mobile_pic_width']) {
				            $newwidth  = $mphoto['mobile_pic_width'];
				            $newheight = $newwidth * $info[1] / $info[0];
				        } else if ($info[1] >= $info[0] && $info[1] > $mphoto['mobile_pic_height']) {
				            $newheight = $mphoto['mobile_pic_height'];
				            $newwidth  = $newheight * $info[0] / $info[1];
				        } else {
				            $newwidth  = $info[0];
				            $newheight = $info[1];
				        }
				        $thumb = imagecreatetruecolor($newwidth, $newheight);
				        switch ($info[2])
				        {
				            case 1:
				                $source = imagecreatefromgif($this->path . "/" . $newpic);
				                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $info[0], $info[1]);
				                imagegif($thumb, $this->path . "/" . $newpic); 
				                break;
				            case 2:
				                $source = imagecreatefromjpeg($this->path . "/" . $newpic);
				                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $info[0], $info[1]);
				                imagejpeg($thumb, $this->path . "/" . $newpic); 
				                break;
				            case 3:
				                $source = imagecreatefrompng($this->path . "/" . $newpic);
				                imagesavealpha($source, true);
				                imagealphablending($thumb, false);
				                imagesavealpha($thumb, true);
				                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $info[0], $info[1]);				                
				                imagepng($thumb, $this->path . "/" . $newpic); 
				                break;
				            default:
				                break;
				        }
				        imagedestroy($thumb); 
				        imagedestroy($source); 
        				}
        			 }
        			 $info = getimagesize($this->path . "/" . $newpic);
        			 $water = require("../../../../Conf/water.config.php");
        			 if($info[0] >= $water['water_pic_width'] && $info[1] >= $water['water_pic_height'] && $water['water_allow']){
        			 	$nimage=imagecreatetruecolor($info[0],$info[1]); 
        			 	$white=imagecolorallocate($nimage,255,255,255);
        			 	$color = imagecolorallocate($nimage, 167 , 167 , 167); 
        			 	imagefill($nimage,0,0,$white);
        			 	switch ($info[2]) 
				       {
				            case 1: 
				            	$simage =imagecreatefromgif($this->path . "/" . $newpic); 
				            	break; 
				            case 2: 
					            $simage =imagecreatefromjpeg($this->path . "/" . $newpic); 
					            break; 
				            case 3: 
					            $simage =imagecreatefrompng($this->path . "/" . $newpic); 
					            break; 
				            default: 
				            	break;
				            exit; 
				        }
				        imagecopy($nimage,$simage,0,0,0,0,$info[0],$info[1]);
				        $fontfile = "../../../../Public/font/simfang.ttf";
				        $str = $water['water_str'];
				        imagettftext($nimage, 12, 0, 5, $info[1]-11, $color , $fontfile , $str); 
				        imagettftext($nimage, 12, 0, 5, $info[1]-10, $color , $fontfile , $str);
				        switch ($info[2]) 
				        {
				            case 1: 
				            imagegif($nimage, $this->path . "/" . $newpic); 
				            break; 
				            case 2: 
				            imagejpeg($nimage, $this->path . "/" . $newpic); 
				            break; 
				            case 3: 
				            imagepng($nimage, $this->path . "/" . $newpic); 
				            break; 
				        } 
				        imagedestroy($nimage); 
				        imagedestroy($simage); 
        			 }
                    echo "Stored in: " . $this->path . "/" . $newpic;
                    echo '<script>
                     if (parent.document.all) {
                				parent.document.getElementById("web_editor_con2").value += "[img=' . $this->conf['SITE'] . "/Public/upload/" . $newpic . '][/img]";
							        }else {
							            var obj = parent.document.getElementById("web_editor_con2");
							            var startPos = obj.selectionStart;
							            var endPos = obj.selectionEnd;
							             parent.document.getElementById("web_editor_con2").value = obj.value.substring(0, startPos) + "[img=' . $this->conf['SITE'] . "/Public/upload/" . $newpic . '][/img]" + obj.value.substring(endPos);
							        }</script>';
      						}else{
      								@unlink($this->path . "/" . $newpic);
        							echo "<script>alert('Invalid file');</script>";
        							exit;
      						}
                }
            }
        } else {
            echo "<script>alert('Invalid file');</script>";
        }        
    }
    public function upload()
    {
        if (isset($_FILES["file"]["tmp_name"])) {
            if (!file_exists($this->path)) {
                mkdir($this->path);
            }
            $filename = $_FILES["file"]["name"];
            if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $filename)) {
                    echo "upload success!";
                } else {
                    echo "upload fail!";
                }
            }
        }
    }
}

$up = new Upload();

$up->conf = $config;

$up->size = 5*1024*1024;

$up->path = "../../../../Public/upload";

$up->type = array(
	'image/jpg',
    'image/jpeg',
    'image/pjpeg',
    'image/gif',
    'image/png',
    'image/x-png'
);
$up->type2 = array(
    'jpg',
    'jpeg',
    'gif',
    'png'
);
$up->type3 = "|.jpeg|.gif|.png|.jpg";
$up->upload_limit();
?>