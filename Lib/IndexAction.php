<?php
class IndexAction extends YouYaX
{
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        if (empty($_SESSION['youyax_user']) && isset($_COOKIE['youyax_user']) && preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $_COOKIE['youyax_user']) && preg_match("/^[A-Za-z0-9]+$/u", $_COOKIE['youyax_cookieid'])) {
            if ($this->find($this->C('db_prefix') . "user", 'string', "user='" . addslashes($_COOKIE['youyax_user']) . "' and cookieid='" . addslashes($_COOKIE['youyax_cookieid']) . "'")) {
                $_SESSION['youyax_user'] = $_COOKIE['youyax_user'];
            }
        }
        if (empty($_SESSION['youyax_user']) && !stristr($_SERVER['HTTP_USER_AGENT'], 'android') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
            $cache = new CacheAction(60);
        }
        if (isset($_SESSION['youyax_user'])) {
            $user = $_SESSION['youyax_user'];
        } else {
            $_SESSION['youyax_user'] = "";
            $user                    = "";
        }
        $this->assign('user', $user);
        $tongji = CommonAction::tongji();
        $this->assign('count', $tongji);
        $todaynum = 0;
        $tiezinum = 0;
        $usernum  = 0;
        $sql_user = "select * from " . $this->C('db_prefix') . "user where (status!=2 and status!=0) order by id desc limit 0,1";
        $res      = $this->db->query($sql_user);
        $new_user = $res->fetch();
        $this->assign("new_user", $new_user['user']);
        $sql_num = "select count(*) as num from " . $this->C('db_prefix') . "user where (status!=2 and status!=0)";
        $res     = $this->db->query($sql_num);
        $usernum = $res->fetch();
        $this->assign("usernum", $usernum['num']);
        $sql_block   = "select * from " . $this->C('db_prefix') . "small_block where bid!=0 order by ssort desc,szone desc";
        $query_block = $this->db->query($sql_block);
        $data_block  = array();
        $data_big    = array();
        $time1       = date("Y-m-d");
        $time1 .= " 00:00:00";
        $time2 = date("Y-m-d");
        $time2 .= " 23:59:59";
        while ($arr_block = $query_block->fetch()) {
            $data_block[] = $arr_block;
            
            $bsql                        = "select * from " . $this->C('db_prefix') . "big_block where id=" . $arr_block['bid'];
            $res                         = $this->db->query($bsql);
            $barr                        = $res->fetch();
            $data_big[$arr_block['bid']] = $barr['bzone'];
            
            $res                          = $this->db->query("select count(parentid) from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
            ${'zhuti' . $arr_block['id']} = $res->fetchColumn();
            $this->assign("zhuti" . $arr_block['id'], ${'zhuti' . $arr_block['id']});
            
            $res                           = $this->db->query("select count(parentid) from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
            ${'tiezi1' . $arr_block['id']} = $res->fetchColumn();
            $res                           = $this->db->query("select count(parentid2) from " . $this->C('db_prefix') . "reply where parentid2 in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
            ${'tiezi2' . $arr_block['id']} = $res->fetchColumn();
            ${'tiezi' . $arr_block['id']}  = ${'tiezi1' . $arr_block['id']} + ${'tiezi2' . $arr_block['id']};
            $this->assign("tiezi" . $arr_block['id'], ${'tiezi' . $arr_block['id']});
            
            ${'arc' . $arr_block['id']} = $this->find($this->C('db_prefix') . "talk", "string", "(parentid=" . $arr_block['id'] . " or parentid=" . ($arr_block['id'] + 10000) . ") order by timeup desc");
            $this->assign("arc" . $arr_block['id'], ${'arc' . $arr_block['id']});
            
            ${'today1' . $arr_block['id']} = $this->select("select  count(*) as count1 from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")" . " and time1 between '" . $time1 . "' and '" . $time2 . "'");
            ${'today2' . $arr_block['id']} = $this->select("select  count(*) as count2 from " . $this->C('db_prefix') . "reply where parentid2 in" . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")" . " and time2 between '" . $time1 . "' and '" . $time2 . "'");
            /*子版块 start*/
            $sql_block_child               = "select * from " . $this->C('db_prefix') . "small_block where bid=0 and sid='" . $arr_block['id'] . "'";
            $query_block_child             = $this->db->query($sql_block_child);
            $num_block_child               = $this->db->query("select count(*) from " . $this->C('db_prefix') . "small_block where bid=0 and sid='" . $arr_block['id'] . "'")->fetchColumn();
            if ($num_block_child > 0) {
                while ($arr_block_child = $query_block_child->fetch()) {
                    ${'today1_child' . $arr_block_child['sid']} = $this->select("select  count(*) as count1 from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block_child['id'] . "," . (int) ($arr_block_child['id'] + 10000) . ")" . " and time1 between '" . $time1 . "' and '" . $time2 . "'");
                    ${'today2_child' . $arr_block_child['sid']} = $this->select("select  count(*) as count2 from " . $this->C('db_prefix') . "reply where parentid2 in" . "(" . $arr_block_child['id'] . "," . (int) ($arr_block_child['id'] + 10000) . ")" . " and time2 between '" . $time1 . "' and '" . $time2 . "'");
                    ${'today_child' . $arr_block_child['sid']} += ${'today1_child' . $arr_block_child['sid']}[0]['count1'] + ${'today2_child' . $arr_block_child['sid']}[0]['count2'];
                }
                $todaynum += ${'today_child' . $arr_block_child['sid']};
            }
            /*子版块 end*/
            ${'today' . $arr_block['id']} = ${'today1' . $arr_block['id']}[0]['count1'] + ${'today2' . $arr_block['id']}[0]['count2'] + ${'today_child' . $arr_block['id']};
            $this->assign("today" . $arr_block['id'], ${'today' . $arr_block['id']});
            $todaynum += ${'today' . $arr_block['id']};
            $tiezinum += ${'tiezi' . $arr_block['id']};
        }
        if (!empty($_SESSION['youyax_user'])) {
            $message_result = $this->find($this->C('db_prefix') . "message_status", 'string', "muser='" . $_SESSION['youyax_user'] . "'");
            if ($message_result['mstatus'] == '1') {
                $this->assign('message_status', 'block');
            } else {
                $this->assign('message_status', 'none');
            }
        } else {
            $this->assign('message_status', 'none');
        }
        $this->assign("todaynum", $todaynum)->assign("tiezinum", $tiezinum);
        $user_hot     = array();
        $user_hot_arr = $this->find($this->C('db_prefix') . "count", "string", "id=1");
        if ($user_hot_arr['user_hot']) {
            $user_hot = unserialize($user_hot_arr['user_hot']);
            uasort($user_hot, "my_sort");
        }
        $this->assign('user_hot', $user_hot);
        $tags_hot     = array();
        $tags_hot_arr = $this->find($this->C('db_prefix') . "count", "string", "id=1");
        if ($tags_hot_arr['tags_hot']) {
            $tags_hot = unserialize($tags_hot_arr['tags_hot']);
            uasort($tags_hot, "my_sort");
        }
        $this->assign('tags_hot', $tags_hot);
        if ($this->getparam("l") == 'cn') {
            $menues = require("Conf/menu.config.php");
        } else if ($this->getparam("l") == 'en') {
            $menues = require("Conf/menu_en.config.php");
        } else if ($_COOKIE['youyax_lang'] == 'cn') {
            $menues = require("Conf/menu.config.php");
        } else if ($_COOKIE['youyax_lang'] == 'en') {
            $menues = require("Conf/menu_en.config.php");
        } else {
            if ($this->config['default_language'] == 'en') {
                $menues = require("Conf/menu_en.config.php");
            } else {
                $menues = require("Conf/menu.config.php");
            }
        }
        $this->assign('menues', $menues);
        $reply_num_max = $this->select("select * from (select num2,rid,time2  FROM " . $this->C('db_prefix') . "reply  where UNIX_TIMESTAMP(time2) between (UNIX_TIMESTAMP(now())-7*24*3600) and UNIX_TIMESTAMP(now()) order by num2 desc,time2 desc)tmp group by rid order by num2 desc,time2 desc limit 0,5");
        $this->assign('reply_num_max', $reply_num_max);
        $talk_new = $this->select("select id,title,time1  FROM " . $this->C('db_prefix') . "talk where UNIX_TIMESTAMP(time1) between (UNIX_TIMESTAMP(now())-7*24*3600) and UNIX_TIMESTAMP(now()) order by id desc limit 0,5");
        $this->assign('talk_new', $talk_new);
        $mix = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $qq = require("./Conf/qq.config.php");
        $this->assign('qq', $qq);
        $wb = require("./Conf/weibo.config.php");
        $this->assign('wb', $wb);
        $site_config = require("./Conf/site.config.php");
        $ads         = require("./Conf/ads.config.php");
        $this->assign('site_config', $site_config)->assign('ads', $ads)->assign('data_big', $data_big)->assign('data_block', $data_block)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display('home/index.html');
        if (empty($_SESSION['youyax_user']) && !stristr($_SERVER['HTTP_USER_AGENT'], 'android') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') && !stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
            $cache->endCache();
        }
    }
    public function logout()
    {
        $_SESSION['youyax_user'] = "";
        @setcookie('youyax_user', '', time() - 3600, "/");
        @setcookie('youyax_cookieid', '', time() - 3600, "/");
        echo "<script>window.location.href='" . $this->C('SITE') . "';</script>";
    }
    public function selfbar()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null) {
            $this->redirect("Login" . $this->C('default_url') . "loginMobile" . $this->C('static_url'));
        } else {
            $this->self();
        }
    }
    public function self()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $this->assign('user', $user)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->display("home/self.html");
    }
    public function saveself()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        if (preg_match("/^\d{2}\.gif$/", $_POST['face'])) {
            $face = addslashes($_POST['face']);
        } else {
            $this->assign("code", "操作错误!")->assign("msg", "禁止非法操作")->display("Public/exception.html");
            echo "<script>setTimeout(function(){location.href = document.referrer;},2000);</script>";
            exit;
        }
        $this->db->exec("update " . $this->C('db_prefix') . "user set  face='" . $face . "'  where user='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "talk set  face='" . $face . "'  where zuozhe='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "reply set  face1='" . $face . "'  where zuozhe1='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "mark2 set  pic='" . $face . "'  where marker='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "mark1 set  pic='" . $face . "'  where marker='" . $user . "'");
        $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '图片更新成功！')->success();
    }
    public function mypub()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $sql   = "select * from (select id,title,time1,zuozhe from " . $this->C('db_prefix') . "talk where zuozhe='" . $user . "') t left join (select zuozhe1,rid from " . $this->C('db_prefix') . "reply  order by id2 desc) tmp on t.id=tmp.rid group by t.id order by t.time1 desc";
        $res   = $this->db->query($sql);
        $count = count($res->fetchAll());
        if ($count <= 0) {
            $mix    = require("./Conf/mix.config.php");
            $show   = '';
            $result = '';
        } else {
            $mix = require("./Conf/mix.config.php");
            require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
            $fenye  = new Fenye($count, 10);
            $show   = $fenye->show();
            $show   = implode("<span style='width:2px;display:inline-block;'></span>", $show);
            $sql2   = $fenye->listcon($sql);
            $result = $this->select($sql2);
        }
        $this->assign('mix', $mix);
        $this->assign('page', $show)->assign("mypubinfo", $result)->assign('user', $user)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->display("home/mypub.html");
    }
    public function myrep()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $sql   = "select * from (select * from (select zuozhe1,num2,rid,time2 from " . $this->C('db_prefix') . "reply where zuozhe1='" . $user . "' order by time2 desc) tmp group by tmp.rid desc) r left join (select id,zuozhe,title from " . $this->C('db_prefix') . "talk) t on r.rid=t.id order by r.time2 desc";
        $res   = $this->db->query($sql);
        $count = count($res->fetchAll());
        if ($count <= 0) {
            $mix    = require("./Conf/mix.config.php");
            $show   = '';
            $result = '';
        } else {
            $mix = require("./Conf/mix.config.php");
            require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
            $fenye  = new Fenye($count, 10);
            $show   = $fenye->show();
            $show   = implode("<span style='width:2px;display:inline-block;'></span>", $show);
            $sql2   = $fenye->listcon($sql);
            $result = $this->select($sql2);
        }
        $this->assign('mix', $mix);
        $this->assign('page', $show)->assign("myrepinfo", $result)->assign('user', $user)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->display("home/myrep.html");
    }
    public function chpsd()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $this->assign('site', $this->C('SITE'))->assign('user', $user)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->display("home/chpsd.html");
    }
    public function dochpsd()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        if (!preg_match("/^[A-Za-z0-9_]+$/u", $_POST['newpass'])) {
            $this->assign("code", "操作错误!")->assign("msg", "新密码不能为空或含有非法字符")->display("Public/exception.html");
            echo "<script>setTimeout(function(){location.href = document.referrer;},2000);</script>";
            exit;
        }
        $arr = $this->find($this->C('db_prefix') . "user", "string", "user='" . $user . "'");
        $key = require("./Conf/key.config.php");
        if ($arr && $this->cc_decrypt($arr['pass'], $key) == $_POST['oldpass']) {
            $this->db->exec("update " . $this->C('db_prefix') . "user set  pass='" . $this->cc_encrypt(addslashes($_POST['newpass'])) . "'  where user='" . $user . "'");
            if ($this->find($this->C('db_prefix') . "admin", "string", "user='" . $user . "'")) {
                $this->db->exec("update " . $this->C('db_prefix') . "admin set  pass='" . $this->cc_encrypt(addslashes($_POST['newpass'])) . "'  where user='" . $user . "'");
            }
            $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "chpsd" . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '密码更新成功！')->success();
        } else {
            $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "chpsd" . $this->C('static_url'))->assign('msgtitle', '操作错误')->assign('message', '原密码输入有误')->error();
        }
    }
    public function resize($filename)
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $album       = "./Public/pic/upload";
        $filenameall = $album . "/" . $filename;
        // File and new size
        // Content type
        //		header('Content-type: image/jpeg');
        // Get new sizes
        list($width, $height) = getimagesize($filenameall);
        list($font, $back) = explode(".", $filename); //获取扩展名
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
        switch (strtolower($back)) {
            case 'gif':
                $source = imagecreatefromgif($filenameall);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                $name = time() . ".gif";
                imagegif($thumb, $album . "/" . $name);
                break;
            case 'jpg':
            case 'jpeg':
                $source = imagecreatefromjpeg($filenameall);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                $name = time() . ".jpg";
                imagejpeg($thumb, $album . "/" . $name);
                break;
            case 'png':
                $source = imagecreatefrompng($filenameall);
                imagesavealpha($source, true);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                $name = time() . ".png";
                imagepng($thumb, $album . "/" . $name);
                break;
            default:
                break;
        }
        $res      = $this->db->query("select * from  " . $this->C('db_prefix') . "user  where user='" . $user . "'");
        $oldface  = $res->fetch();
        $oldface2 = $oldface['face'];
        $this->db->exec("update " . $this->C('db_prefix') . "user set  face='upload/" . $name . "'   where user='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "talk set  face='upload/" . $name . "'   where zuozhe='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "reply set  face1='upload/" . $name . "'   where zuozhe1='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "mark2 set  pic='upload/" . $name . "'   where marker='" . $user . "'");
        $this->db->exec("update " . $this->C('db_prefix') . "mark1 set  pic='upload/" . $name . "'   where marker='" . $user . "'");
        if (preg_match_all("/upload/", $oldface2, $tmp)) {
            @unlink("./Public/pic/$oldface2");
        }
        @unlink("./Public/pic/upload/$filename");
    }
    public function upload()
    {
        $album = "./Public/pic/upload";
        $user  = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        if (is_dir($album) != true) {
            mkdir($album);
        }
        $type  = array(
            'image/jpeg',
            'image/pjpeg',
            'image/gif',
            'image/png',
            'image/x-png'
        );
        $type2 = array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        );
        $type3 = "|.jpeg|.gif|.png|.jpg";
        $hz    = substr(strstr($_FILES["file"]["name"], "."), 1);
        if (in_array($_FILES["file"]["type"], $type) && in_array(strtolower($hz), $type2)) {
            $filename = $_FILES["file"]["name"];
            list($font, $back) = explode(".", $filename); //获取扩展名
            if (!preg_match("/^[\x4e00-\x9fa5]+$/", $font)) {
                echo "<script>alert('上传文件不能有中文,空格!');</script>";
                $this->redirect("Index" . $this->C('default_url') . "self" . $this->C('static_url'));
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $album . "/" . $filename)) {
                    $info = getimagesize($album . "/" . $filename);
                    $ext  = image_type_to_extension($info['2']);
                    if (stripos($type3, $ext)) {
                        $this->resize($filename);
                        $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '图片更新成功！')->success();
                    } else {
                        @unlink($album . "/" . $filename);
                        $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))->assign('msgtitle', '操作错误')->assign('message', '非法类型文件！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))->assign('msgtitle', '操作错误')->assign('message', '文件上传过程出错！')->error();
                }
            }
        } else {
            $this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))->assign('msgtitle', '操作错误')->assign('message', '禁止空上传！')->error();
        }
    }
    public function showip()
    {
        $iparr = array();
        $res   = $this->db->query("select zone from " . $this->C('db_prefix') . "online");
        while ($arr = $res->fetch()) {
            $iparr[] = $arr['zone'];
        }
        echo json_encode($iparr);
    }
    public function getsecmenu()
    {
        if ($this->getparam("l") == 'cn') {
            $menues = require("Conf/menu.config.php");
        } else if ($this->getparam("l") == 'en') {
            $menues = require("Conf/menu_en.config.php");
        } else if ($_COOKIE['youyax_lang'] == 'cn') {
            $menues = require("Conf/menu.config.php");
        } else if ($_COOKIE['youyax_lang'] == 'en') {
            $menues = require("Conf/menu_en.config.php");
        } else {
            if ($this->config['default_language'] == 'en') {
                $menues = require("Conf/menu_en.config.php");
            } else {
                $menues = require("Conf/menu.config.php");
            }
        }
        $this->assign('menues', $menues);
        echo json_encode($menues[$_POST['data']]['seclists']);
    }
}
?>