<?php
class ListAction extends YouYaX
{
    public function transform($txt, $check = true)
    {
        $txt = preg_replace('/[　]+/u', '', $txt);
        $txt = addslashes(htmlspecialchars(trim($txt), ENT_QUOTES, "UTF-8"));
        if (preg_match_all("/\[quote](.+?)\[\/quote]/is", $txt, $match)) {
            $txt = preg_replace('/\s*\r\n\s*/', '', $txt, 1);
        }
        $huanhang = array(
            "\r\n\r\n",
            "\n\n",
            "\r\r"
        );
        $txt      = str_replace($huanhang, '<div style="clear:both;height:12px;"></div>', $txt);
        $huanhang = array(
            "\r\n",
            "\n",
            "\r"
        );
        $txt      = str_replace($huanhang, '<div style="clear:both;height:0;"></div>', $txt);
        /*字体替换*/
        if (preg_match_all("/\[face=(.*?)](.+?)\[\/face]/is", $txt, $face)) {
            for ($i = 0; $i < sizeof($face[0]); $i++) {
                $tmp = preg_replace("/\[face=(.*?)](.+?)\[\/face]/is", '<span style="font-family:' . $face[1][$i] . '">' . $face[2][$i] . '</span>', $face[0][$i]);
                $txt = str_replace($face[0][$i], $tmp, $txt);
            }
        }
        /*--字体替换*/
        
        /*大小替换*/
        if (preg_match_all("/\[size=(.*?)](.+?)\[\/size]/is", $txt, $size)) {
            for ($i = 0; $i < sizeof($size[0]); $i++) {
                if (substr($size[1][$i], 0, 2) > 24)
                    $size[1][$i] = "25px";
                $tmp = preg_replace("/\[size=(.*?)](.+?)\[\/size]/is", '<span style="font-size:' . $size[1][$i] . '">' . $size[2][$i] . '</span>', $size[0][$i]);
                $txt = str_replace($size[0][$i], $tmp, $txt);
            }
        }
        /*--大小替换*/
        
        /*加粗替换*/
        if (preg_match_all("/\[b](.+?)\[\/b]/is", $txt, $bold)) {
            for ($i = 0; $i < sizeof($bold[0]); $i++) {
                $tmp = preg_replace("/\[b](.+?)\[\/b]/is", '<span style="font-weight:bold">' . $bold[1][$i] . '</span>', $bold[0][$i]);
                $txt = str_replace($bold[0][$i], $tmp, $txt);
            }
        }
        /*--加粗替换*/
        
        /*倾斜替换*/
        if (preg_match_all("/\[i](.+?)\[\/i]/is", $txt, $tilt)) {
            for ($i = 0; $i < sizeof($tilt[0]); $i++) {
                $tmp = preg_replace("/\[i](.+?)\[\/i]/is", '<span style="font-style:italic">' . $tilt[1][$i] . '</span>', $tilt[0][$i]);
                $txt = str_replace($tilt[0][$i], $tmp, $txt);
            }
        }
        /*--倾斜替换*/
        
        /*下划线替换*/
        if (preg_match_all("/\[u](.+?)\[\/u]/is", $txt, $under)) {
            for ($i = 0; $i < sizeof($under[0]); $i++) {
                $tmp = preg_replace("/\[u](.+?)\[\/u]/is", '<span style="text-decoration:underline">' . $under[1][$i] . '</span>', $under[0][$i]);
                $txt = str_replace($under[0][$i], $tmp, $txt);
            }
        }
        /*--下划线替换*/
        
        /*首行缩进替换*/
        if (preg_match_all("/\[indent](.+?)\[\/indent]/is", $txt, $indent)) {
            for ($i = 0; $i < sizeof($indent[0]); $i++) {
                $tmp = preg_replace("/\[indent](.+?)\[\/indent]/is", '<p style="text-indent:2em">' . $indent[1][$i] . '</p>', $indent[0][$i]);
                $txt = str_replace($indent[0][$i], $tmp, $txt);
            }
        }
        /*--首行缩进替换*/
        
        /*左对齐替换*/
        if (preg_match_all("/\[left](.+?)\[\/left]/is", $txt, $left)) {
            for ($i = 0; $i < sizeof($left[0]); $i++) {
                $tmp = preg_replace("/\[left](.+?)\[\/left]/is", '<p style="text-align:left">' . $left[1][$i] . '</p>', $left[0][$i]);
                $txt = str_replace($left[0][$i], $tmp, $txt);
            }
        }
        /*--左对齐替换*/
        
        /*居中替换*/
        if (preg_match_all("/\[center](.+?)\[\/center]/is", $txt, $center)) {
            for ($i = 0; $i < sizeof($center[0]); $i++) {
                $tmp = preg_replace("/\[center](.+?)\[\/center]/is", '<p style="text-align:center">' . $center[1][$i] . '</p>', $center[0][$i]);
                $txt = str_replace($center[0][$i], $tmp, $txt);
            }
        }
        /*--居中替换*/
        
        /*右对齐替换*/
        if (preg_match_all("/\[right](.+?)\[\/right]/is", $txt, $right)) {
            for ($i = 0; $i < sizeof($right[0]); $i++) {
                $tmp = preg_replace("/\[right](.+?)\[\/right]/is", '<p style="text-align:right">' . $right[1][$i] . '</p>', $right[0][$i]);
                $txt = str_replace($right[0][$i], $tmp, $txt);
            }
        }
        /*--右对齐替换*/
        
        /*颜色替换*/
        if (preg_match_all("/\[color=(.*?)](.+?)\[\/color]/is", $txt, $color)) {
            for ($i = 0; $i < sizeof($color[0]); $i++) {
                $tmp = preg_replace("/\[color=(.*?)](.+?)\[\/color]/is", '<span style="color:' . $color[1][$i] . '">' . $color[2][$i] . '</span>', $color[0][$i]);
                $txt = str_replace($color[0][$i], $tmp, $txt);
            }
        }
        /*--颜色替换*/
        
        /*超链接替换*/
        if (preg_match_all("/\[url=(.*?)](.+?)\[\/url]/is", $txt, $Hyperlink)) {
            for ($i = 0; $i < sizeof($Hyperlink[0]); $i++) {
                if (!preg_match_all("/javascript:/is", strtolower($Hyperlink[1][$i]), $tmp)) {
                    $tmp = preg_replace("/\[url=(.*?)](.+?)\[\/url]/is", '<a target="_blank" style="text-decoration:underline" href="' . $Hyperlink[1][$i] . '">' . $Hyperlink[2][$i] . '</a>', $Hyperlink[0][$i]);
                    $txt = str_replace($Hyperlink[0][$i], $tmp, $txt);
                }
            }
        }
        /*--超链接替换*/
        
        /*本地图片替换*/
        if (preg_match_all("/\[img=(.*?)]\[\/img]/is", $txt, $localimg)) {
            for ($i = 0; $i < sizeof($localimg[0]); $i++) {
                $tmp_img = substr($localimg[1][$i], strrpos($localimg[1][$i], ".") + 1);
                if (in_array($tmp_img, array(
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'JPEG',
                    'JPG',
                    'PNG',
                    'GIF'
                ))) {
                    $tmp = preg_replace("/\[img=(.*?)]\[\/img]/is", '<img border="0" onerror="nofind();" src="' . $localimg[1][$i] . '">', $localimg[0][$i]);
                    $txt = str_replace($localimg[0][$i], $tmp, $txt);
                }
            }
        }
        /*--本地图片替换*/
        
        /*音乐替换*/
        if (preg_match_all("/\[music=(.*?)]\[\/music]/is", $txt, $music)) {
            for ($i = 0; $i < sizeof($music[0]); $i++) {
                $tmp_mus = substr($music[1][$i], strrpos($music[1][$i], ".") + 1);
                if (stripos($tmp_mus, 'mp3') !== false) {
                    if ($check) {
                        $tmp = preg_replace("/\[music=(.*?)]\[\/music]/is", '<audio src="' . $music[1][$i] . '" preload="auto"></audio>', $music[0][$i]);
                    } else {
                        $tmp = preg_replace("/\[music=(.*?)]\[\/music]/is", '<div style="background:#e4e4e4;padding:10px;">音频文件</div>', $music[0][$i]);
                    }
                    $txt = str_replace($music[0][$i], $tmp, $txt);
                }
            }
        }
        /*--音乐替换*/
        
        /*视频替换*/
        if (preg_match_all("/\[video=(.*?) width=(\d*?) height=(\d*?)]\[\/video]/is", $txt, $video)) {
            for ($i = 0; $i < sizeof($video[0]); $i++) {
                $tmp_vid = substr($video[1][$i], strrpos($video[1][$i], ".") + 1);
                if (stripos($tmp_vid, 'swf') !== false) {
                    $tmp = preg_replace("/\[video=(.*?)]\[\/video]/is", '<param name="wmode" value="transparent"><embed allowfullscreen="true" wmode="transparent" src="' . $video[1][$i] . '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' . ($video[2][$i] > 600 ? 600 : $video[2][$i]) . '" height="' . ($video[3][$i] > 400 ? 400 : $video[3][$i]) . '"></embed>', $video[0][$i]);
                    $txt = str_replace($video[0][$i], $tmp, $txt);
                } else {
                    $tmp = preg_replace("/\[video=(.*?)]\[\/video]/is", '<iframe src="' . $video[1][$i] . '" width="' . ($video[2][$i] > 600 ? 600 : $video[2][$i]) . '" height="' . ($video[3][$i] > 400 ? 400 : $video[3][$i]) . '" frameborder="0" allowfullscreen="true"></iframe>', $video[0][$i]);
                    $txt = str_replace($video[0][$i], $tmp, $txt);
                }
            }
        }
        /*--视频替换*/
        
        /*代码替换*/
        if (preg_match_all("/\[code=([^\[]*)](.+?)\[\/code]/is", $txt, $cod)) {
            for ($i = 0; $i < sizeof($cod[0]); $i++) {
                if ($check) {
                    $cod[2][$i] = str_replace('<div style="clear:both;height:0;"></div>', '\r\n', $cod[2][$i]);
                    $cod[2][$i] = str_replace('<div style="clear:both;height:12px;"></div>', '\r\n\r\n', $cod[2][$i]);
                    $txt        = str_replace($cod[0][$i], '<pre class="brush: ' . ($cod[1][$i] == 'html' ? 'xml' : $cod[1][$i]) . '">' . $cod[2][$i] . '</pre>', $txt);
                } else {
                    $txt = str_replace($cod[0][$i], '<div style="background:#e4e4e4;padding:10px;">' . strtoupper($cod[1][$i]) . '代码</div>', $txt);
                }
            }
        }
        /*--代码替换*/
        if ($check) {
            match(strip_tags($txt), "content");
        }
        return $txt;
    }
    public function preview()
    {
        $previewContents = filter_var($_POST['data'], FILTER_CALLBACK, array(
            "options" => "filter_function"
        ));
        $previewContents = $this->transform($previewContents, false);
        echo $previewContents;
    }
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
        $_SESSION['youyax_f'] = $this->getparam("f");
        if (!is_numeric($this->getparam("f"))) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "列表序号不为非数字!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (!CommonAction::userGroupVisit('access')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限访问!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        
        $_SESSION['youyax_view'] = 0; //用于记录浏览次数
        $res                     = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $_SESSION['youyax_f'] . "," . (int) ($_SESSION['youyax_f'] + 10000) . ")");
        $tiezi                   = $res->fetchColumn();
        $this->assign("tiezi", $tiezi);
        $time1 = date("Y-m-d");
        $time1 .= " 00:00:00";
        $time2 = date("Y-m-d");
        $time2 .= " 23:59:59";
        $today1 = $this->select("select  count(*) as count1 from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $_SESSION['youyax_f'] . "," . (int) ($_SESSION['youyax_f'] + 10000) . ")" . " and time1 between '" . $time1 . "' and '" . $time2 . "'");
        $today2 = $this->select("select  count(*) as count2 from " . $this->C('db_prefix') . "reply where parentid2 in" . "(" . $_SESSION['youyax_f'] . "," . (int) ($_SESSION['youyax_f'] + 10000) . ")" . " and time2 between '" . $time1 . "' and '" . $time2 . "'");
        $today  = $today1[0]['count1'] + $today2[0]['count2'];
        $this->assign("today", $today);
        
        $zd_sql  = "select *  from " . $this->C('db_prefix') . "talk left join (
        select * from " . $this->C('db_prefix') . "reply where EXISTS (
		    select `id2` from (
			        select max(`id2`) as mid2 from " . $this->C('db_prefix') . "reply group by `rid`) rtmp
			    where rtmp.mid2=" . $this->C('db_prefix') . "reply.id2
			)
        ) " . $this->C('db_prefix') . "reply  on " . $this->C('db_prefix') . "talk.id=" . $this->C('db_prefix') . "reply.rid and " . $this->C('db_prefix') . "talk.parentid=" . $this->C('db_prefix') . "reply.parentid2 where " . $this->C('db_prefix') . "talk.parentid=" . (int) ($_SESSION['youyax_f'] + 10000) . " order by " . $this->C('db_prefix') . "talk.timeup desc";
        $zd_data = $this->select($zd_sql);
        $this->assign('zd_data', $zd_data);
        /* 用于列表页Tab start*/
        if ($this->getparam("type") == null) {
            $type = "1=1";
        }
        if ($this->getparam("type") == 1) {
            $type = "is_question=0";
        }
        if ($this->getparam("type") == 2) {
            $type = "is_question=1";
        }
        /* 用于列表页Tab end*/
        $res   = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where parentid=" . $_SESSION['youyax_f'] . " and " . $type);
        $count = $res->fetchColumn();
        $mix   = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $fenye = new Fenye($count, $mix['list_per']);
        $show  = $fenye->show();
        $show  = implode("<span style='width:2px;display:inline-block;'></span>", $show);
        $sql   = $fenye->listcon("select *  from " . $this->C('db_prefix') . "talk left join (
        select * from " . $this->C('db_prefix') . "reply where EXISTS (
		    select `id2` from (
			        select max(`id2`) as mid2 from " . $this->C('db_prefix') . "reply group by `rid`) rtmp
			    where rtmp.mid2=" . $this->C('db_prefix') . "reply.id2
			)
        ) " . $this->C('db_prefix') . "reply  on " . $this->C('db_prefix') . "talk.id=" . $this->C('db_prefix') . "reply.rid and " . $this->C('db_prefix') . "talk.parentid=" . $this->C('db_prefix') . "reply.parentid2 where " . $this->C('db_prefix') . "talk.parentid=" . $_SESSION['youyax_f'] . "  and " . $type . " order by " . $this->C('db_prefix') . "talk.timeup desc");
        $data  = $this->select($sql);
        if (empty($data)) {
            $show = "";
        }
        $fsql     = "select szone,mark,sid from " . $this->C('db_prefix') . "small_block where id=" . $_SESSION['youyax_f'];
        $res      = $this->db->query($fsql);
        $f        = $res->fetch();
        $f_parent = array();
        if (!empty($f['sid']) && $f['sid'] != 0) {
            $fsql_parent = "select szone,mark,id from " . $this->C('db_prefix') . "small_block where id=" . $f['sid'];
            $res         = $this->db->query($fsql_parent);
            $f_parent    = $res->fetch();
        }
        $tongji     = CommonAction::tongji();
        $small_sql  = "select id,szone from " . $this->C('db_prefix') . "small_block";
        $small_data = $this->select($small_sql);
        $this->assign('small_data', $small_data)->assign('count', $tongji);
        $message_result = $this->find($this->C('db_prefix') . "message_status", 'string', "muser='" . $_SESSION['youyax_user'] . "'");
        if ($message_result['mstatus'] == '1') {
            $this->assign('message_status', 'block');
        } else {
            $this->assign('message_status', 'none');
        }
        /* 子版块统计显示 start*/
        $sql_block   = "select * from " . $this->C('db_prefix') . "small_block where sid=" . $_SESSION['youyax_f'] . " order by ssort desc,szone desc";
        $query_block = $this->db->query($sql_block);
        $data_block  = array();
        $time1       = date("Y-m-d");
        $time1 .= " 00:00:00";
        $time2 = date("Y-m-d");
        $time2 .= " 23:59:59";
        $num_block = $this->db->query("select count(*) from " . $this->C('db_prefix') . "small_block where sid=" . $_SESSION['youyax_f'] . " order by ssort desc,szone desc")->fetchColumn();
        if ($num_block > 0) {
            while ($arr_block = $query_block->fetch()) {
                $data_block[] = $arr_block;
                
                $res                                = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
                ${'zhuti_child' . $arr_block['id']} = $res->fetchColumn();
                $this->assign("zhuti_child" . $arr_block['id'], ${'zhuti_child' . $arr_block['id']});
                
                $res                                 = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
                ${'tiezi1_child' . $arr_block['id']} = $res->fetchColumn();
                $res                                 = $this->db->query("select count(*) from " . $this->C('db_prefix') . "reply where parentid2 in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")");
                ${'tiezi2_child' . $arr_block['id']} = $res->fetchColumn();
                ${'tiezi_child' . $arr_block['id']}  = ${'tiezi1_child' . $arr_block['id']} + ${'tiezi2_child' . $arr_block['id']};
                $this->assign("tiezi_child" . $arr_block['id'], ${'tiezi_child' . $arr_block['id']});
                
                ${'arc_child' . $arr_block['id']} = $this->find($this->C('db_prefix') . "talk", "string", "parentid=" . $arr_block['id'] . " order by timeup desc");
                $this->assign("arc_child" . $arr_block['id'], ${'arc_child' . $arr_block['id']});
                
                ${'today1_child' . $arr_block['id']} = $this->select("select  count(*) as count1 from " . $this->C('db_prefix') . "talk where parentid in " . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")" . " and time1 between '" . $time1 . "' and '" . $time2 . "'");
                ${'today2_child' . $arr_block['id']} = $this->select("select  count(*) as count2 from " . $this->C('db_prefix') . "reply where parentid2 in" . "(" . $arr_block['id'] . "," . (int) ($arr_block['id'] + 10000) . ")" . " and time2 between '" . $time1 . "' and '" . $time2 . "'");
                ${'today_child' . $arr_block['id']}  = ${'today1_child' . $arr_block['id']}[0]['count1'] + ${'today2_child' . $arr_block['id']}[0]['count2'];
                $this->assign("today_child" . $arr_block['id'], ${'today_child' . $arr_block['id']});
            }
        }
        $this->assign('data_block_child', $data_block);
        /* 子版块统计显示 end*/
        $mix = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $qq = require("./Conf/qq.config.php");
        $this->assign('qq', $qq);
        $wb = require("./Conf/weibo.config.php");
        $this->assign('wb', $wb);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->assign('f', $f)->assign('f_parent', $f_parent)->assign('data', $data)->assign('page', $show)->assign('user', $user)->assign('site', $this->C('SITE'))->assign('seo_status', $this->C('seo_set'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') !== false) {
            $this->display('list/index-normal.html');
        } else {
            if ($mix['list_style'] == '2') {
                $this->display('list/index-normal.html');
            } else {
                $this->display('list/index.html');
            }
        }
        if (empty($_SESSION['youyax_user']) && !stristr($_SERVER['HTTP_USER_AGENT'], 'android') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') && !stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
            $cache->endCache();
        }
    }
    public function fatie()
    {
        if (!CommonAction::userGroupVisit('access')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限访问!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        $_SESSION['token'] = md5(microtime(true));
        $user              = $_SESSION['youyax_user'];
        $mix               = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config);
        $fsql      = "select szone,mark,sid from " . $this->C('db_prefix') . "small_block where id=" . $_SESSION['youyax_f'];
        $res       = $this->db->query($fsql);
        $fb        = $res->fetch();
        $fb_parent = array();
        if (!empty($fb['sid']) && $fb['sid'] != 0) {
            $fsql_parent = "select szone,mark,id from " . $this->C('db_prefix') . "small_block where id=" . $fb['sid'];
            $res         = $this->db->query($fsql_parent);
            $fb_parent   = $res->fetch();
        }
        $this->assign('token', $_SESSION['token'])->assign('user', $user)->assign('f', $_SESSION['youyax_f'])->assign('fb', $fb)->assign('fb_parent', $fb_parent)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display('list/fatie.html');
    }
    public function vote()
    {
        if (!CommonAction::userGroupVisit('access')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限访问!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        $_SESSION['token'] = md5(microtime(true));
        $user              = $_SESSION['youyax_user'];
        $mix               = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config);
        $fsql      = "select szone,mark,sid from " . $this->C('db_prefix') . "small_block where id=" . $_SESSION['youyax_f'];
        $res       = $this->db->query($fsql);
        $fb        = $res->fetch();
        $fb_parent = array();
        if (!empty($fb['sid']) && $fb['sid'] != 0) {
            $fsql_parent = "select szone,mark,id from " . $this->C('db_prefix') . "small_block where id=" . $fb['sid'];
            $res         = $this->db->query($fsql_parent);
            $fb_parent   = $res->fetch();
        }
        $this->assign('token', $_SESSION['token'])->assign('user', $user)->assign('f', $_SESSION['youyax_f'])->assign('fb', $fb)->assign('fb_parent', $fb_parent)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display('list/vote.html');
    }
    public function insert1()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $mix = require("./Conf/mix.config.php");
        if ($mix['is_limit_time']) {
            if (!LimitAction::limitTime($mix['limit_time'])) {
                $this->assign("msgtitle", "操作限制!")->assign("message", "在" . $mix['limit_time'] . "秒内不能发帖和回帖！")->assign("jumpurl", $this->C('SITE'))->error();
            }
        }
        if (empty($_SESSION['youyax_f'])) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "没有版块标识，非法操作!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        $_SESSION['youyax_f'] = intval($_POST['f']);
        if (!CommonAction::userGroupVisit('publish')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限发帖!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (intval($_POST['cat']) == 2 && (intval($_POST['bid']) > 0 && is_numeric($_POST['bid']))) {
            if (!BidAction::queryBid($_SESSION['youyax_user'], intval($_POST['bid']))) {
                $this->assign("msgtitle", "操作错误!")->assign("message", "您的金币数不足!")->assign("jumpurl", $this->C('SITE'))->error();
            }
        }
        $small_id_arr = $this->select("select * from " . $this->C('db_prefix') . "small_block", "id");
        if (!in_array($_POST['f'], $small_id_arr)) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "版块ID异常，非法操作!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (match($_SESSION['youyax_user'], "session_user")) {
            if (($_SESSION['youyax_user'] == addslashes($_POST['zuozhe'])) && CommonAction::competence($_POST['zuozhe'])) {
                $t1          = addslashes($_POST['zuozhe']);
                $isvisible   = ($_POST['isvisible'] == 1) ? 1 : 0;
                $islimit1    = ($_POST['islimit1'] == 1) ? 1 : 0;
                $isquestion  = ($_POST['cat'] == 2 && ($_POST['bid'] > 0 && is_numeric($_POST['bid']))) ? 1 : 0;
                $questionbid = ($_POST['bid'] > 0 && is_numeric($_POST['bid'])) ? intval($_POST['bid']) : 0;
                $t2          = addslashes(htmlspecialchars($_POST['title'], ENT_QUOTES, "UTF-8"));
                $t2          = filter_var($t2, FILTER_CALLBACK, array(
                    "options" => "filter_function"
                ));
                if (match($t2, "title")) {
                    $t3    = filter_var($_POST['content'], FILTER_CALLBACK, array(
                        "options" => "filter_function"
                    ));
                    $t_ori = addslashes(htmlspecialchars($t3, ENT_QUOTES, "UTF-8"));
                    $t3    = $this->transform($t3);
                    if (!empty($_POST['lival'])) {
                        $_POST['lival'] = array_filter($_POST['lival']);
                    }
                    if (!empty($_POST['lival'])) {
                        $lival    = $_POST['lival'];
                        $li_count = count($lival);
                        if (match($li_count, "lival")) {
                            $vote_tmp = array();
                            $vote_arr = array();
                            for ($m = 0; $m < $li_count; $m++) {
                                $vote_tmp['options'] = mb_substr(addslashes(htmlspecialchars($lival[$m], ENT_QUOTES, "UTF-8")), 0, 20, 'utf-8');
                                $vote_tmp['nums']    = 0;
                                $vote_arr[]          = $vote_tmp;
                            }
                            $this->db->exec("insert into " . $this->C('db_prefix') . "vote(rid,comb) values(0,'" . serialize($vote_arr) . "')");
                            $voteid = $this->db->lastinsertid();
                        }
                    }
                    if (preg_match_all("/<embed[^>]*?\/\s*>/", $t3, $arr)) {
                        $val = "";
                        foreach ($arr[0] as $v) {
                            if (!preg_match_all("/wmode\s*=\s*\'\s*transparent\s*\'/", $v, $arr2)) {
                                $v1 = preg_replace("/\/>/", " wmode='transparent' />", $v);
                                $v2 = preg_replace("/<embed src/", "<param name='wmode' value='transparent' /><embed src", $v1);
                                $t3 = str_replace($v, $v2, $t3);
                            }
                        }
                    }
                    $user = $this->find($this->C('db_prefix') . "user", "string", "user='" . $t1 . "'");
                    $t4   = $user['face'];
                    $t5   = $user['time'];
                    $t6   = $user['fatieshu'];
                    $t6   = $t6 + 1;
                    /*添加手机设备识别 start*/
                    if (stristr($_SERVER['HTTP_USER_AGENT'], 'android')) {
                        $t3 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Android设备</div>";
                    }
                    if (stristr($_SERVER['HTTP_USER_AGENT'], 'iphone')) {
                        $t3 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPhone设备</div>";
                    }
                    if (stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
                        $t3 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPad设备</div>";
                    }
                    if (stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
                        $t3 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Win Phone设备</div>";
                    }
                    /*添加手机设备识别 end*/
                    $tag_sk    = !empty($_POST['hidden-tagsk']) ? addslashes($_POST['hidden-tagsk']) : '';
                    $tag_group = !empty($_POST['hidden-taggroup']) ? addslashes($_POST['hidden-taggroup']) : '';
                    $taggroup  = '';
                    if (!empty($tag_group)) {
                        $taggrouparrsend = $taggrouparr = explode(",", $tag_group);
                        $taggrouparr[]   = $_SESSION['youyax_user'];
                        $taggroup        = implode(",", $taggrouparr);
                    }
                    $this->db->exec("insert into " . $this->C('db_prefix') . "talk(fatieshu1,timezc1,face,zuozhe,title,ori_content,content,time1,timeup,parentid,is_visible,is_limit1,is_question,is_allow,tags,question_bid) values(" . $t6 . ",'" . $t5 . "','" . $t4 . "','" . $t1 . "','" . $t2 . "','" . $t_ori . "','" . $t3 . "',now(),now()," . intval($_POST['f']) . "," . $isvisible . "," . $islimit1 . "," . $isquestion . ",'" . $taggroup . "','" . $tag_sk . "'," . $questionbid . ")");
                    $talkid = $this->db->lastinsertid();
                    if (!empty($_POST['lival'])) {
                        $this->db->exec("update " . $this->C('db_prefix') . "vote set rid=" . $talkid . " where id='" . $voteid . "'");
                    }
                    if (!empty($tag_group)) {
                        foreach ($taggrouparrsend as $touser) {
                            $tourl = '<a href="' . $this->youyax_url . "/Content" . $this->C('default_url') . intval($talkid) . $this->C('static_url') . '">快去看看吧^_^</a>';
                            CommonAction::adminSend($touser, $t1 . ' 邀请你参加群聊, ' . $tourl);
                        }
                    }
                    $this->db->exec("update " . $this->C('db_prefix') . "talk set face='" . $t4 . "',timezc1='" . $t5 . "', fatieshu1='" . $t6 . "'  where  zuozhe='" . $t1 . "'");
                    $this->db->exec("update " . $this->C('db_prefix') . "reply set fatieshu2=" . $t6 . " where  zuozhe1='" . $t1 . "'");
                    if (intval($_POST['cat']) == 2 && (intval($_POST['bid']) > 0 && is_numeric($_POST['bid']))) {
                        $this->db->exec("update " . $this->C('db_prefix') . "user set fatieshu=" . $t6 . ",bid=bid-" . intval($_POST['bid']) . " where  user='" . $t1 . "'");
                    } else {
                        $this->db->exec("update " . $this->C('db_prefix') . "user set fatieshu=" . $t6 . " where  user='" . $t1 . "'");
                    }
                    CountAction::doPostCount($tag_sk);
                    $this->redirect("List" . $this->C('default_url') . intval($_POST['f']) . $this->C('static_url'));
                }
            } else {
                $_SESSION['youyax_user'] = "";
                @setcookie('youyax_user', '', time() - 3600, "/");
                @setcookie('youyax_cookieid', '', time() - 3600, "/");
                $this->assign("msgtitle", "操作错误!")->assign("message", "非法操作，请重新登陆!")->assign("jumpurl", $this->C('SITE'))->error();
            }
        }
    }
    public function insert2()
    {
        $mix = require("./Conf/mix.config.php");
        if ($mix['is_limit_time']) {
            if (!LimitAction::limitTime($mix['limit_time'])) {
                $this->assign("msgtitle", "操作限制!")->assign("message", "在" . $mix['limit_time'] . "秒内不能发帖和回帖！")->assign("jumpurl", $this->C('SITE'))->error();
            }
        }
        if (empty($_SESSION['youyax_f'])) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "没有版块标识，非法操作!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (!CommonAction::userGroupVisit('reply')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限回帖!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        //ajax验证判断，防止被禁用Javascript或其他源码恶意操作
        if (empty($_SESSION['youyax_ajax_bz'])) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "回复帖子没有经过Ajax处理!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        $_SESSION['youyax_ajax_bz'] = '';
        if (match($_SESSION['youyax_user'], "session_user")) {
            if (($_SESSION['youyax_user'] == addslashes($_POST['zuozhe1'])) && CommonAction::competence($_POST['zuozhe1']) && CommonAction::lock($_SESSION['youyax_talk_id'])) {
                $t3        = $_SESSION['youyax_talk_id'];
                $allow_arr = $this->find($this->C('db_prefix') . "talk", "string", "id='" . intval($t3) . "'");
                $groupchat = array();
                if (!empty($allow_arr['is_allow'])) {
                    $groupchat   = explode(",", $allow_arr['is_allow']);
                    $groupchat[] = $allow_arr['zuozhe'];
                    if (!in_array($_SESSION['youyax_user'], $groupchat)) {
                        $this->assign("msgtitle", "操作错误!")->assign("message", "仅限于在群组的用户才能回复哦!")->assign("jumpurl", $this->C('SITE'))->error();
                    }
                }
                $t1    = addslashes($_POST['zuozhe1']);
                $t2    = filter_var($_POST['content'], FILTER_CALLBACK, array(
                    "options" => "filter_function"
                ));
                $t_ori = addslashes(htmlspecialchars($t2, ENT_QUOTES, "UTF-8"));
                $t2    = $this->transform($t2);
                $bz    = false;
                if (preg_match_all("/\[quote](.+?)\[\/quote]/is", $t2, $quo)) {
                    if (match(preg_replace("/\[quote](.+?)\[\/quote]/is", '', $t2), "content")) {
                        $bz                    = true;
                        $quote_result          = array();
                        $quote_result_fieldset = $youyax_id_zuozhe = $youyax_cite = '';
                        if (!empty($_POST['article2'])) {
                            $quote_result = $this->find($this->C('db_prefix') . "reply", "string", "id2=" . intval($_POST['article2']));
                            preg_match_all("/<fieldset.*>.*<\/fieldset>/", $quote_result['content1'], $quo_result_tmp);
                            $quote_result_fieldset = !empty($quo_result_tmp[0][0]) ? $quo_result_tmp[0][0] : '';
                            $youyax_id_zuozhe      = $quote_result['zuozhe1'];
                            $youyax_cite           = $youyax_id_zuozhe . '  发表于  ' . $quote_result['time2'];
                            if ($quote_result['rid'] != $_SESSION['youyax_talk_id']) {
                                $this->assign("msgtitle", "操作错误!")->assign("message", "禁止恶意篡改引用内容!")->assign("jumpurl", $this->C('SITE'))->error();
                            }
                        } else {
                            $quote_result          = $this->find($this->C('db_prefix') . "talk", "string", intval($_POST['article1']));
                            $quote_result_fieldset = '';
                            $youyax_id_zuozhe      = $quote_result['zuozhe'];
                            $youyax_cite           = $youyax_id_zuozhe . '  发表于  ' . $quote_result['time1'];
                            if ($quote_result['id'] != $_SESSION['youyax_talk_id']) {
                                $this->assign("msgtitle", "操作错误!")->assign("message", "禁止恶意篡改引用内容!")->assign("jumpurl", $this->C('SITE'))->error();
                            }
                        }
                        $quote_result_content = !empty($quote_result['content1']) ? $quote_result['content1'] : $quote_result['content'];
                        $quote_result_content = preg_replace("/<fieldset.*>.*<\/fieldset>/", '', $quote_result_content);
                        $quote_result_content = strip_tags(preg_replace('/<div(.*?)<\/div>/', '', $quote_result_content));
                        $quote_result_content = addslashes(htmlspecialchars_decode($quote_result_content, ENT_QUOTES));
                        $quote_result_content = str_replace(array(
                            "\r\n",
                            "\n"
                        ), "", $quote_result_content);
                        $quote_result_content = htmlspecialchars($quote_result_content, ENT_QUOTES, "UTF-8");
                        $quote_result_content = mb_substr($quote_result_content, 0, 100, 'utf-8') . '......';
                        for ($i = 0; $i < sizeof($quo[0]); $i++) {
                            $tmp = preg_replace("/\[quote](.+?)\[\/quote]/is", '<fieldset style="font-size: 12px;border: 1px solid #CCC;padding: 0 10px;margin: 0 0 5px 0;overflow-x: hidden;word-wrap: break-word;background:#fdfcf6;"><legend>' . htmlspecialchars(trim($youyax_cite), ENT_QUOTES, "UTF-8") . '</legend>' . $quote_result_fieldset . $quote_result_content . '</fieldset>', $quo[0][$i]);
                            $t2  = str_replace($quo[0][$i], $tmp, $t2);
                        }
                        $huanhang = array(
                            "\r\n",
                            "\n",
                            "\r"
                        );
                        $t2       = str_replace($huanhang, '<br>', $t2);
                    }
                }
                if (preg_match_all("/<embed[^>]*?\/\s*>/", $t2, $arr)) {
                    $val = "";
                    foreach ($arr[0] as $v) {
                        if (!preg_match_all("/wmode\s*=\s*\'\s*transparent\s*\'/", $v, $arr2)) {
                            $v1 = preg_replace("/\/>/", " wmode='transparent' />", $v);
                            $v2 = preg_replace("/<embed src/", "<param name='wmode' value='transparent' /><embed src", $v1);
                            $t2 = str_replace($v, $v2, $t2);
                        }
                    }
                }
                $recount_query     = $this->db->query("select num2,rid,id2 from " . $this->C('db_prefix') . "reply where rid=" . $t3 . " order by id2 desc");
                $recount_query_num = $this->db->query("select count(*) from " . $this->C('db_prefix') . "reply where rid=" . $t3 . " order by id2 desc")->fetchColumn();
                if ($recount_query_num > 0) {
                    $recount_arr = $recount_query->fetch();
                    $t4          = $recount_arr['num2'] + 1;
                } else {
                    $t4 = 1;
                }
                $islimit1arr = $this->find($this->C('db_prefix') . "talk", "string", intval($t3));
                $islimit1    = $islimit1arr['is_limit1'];
                if ($islimit1 == 1) {
                    $islimit1_num = $this->db->query("select count(*) from " . $this->C('db_prefix') . "reply where rid=" . $t3 . " and zuozhe1='" . $t1 . "'")->fetchColumn();
                    if ($islimit1_num > 0) {
                        $this->assign("msgtitle", "操作限制!")->assign("message", "该主题设置只允许回复1次!")->assign("jumpurl", $this->C('SITE'))->error();
                    }
                }
                if ($t4 >= 4) {
                    if (CommonAction::continuePost($t3, $t4)) {
                        $this->assign("msgtitle", "操作限制!")->assign("message", "一个用户只允许连续回复3次!")->assign("jumpurl", $this->C('SITE'))->error();
                    }
                }
                $user = $this->find($this->C('db_prefix') . "user", "string", "user='" . $t1 . "'");
                $t5   = $user['face'];
                $t6   = $user['time'];
                $t7   = $user['fatieshu'];
                /*添加手机设备识别 start*/
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'android')) {
                    $t2 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Android设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'iphone')) {
                    $t2 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPhone设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
                    $t2 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPad设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
                    $t2 .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Win Phone设备</div>";
                }
                /*添加手机设备识别 end*/
                $this->db->exec("insert into " . $this->C('db_prefix') . "reply(fatieshu2,timezc2,face1,zuozhe1,ori_content1,content1,rid,num2,time2,parentid2) values(" . $t7 . ",'" . $t6 . "','" . $t5 . "','" . $t1 . "','" . $t_ori . "','" . $t2 . "'," . $t3 . "," . $t4 . ",now()," . $_SESSION['youyax_f'] . ")");
                if ($bz) {
                    CommonAction::callSend($t4, $youyax_id_zuozhe, $t3, $this->youyax_url);
                }
                $this->db->exec("update " . $this->C('db_prefix') . "talk set timeup=now() where id=$t3");
                $this->db->exec("update " . $this->C('db_prefix') . "reply set face1='" . $t5 . "',timezc2='" . $t6 . "', fatieshu2='" . $t7 . "'  where  zuozhe1='" . $t1 . "'");
                $bid_arr = $this->find($this->C('db_prefix') . "talk", "string", "id='" . intval($t3) . "'");
                if ($bid_arr['zuozhe'] != $t1) {
                    $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+1 where  user='" . $t1 . "'");
                }
                CountAction::doPostCount();
                if ($_COOKIE['record'] == 'yellow2')
                    $page_tmp = 10;
                if ($_COOKIE['record'] == 'blue')
                    $page_tmp = 20;
                if (empty($_COOKIE['record']) || $_COOKIE['record'] == 'shallow')
                    $page_tmp = 15;
                if ($t4 <= $page_tmp) {
                    $this->redirect("Content" . $this->C('default_url') . $t3 . $this->C('static_url') . "#p" . $t4);
                } else {
                    $this->redirect("Content" . $this->C('default_url') . $t3 . $this->C('static_url') . "?page=" . ceil($t4 / $page_tmp) . "#p" . $t4);
                }
            } else {
                $_SESSION['youyax_user'] = "";
                @setcookie('youyax_user', '', time() - 3600, "/");
                @setcookie('youyax_cookieid', '', time() - 3600, "/");
                $this->assign("msgtitle", "操作错误!")->assign("message", "非法操作，请重新登陆!")->assign("jumpurl", $this->C('SITE'))->error();
            }
        }
    }
    public function Quick()
    {
        if (!CommonAction::userGroupVisit('access')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限访问!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (!empty($_SESSION['youyax_user'])) {
            $key = require("./Conf/key.config.php");
            $sql = "select * from " . $this->C('db_prefix') . "admin where binary user='" . $_SESSION['youyax_user'] . "'";
            $res = $this->db->query($sql);
            $arr = $res->fetch();
        } else {
            $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '未登录用户没有权限！')->error();
        }
        switch ($_POST['action']) {
            case 0:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass0']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $colors  = addslashes($_POST['colors']);
                        $topicid = intval($_POST['topicid']);
                        $arr     = $this->find($this->C('db_prefix') . "talk", 'string', $topicid);
                        if ($arr['parentid'] > 10000) {
                            $arr['title'] = preg_replace("/\[[^]]*]/", "", strip_tags($arr['title']));
                            $title        = "<span class=\'top\'>[置顶]</span>" . "<font color=" . $colors . ">" . $arr['title'] . "</font>";
                        } else {
                            $title = "<font color=" . $colors . ">" . strip_tags($arr['title']) . "</font>";
                        }
                        $data['title'] = addslashes($title);
                        $this->save($data, $this->C('db_prefix') . "talk", $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '主题颜色设置成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
            case 1:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass1']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $topicid          = intval($_POST['topicid']);
                        $arr              = $this->find($this->C('db_prefix') . "talk", 'string', $topicid);
                        $arr['title']     = preg_replace("/\[[^]]*]/", "", strip_tags($arr['title']));
                        $title            = "<span class=\'top\'>[置顶]</span>" . $arr['title'];
                        $arr['parentid']  = $arr['parentid'] > 10000 ? $arr['parentid'] : ($arr['parentid'] + 10000);
                        $data['parentid'] = (int) ($arr['parentid']);
                        $data['title']    = $title;
                        $this->save($data, $this->C('db_prefix') . "talk", $topicid);
                        $data['parentid2'] = (int) ($arr['parentid']);
                        $this->save($data, $this->C('db_prefix') . "reply", "rid=" . $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '主题置顶成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
            case 2:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass2']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $topicid          = intval($_POST['topicid']);
                        $arr              = $this->find($this->C('db_prefix') . "talk", 'string', $topicid);
                        $data['parentid'] = $_POST['small_zone'];
                        $data['title']    = preg_replace("/\[[^]]*]/", "", strip_tags($arr['title']));
                        $this->save($data, $this->C('db_prefix') . "talk", $topicid);
                        $data['parentid2'] = $_POST['small_zone'];
                        $this->save($data, $this->C('db_prefix') . "reply", "rid=" . $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '主题转移成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
            case 3:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass3']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $topicid = intval($_POST['topicid']);
                        if ($this->is_exist_widget("delPostPicWidget") && $this->is_active_widget("delPostPicWidget")) {
                            w("delPostPicWidget")->judge($topicid);
                        }
                        $this->delete($this->C('db_prefix') . "talk", $topicid);
                        $this->delete($this->C('db_prefix') . "reply", "rid=" . $topicid);
                        $this->delete($this->C('db_prefix') . "mark1", "tid='" . $topicid . "'");
                        $this->delete($this->C('db_prefix') . "mark2", "tid='" . $topicid . "'");
                        if ($vt = $this->find($this->C('db_prefix') . "vote", "string", "rid='" . $topicid . "'")) {
                            $this->delete($this->C('db_prefix') . "vote", "rid='" . $topicid . "'");
                            $this->delete($this->C('db_prefix') . "vote_ips", "vid='" . $vt['id'] . "'");
                        }
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '主题删除成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
            case 4:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass4']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $topicid = intval($_POST['topicid']);
                        $data    = $this->find($this->C('db_prefix') . "talk", 'string', $topicid);
                        if ($data['lock_status'] == 1) {
                            $dat['lock_status'] = 0;
                        } else {
                            $dat['lock_status'] = 1;
                        }
                        $this->save($dat, $this->C('db_prefix') . "talk", $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '主题锁定/解锁成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
            case 5:
                if ($this->cc_decrypt($arr['pass'], $key) == $_POST['apass5']) {
                    $purviews = unserialize($arr['purview']);
                    if (empty($purviews)) {
                        $purviews = array();
                    }
                    if (in_array($_SESSION['youyax_f'], $purviews)) {
                        $topicid = intval($_POST['topicid']);
                        $data    = $this->find($this->C('db_prefix') . "talk", 'string', $topicid);
                        if ($data['is_grap'] == 1) {
                            $dat['is_grap'] = 0;
                        } else {
                            $dat['is_grap'] = 1;
                        }
                        $this->save($dat, $this->C('db_prefix') . "talk", $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '精华设置/取消成功！')->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . $this->C('default_url') . $_SESSION['youyax_f'] . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '您没有管理员权限！')->error();
                }
                break;
        }
    }
    public function editupdate()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_f'])) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "没有版块标识，非法操作!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if (!CommonAction::userGroupVisit('access')) {
            $this->assign("msgtitle", "操作错误!")->assign("message", "您所在的用户组没有权限访问!")->assign("jumpurl", $this->C('SITE'))->error();
        }
        if ($_SESSION['youyax_user'] == addslashes($_POST['zuozhe']) && CommonAction::competence($_POST['zuozhe'])) {
            $id = !empty($_POST['id']) ? intval($_POST['id']) : intval($_POST['id2']);
            if (!is_numeric($id)) {
                $this->assign("msgtitle", "操作错误!")->assign("message", "编辑序号不为非数字!")->assign("jumpurl", $this->C('SITE'))->error();
            }
            if (match($_POST['content'], "content")) {
                $content = filter_var($_POST['content'], FILTER_CALLBACK, array(
                    "options" => "filter_function"
                ));
                $t_ori   = addslashes(htmlspecialchars($content, ENT_QUOTES, "UTF-8"));
                $content = $this->transform($content);
                /*添加手机设备识别 start*/
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'android')) {
                    $content .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Android设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'iphone')) {
                    $content .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPhone设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
                    $content .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自iPad设备</div>";
                }
                if (stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
                    $content .= "<div style=\'clear:both;\'></div><div style=\'float:right;margin-right:10px;margin-top:20px;margin-bottom:4px;background:#9b9b9b;color:#fff;border-radius:10px;padding:7px 10px;line-height:10px;\'>来自Win Phone设备</div>";
                }
                /*添加手机设备识别 end*/
                if ($this->find($this->C('db_prefix') . "talk", "string", "zuozhe='" . addslashes($_POST['zuozhe']) . "'  and id=" . $id) && !empty($_POST['id'])) {
                    $f                    = $this->find($this->C('db_prefix') . "talk", "string", "zuozhe='" . addslashes($_POST['zuozhe']) . "'  and id=" . $id);
                    $f['parentid']        = $f['parentid'] > 10000 ? $f['parentid'] - 10000 : $f['parentid'];
                    $data['ori_content']  = $t_ori;
                    $data['content']      = $content;
                    $data['last_modify1'] = date('Y-m-d H:i:s', time());
                    $this->save($data, $this->C('db_prefix') . "talk", "zuozhe='" . addslashes($_POST['zuozhe']) . "'  and id=" . $id);
                    $this->redirect("List" . $this->C('default_url') . $f['parentid'] . $this->C('static_url'));
                } else if ($this->find($this->C('db_prefix') . "reply", "string", "zuozhe1='" . addslashes($_POST['zuozhe']) . "'  and id2=" . $id) && !empty($_POST['id2'])) {
                    $f                    = $this->find($this->C('db_prefix') . "reply", "string", "zuozhe1='" . addslashes($_POST['zuozhe']) . "'  and id2=" . $id);
                    $f['parentid2']       = $f['parentid2'] > 10000 ? $f['parentid2'] - 10000 : $f['parentid2'];
                    $data['ori_content1'] = $t_ori;
                    $data['content1']     = $content;
                    $data['last_modify2'] = date('Y-m-d H:i:s', time());
                    $this->save($data, $this->C('db_prefix') . "reply", "zuozhe1='" . addslashes($_POST['zuozhe']) . "'  and id2=" . $id);
                    $this->redirect("List" . $this->C('default_url') . $f['parentid2'] . $this->C('static_url'));
                } else {
                    $this->assign("code", "操作错误!")->assign("msg", "您没有编辑该帖子权限!")->display("Public/exception.html");
                    echo "<script>setTimeout(function(){location.href = document.referrer;},2000);</script>";
                    exit;
                }
            }
        }
    }
    public function queryreallyuser()
    {
        $user = addslashes($_POST['user']);
        if ($this->find($this->C('db_prefix') . "user", 'string', "user='" . $user . "'")) {
            echo true;
        } else {
            echo false;
        }
    }
}
?>