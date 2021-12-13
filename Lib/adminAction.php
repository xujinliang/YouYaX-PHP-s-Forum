<?php
class adminAction extends YouYaX
{
    public function login()
    {
        if (!empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "index" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('token', $_SESSION['token'])->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/login.html");
    }
    public function validate()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $user = addslashes($_POST['user']);
        $pass = addslashes($_POST['pass']);
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') || stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
            $sql = "select * from " . $this->C('db_prefix') . "admin where binary user='" . $user . "' and isAdmin=1";
            $res = $this->db->query($sql);
            if ($res) {
                $arr = $res->fetch();
                $key = require("./Conf/key.config.php");
                if ($arr && $this->cc_decrypt($arr['pass'], $key) == $pass) {
                    $_SESSION['youyax_admin'] = $user;
                    echo "	<script>alert('登陆成功!');
							    parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "index" . $this->C('static_url') . "';
							</script>";
                } else {
                    echo "<script>alert('登陆失败!');
							parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "login" . $this->C('static_url') . "';
						 </script>";
                }
            } else {
                echo "<script>alert('登陆失败!');
							parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "login" . $this->C('static_url') . "';
						 </script>";
            }
        } else {
            $sql = "select * from " . $this->C('db_prefix') . "admin where binary user='" . $user . "' and isAdmin=1";
            $res = $this->db->query($sql);
            if ($res) {
                $arr = $res->fetch();
                $key = require("./Conf/key.config.php");
                if ($arr && $this->cc_decrypt($arr['pass'], $key) == $pass) {
                    $_SESSION['youyax_admin'] = $user;
                    echo "<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/public.js?" . time() . "'></script>
            			<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/Tip2.js'></script>
            			<script>Tip2('登陆成功,3秒后自动跳转',3,1,'parent');
								        for(var i=3;i>=0;i--){
								        (function(){
								          var TipNum=i;
									        t=setTimeout(
									         function(){	         	  
									          	if(TipNum == 0){
									          	 window.clearTimeout(t);
									          	 parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "index" . $this->C('static_url') . "';
									          	}
									          	if(parent.document.getElementById('TipMsg')){
									          		parent.document.getElementById('TipMsg').innerHTML='<table width=\"100%\" height=\"46\" border=\"0\"><tr><td>登陆成功,'+TipNum+'秒后自动跳转</td></tr></table>';
									          	}       	
									          },(3-TipNum)*1000);
								          })()
								         }</script>";
                } else {
                    echo "<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/public.js?" . time() . "'></script>
            		<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/Tip2.js'></script>
            		<script>Tip2('登陆失败,3秒后自动跳转',2,1,'parent');for(var i=3;i>=0;i--){
								        (function(){
								          var TipNum=i;
									        t=setTimeout(
									         function(){	         	  
									          	if(TipNum == 0){
									          	 window.clearTimeout(t);
									          	 parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "login" . $this->C('static_url') . "';
									          	}
									          	if(parent.document.getElementById('TipMsg')){
									          		parent.document.getElementById('TipMsg').innerHTML='<table width=\"100%\" height=\"46\" border=\"0\"><tr><td>登陆失败,'+TipNum+'秒后自动跳转</td></tr></table>';
									          	}
									          },(3-TipNum)*1000);
								          })()
								         }</script>";
                }
            } else {
                echo "<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/public.js?" . time() . "'></script>
            		<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/Tip2.js'></script>
            		<script>Tip2('登陆失败,3秒后自动跳转',2,1,'parent');for(var i=3;i>=0;i--){
								        (function(){
								          var TipNum=i;
									        t=setTimeout(
									         function(){	         	  
									          	if(TipNum == 0){
									          	 window.clearTimeout(t);
									          	 parent.window.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "login" . $this->C('static_url') . "';
									          	}
									          	if(parent.document.getElementById('TipMsg')){
									          		parent.document.getElementById('TipMsg').innerHTML='<table width=\"100%\" height=\"46\" border=\"0\"><tr><td>登陆失败,'+TipNum+'秒后自动跳转</td></tr></table>';
									          	}
									          },(3-TipNum)*1000);
								          })()
								         }</script>";
            }
        }
    }
    public function logout()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        unset($_SESSION['youyax_admin']);
        $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
    }
    public function index()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->content_desk_mobile();
        $this->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/index.html");
    }
    public function secindex()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/secindex.html");
    }
    public function tophead()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->assign('admin', $_SESSION['youyax_admin'])->display("admin/tophead.html");
    }
    public function leftbar()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/leftbar.html");
    }
    public function content_desk_mobile()
    {
        $reply_num_max  = $this->select("select * from (select num2,rid,time2  FROM " . $this->C('db_prefix') . "reply  where UNIX_TIMESTAMP(time2) between (UNIX_TIMESTAMP(now())-7*24*3600) and UNIX_TIMESTAMP(now()) order by num2 desc,time2 desc)tmp group by rid order by num2 desc,time2 desc limit 0,5");
        $scan_num_max   = $this->select("select *  FROM " . $this->C('db_prefix') . "talk where UNIX_TIMESTAMP(time1) between (UNIX_TIMESTAMP(now())-7*24*3600) and UNIX_TIMESTAMP(now()) order by num1 desc limit 0,5");
        $count_arr      = $this->find($this->C('db_prefix') . "count", "string", "id=1");
        $count_user     = unserialize($count_arr['user_count']) ? unserialize($count_arr['user_count']) : array();
        $count_user_num = 0;
        if (!empty($count_user)) {
            foreach ($count_user as $v) {
                $count_user_num += $v;
            }
        }
        $count_post     = unserialize($count_arr['post_count']) ? unserialize($count_arr['post_count']) : array();
        $count_post_num = 0;
        if (!empty($count_post)) {
            foreach ($count_post as $v) {
                $count_post_num += $v;
            }
        }
        $this->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->assign('count_user_num', $count_user_num)->assign('count_post_num', $count_post_num)->assign('reply_num_max', $reply_num_max)->assign('scan_num_max', $scan_num_max)->assign('url_connect', $this->youyax_url);
    }
    public function content()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->content_desk_mobile();
        $this->display("admin/content.html");
    }
    public function block()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('site', $this->C('SITE'));
        $sql  = "select big.id,big.bzone from " . $this->C('db_prefix') . "big_block big left join (select * from (select * from " . $this->C('db_prefix') . "small_block order by ssort desc,szone desc)smalltmp group by smalltmp.bid ) tmp on big.id=tmp.bid order by tmp.ssort desc,tmp.szone desc";
        $data = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign("data", $data)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/block.html");
    }
    public function blockTransform()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('site', $this->C('SITE'));
        $sql  = "select * from " . $this->C('db_prefix') . "small_block";
        $data = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign("data", $data)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/block_transform.html");
    }
    public function blockDoTransform()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $sql = "update " . $this->C('db_prefix') . "talk set parentid=" . intval($_POST['oto']) . " where parentid=" . intval($_POST['org']);
        $this->db->exec($sql);
        $sql = "update " . $this->C('db_prefix') . "reply set parentid2=" . intval($_POST['oto']) . " where parentid2=" . intval($_POST['org']);
        $this->db->exec($sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "blockTransform" . $this->C('static_url'));
    }
    public function delblock()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id      = $this->getparam("id");
        $big_sql = "delete from " . $this->C('db_prefix') . "big_block where id=" . $id;
        $this->db->exec($big_sql);
        $sql = "select * from " . $this->C('db_prefix') . "small_block where bid=" . $id;
        $res = $this->db->query($sql);
        $num = $this->db->query("select count(*) from " . $this->C('db_prefix') . "small_block where bid=" . $id)->fetchColumn();
        if ($num > 0) {
            while ($arr = $res->fetch()) {
                $cmall_sql = "delete from " . $this->C('db_prefix') . "small_block where sid=" . $arr['id'];
                $this->db->exec($cmall_sql);
            }
        }
        $small_sql = "delete from " . $this->C('db_prefix') . "small_block where bid=" . $id;
        $this->db->exec($small_sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "block" . $this->C('static_url'));
    }
    public function editblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id   = intval($_POST["id"]);
        $name = addslashes(htmlspecialchars($_POST["bzone"], ENT_QUOTES, "UTF-8"));
        if (empty($name)) {
            $_SESSION['youyax_error'] = 2;
        } else {
            $t = T($this->C('db_prefix') . "big_block");
            $t->arfind($id);
            $t->bzone                 = $name;
            $_SESSION['youyax_error'] = 1;
            $t->arsave();
        }
        $this->redirect("admin" . $this->C('default_url') . "block" . $this->C('static_url'));
    }
    public function addblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $name = addslashes(htmlspecialchars($_POST["bzone"], ENT_QUOTES, "UTF-8"));
        if (!empty($name)) {
            $t        = T($this->C('db_prefix') . "big_block");
            $t->bzone = $name;
            $t->aradd();
            $_SESSION['youyax_error'] = 1;
        } else {
            $_SESSION['youyax_error'] = 2;
            echo '<script>alert("名称必填项");</script>';
        }
        $this->redirect("admin" . $this->C('default_url') . "block" . $this->C('static_url'));
    }
    public function sblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('site', $this->C('SITE'));
        $data = $this->select("select * from " . $this->C('db_prefix') . "small_block where bid=" . $this->getparam("id") . " order by ssort desc,szone desc");
        $this->assign("data", $data);
        $data1 = $this->select("select * from " . $this->C('db_prefix') . "big_block");
        $this->assign("data1", $data1);
        $data3 = $this->find($this->C('db_prefix') . "big_block", "string", $this->getparam("id"));
        $this->assign('token', $_SESSION['token'])->assign("data3", $data3)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/sblock.html");
    }
    public function delsblock()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id        = $this->getparam("id");
        $bid       = $this->getparam("bid");
        $small_sql = "delete from " . $this->C('db_prefix') . "small_block where id=" . $id . " or sid=" . $id;
        $this->db->exec($small_sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "sblock" . $this->C('default_url') . "id" . $this->C('default_url') . $bid . $this->C('static_url'));
    }
    public function editsblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id       = intval($_POST["id"]);
        $szone    = addslashes(htmlspecialchars($_POST["szone"], ENT_QUOTES, "UTF-8"));
        $mark     = addslashes(htmlspecialchars($_POST["mark"], ENT_QUOTES, "UTF-8"));
        $icon_url = addslashes(htmlspecialchars($_POST["icon_url"], ENT_QUOTES, "UTF-8"));
        $bid      = intval($_POST["bid"]);
        $ssort    = intval($_POST['ssort']);
        $bbid     = intval($_POST["bbid"]);
        $t        = T($this->C('db_prefix') . "small_block");
        $t->arfind($id);
        $t->szone                 = $szone;
        $t->mark                  = nl2br($mark);
        $t->icon_url              = $icon_url;
        $t->bid                   = $bid;
        $t->ssort                 = $ssort;
        $_SESSION['youyax_error'] = 1;
        $t->arsave();
        $this->redirect("admin" . $this->C('default_url') . "sblock" . $this->C('default_url') . "id" . $this->C('default_url') . $bbid . $this->C('static_url'));
    }
    public function addsblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $szone    = addslashes(htmlspecialchars($_POST["szone"], ENT_QUOTES, "UTF-8"));
        $mark     = addslashes(htmlspecialchars($_POST["mark"], ENT_QUOTES, "UTF-8"));
        $bid      = intval($_POST["bid"]);
        $icon_url = addslashes(htmlspecialchars($_POST["icon_url"], ENT_QUOTES, "UTF-8"));
        if (!empty($szone) && !empty($bid)) {
            $t           = T($this->C('db_prefix') . "small_block");
            $t->szone    = $szone;
            $t->mark     = nl2br($mark);
            $t->icon_url = $icon_url;
            $t->bid      = $bid;
            $t->ssort    = 0;
            $t->aradd();
            $_SESSION['youyax_error'] = 1;
        } else {
            $_SESSION['youyax_error'] = 2;
            echo '<script>alert("名称或隶属必填项");</script>';
        }
        if (!empty($bid)) {
            $this->redirect("admin" . $this->C('default_url') . "sblock" . $this->C('default_url') . "id" . $this->C('default_url') . $bid . $this->C('static_url'));
        } else {
            $this->redirect("admin" . $this->C('default_url') . "block" . $this->C('static_url'));
        }
    }
    public function cblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('site', $this->C('SITE'));
        $data = $this->select("select * from " . $this->C('db_prefix') . "small_block where sid=" . $this->getparam("id") . " order by ssort desc,szone desc");
        $this->assign("data", $data);
        $data3 = $this->find($this->C('db_prefix') . "small_block", "string", $this->getparam("id"));
        $data2 = $this->find($this->C('db_prefix') . "big_block", "string", $data3['bid']);
        $this->assign('token', $_SESSION['token'])->assign("data3", $data3)->assign("data2", $data2)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/cblock.html");
    }
    public function addcblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $szone    = addslashes(htmlspecialchars($_POST["szone"], ENT_QUOTES, "UTF-8"));
        $mark     = addslashes(htmlspecialchars($_POST["mark"], ENT_QUOTES, "UTF-8"));
        $sid      = intval($_POST["sid"]);
        $icon_url = addslashes(htmlspecialchars($_POST["icon_url"], ENT_QUOTES, "UTF-8"));
        if (!empty($szone) && !empty($sid)) {
            $t           = T($this->C('db_prefix') . "small_block");
            $t->szone    = $szone;
            $t->mark     = nl2br($mark);
            $t->icon_url = $icon_url;
            $t->sid      = $sid;
            $t->ssort    = 0;
            $t->aradd();
            $_SESSION['youyax_error'] = 1;
        }
        $this->redirect("admin" . $this->C('default_url') . "cblock" . $this->C('default_url') . "id" . $this->C('default_url') . $sid . $this->C('static_url'));
    }
    public function delcblock()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id        = $this->getparam("id");
        $sid       = $this->getparam("sid");
        $small_sql = "delete from " . $this->C('db_prefix') . "small_block where id=" . $id;
        $this->db->exec($small_sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "cblock" . $this->C('default_url') . "id" . $this->C('default_url') . $sid . $this->C('static_url'));
    }
    public function editcblock()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id       = intval($_POST["id"]);
        $szone    = addslashes(htmlspecialchars($_POST["szone"], ENT_QUOTES, "UTF-8"));
        $mark     = addslashes(htmlspecialchars($_POST["mark"], ENT_QUOTES, "UTF-8"));
        $icon_url = addslashes(htmlspecialchars($_POST["icon_url"], ENT_QUOTES, "UTF-8"));
        $ssort    = intval($_POST['ssort']);
        $sid      = intval($_POST["sid"]);
        $t        = T($this->C('db_prefix') . "small_block");
        $t->arfind($id);
        $t->szone                 = $szone;
        $t->mark                  = nl2br($mark);
        $t->icon_url              = $icon_url;
        $t->ssort                 = $ssort;
        $_SESSION['youyax_error'] = 1;
        $t->arsave();
        $this->redirect("admin" . $this->C('default_url') . "cblock" . $this->C('default_url') . "id" . $this->C('default_url') . $sid . $this->C('static_url'));
    }
    public function admin()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "admin");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "admin order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/admin.html");
    }
    public function purview()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $id                = $this->getparam("id");
        $arr               = $this->find($this->C('db_prefix') . "admin", "string", "id='" . $id . "'");
        $purviews          = unserialize($arr['purview']) ? unserialize($arr['purview']) : array();
        if (empty($purviews)) {
            $purviews = array();
        }
        $lists = $this->select("select * from " . $this->C('db_prefix') . "small_block order by bid,ssort desc");
        $this->assign('token', $_SESSION['token'])->assign('list', $lists)->assign('arr', $arr)->assign('purviews', $purviews)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/purview.html");
    }
    public function purview2()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $id                = $this->getparam("id");
        $arr               = $this->find($this->C('db_prefix') . "user_group", "string", "id='" . $id . "'");
        $purviews          = unserialize($arr['purview']) ? unserialize($arr['purview']) : array();
        if (empty($purviews)) {
            $purviews = array();
        }
        $lists                 = $this->select("select * from " . $this->C('db_prefix') . "small_block order by bid,ssort desc");
        $config                = require("./Conf/config.php");
        $not_log_in_user_group = $config['not_log_in_user_group'];
        $this->assign('token', $_SESSION['token'])->assign('not_log_in_user_group', $not_log_in_user_group)->assign('list', $lists)->assign('arr', $arr)->assign('purviews', $purviews)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/purview2.html");
    }
    public function purviewUpdate()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $array = array();
        for ($k = 0; $k < count($_POST['ck']); $k++) {
            $array[] = intval($_POST['ck'][$k]);
        }
        $data['purview'] = serialize($array);
        $this->save($data, $this->C('db_prefix') . "admin", "id='" . intval($_POST['id']) . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "purview" . $this->C('default_url') . "id" . $this->C('default_url') . intval($_POST['id']) . $this->C('static_url'));
    }
    public function purviewUpdate2()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $array = array();
        $tmp   = array();
        if (!empty($_POST['access'])) {
            foreach ($_POST['access'] as $k => $n) {
                $tmp['access']  = $n;
                $tmp['publish'] = $_POST['publish'][$k];
                $tmp['reply']   = $_POST['reply'][$k];
                $tmp['mark']    = $_POST['mark'][$k];
                $array[$k]      = $tmp;
            }
        }
        $data['purview'] = serialize($array);
        $this->save($data, $this->C('db_prefix') . "user_group", "id='" . intval($_POST['id']) . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "purview2" . $this->C('default_url') . "id" . $this->C('default_url') . intval($_POST['id']) . $this->C('static_url'));
    }
    public function adminAdd()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $user = addslashes(htmlspecialchars($_POST["admin"], ENT_QUOTES, "UTF-8"));
        $pass = addslashes(htmlspecialchars($_POST["pass"], ENT_QUOTES, "UTF-8"));
        $pass = $this->cc_encrypt($pass);
        if (empty($user) || empty($pass) || empty($_POST['ac'])) {
            $_SESSION['youyax_error'] = 2;
        } else {
            if ($_POST['ac'] == "add" && !($this->find($this->C('db_prefix') . "admin", "string", "user='" . $user . "'"))) {
                $t          = T($this->C('db_prefix') . "admin");
                $t->user    = $user;
                $t->pass    = $pass;
                $t->isAdmin = 1;
                $t->aradd();
                $_SESSION['youyax_error'] = 1;
            } elseif ($_POST['ac'] == "update") {
                if ($this->find($this->C('db_prefix') . "admin", "string", "user='" . $user . "'")) {
                    $data['pass'] = $pass;
                    $this->save($data, $this->C('db_prefix') . "admin", "user='" . $user . "'");
                    $_SESSION['youyax_error'] = 1;
                } else {
                    $_SESSION['youyax_error'] = 2;
                }
            } else {
                $_SESSION['youyax_error'] = 2;
            }
        }
        $this->redirect("admin" . $this->C('default_url') . "admin" . $this->C('static_url'));
    }
    public function adminDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "admin");
        $t->arfind($id);
        $t->ardelete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "admin" . $this->C('static_url'));
    }
    public function adminDepose()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "admin");
        $t->arfind($id);
        $t->ardelete();
        $data['title'] = '';
        $this->save($data, $this->C('db_prefix') . "user", "user='" . $t->user . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "admin" . $this->C('static_url'));
    }
    public function mark1()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "mark1");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "mark1 order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->assign('site', $this->C('SITE'))->display("admin/mark1.html");
    }
    public function mark1Del()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "mark1");
        $t->arfind($id);
        $t->ardelete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "mark1" . $this->C('static_url'));
    }
    public function mark2()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "mark2");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "mark2 order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->assign('site', $this->C('SITE'))->display("admin/mark2.html");
    }
    public function mark2Del()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "mark2");
        $t->arfind($id);
        $t->ardelete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "mark2" . $this->C('static_url'));
    }
    public function reply()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "reply");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "reply order by id2 desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('list', $list)->assign('page', $showx)->assign('site', $this->C('SITE'))->assign('db_prefix', $this->C('db_prefix'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/reply.html");
    }
    public function replyDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id2");
        if ($this->is_exist_widget("delPostPicWidget") && $this->is_active_widget("delPostPicWidget")) {
            w("delPostPicWidget")->judgeReply($id);
        }
        $this->delete($this->C('db_prefix') . "reply", "id2=" . $id);
        $this->delete($this->C('db_prefix') . "mark2", "rid='" . $id . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "reply" . $this->C('static_url'));
    }
    public function talk()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token']               = md5(microtime(true));
        $_SESSION['talk_query_parentid'] = '';
        $_SESSION['talk_query_user']     = '';
        $mix                             = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "talk");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "talk order by id desc");
        $list   = $this->select($sql);
        $this->assign('list', $list)->assign('page', $showx);
        $data1 = $this->select("select * from " . $this->C('db_prefix') . "small_block");
        $this->assign('token', $_SESSION['token'])->assign("data1", $data1)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/talk.html");
    }
    public function talkQuery()
    {
        if ($_SESSION['token'] != $_POST['token'] && ($_GET["page"] == "" || $_GET["page"] == null)) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = md5(microtime(true));
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $parentid = addslashes($_POST['parentid']);
        $user     = addslashes($_POST['user']);
        if (empty($parentid) && empty($user)) {
            $parentid = $_SESSION['talk_query_parentid'];
            $user     = $_SESSION['talk_query_user'];
        } else {
            $_SESSION['talk_query_parentid'] = $parentid;
            $_SESSION['talk_query_user']     = $user;
        }
        if (empty($parentid)) {
            $tmp = " where 1=1";
            if (!empty($user)) {
                $tmp .= " and zuozhe='" . $user . "'";
            }
        } else {
            if ($parentid == 'invalid') {
                $arr = $this->select("select id from " . $this->C('db_prefix') . "small_block", "id");
                foreach ($arr as $v) {
                    $arr[] = intval($v + 10000);
                }
                $tmp = "where parentid not in (" . implode(",", $arr) . ")";
            } else {
                $tmp = "where parentid=" . intval($parentid);
            }
            if (!empty($user)) {
                $tmp .= " and zuozhe='" . $user . "'";
            }
        }
        $mix = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "talk " . $tmp);
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "talk " . $tmp . " order by id desc");
        $list   = $this->select($sql);
        $this->assign('list', $list)->assign('page', $showx);
        $data1 = $this->select("select * from " . $this->C('db_prefix') . "small_block");
        $this->assign('token', $_SESSION['token'])->assign("data1", $data1)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/talk.html");
    }
    public function talkUpdate()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = intval($_POST['update_txt_hidden']);
        $t  = T($this->C('db_prefix') . "talk");
        $t->arfind($id);
        $t->title = addslashes(htmlspecialchars($_POST['update_txt' . $id], ENT_QUOTES, "UTF-8"));
        $t->arsave();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkQuery" . $this->C('static_url'));
    }
    public function movetalk()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = intval($_POST['id']);
        $t  = T($this->C('db_prefix') . "talk");
        $t->arfind($id);
        $t->parentid = intval($_POST['parentid']);
        $t->arsave();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkQuery" . $this->C('static_url'));
    }
    public function movetalkAll()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $ids = explode(",", addslashes($_POST['ids']));
        foreach ($ids as $id) {
            $t = T($this->C('db_prefix') . "talk");
            $t->arfind($id);
            $t->parentid = intval($_POST['parentid']);
            $t->arsave();
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkQuery" . $this->C('static_url'));
    }
    public function talkDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        if ($this->is_exist_widget("delPostPicWidget") && $this->is_active_widget("delPostPicWidget")) {
            w("delPostPicWidget")->judge($id);
        }
        $t = T($this->C('db_prefix') . "talk");
        $t->arfind($id);
        $t->ardelete();
        $this->delete($this->C('db_prefix') . "reply", "rid='" . $id . "'");
        $this->delete($this->C('db_prefix') . "mark1", "tid='" . $id . "'");
        $this->delete($this->C('db_prefix') . "mark2", "tid='" . $id . "'");
        if ($vt = $this->find($this->C('db_prefix') . "vote", "string", "rid='" . $id . "'")) {
            $this->delete($this->C('db_prefix') . "vote", "rid='" . $id . "'");
            $this->delete($this->C('db_prefix') . "vote_ips", "vid='" . $vt['id'] . "'");
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkQuery" . $this->C('static_url'));
    }
    public function talkDelAll()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        for ($k = 0; $k < count($_POST['cb']); $k++) {
            $id = intval($_POST['cb'][$k]);
            if ($this->is_exist_widget("delPostPicWidget") && $this->is_active_widget("delPostPicWidget")) {
                w("delPostPicWidget")->judge($id);
            }
            $t = T($this->C('db_prefix') . "talk");
            $t->arfind($id);
            $t->ardelete();
            $this->delete($this->C('db_prefix') . "reply", "rid='" . $id . "'");
            $this->delete($this->C('db_prefix') . "mark1", "tid='" . $id . "'");
            $this->delete($this->C('db_prefix') . "mark2", "tid='" . $id . "'");
            if ($vt = $this->find($this->C('db_prefix') . "vote", "string", "rid='" . $id . "'")) {
                $this->delete($this->C('db_prefix') . "vote", "rid='" . $id . "'");
                $this->delete($this->C('db_prefix') . "vote_ips", "vid='" . $vt['id'] . "'");
            }
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkQuery" . $this->C('static_url'));
    }
    public function user()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res             = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "user");
        $countx          = $res->fetch();
        $fenye           = new Fenye($countx['count'], 40);
        $showx           = $fenye->show();
        $showx           = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql             = $fenye->listcon("select * from " . $this->C('db_prefix') . "user order by id desc");
        $list            = $this->select($sql);
        $user_group_data = $this->select("select * from " . $this->C('db_prefix') . "user_group order by id desc");
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('user_group_data', $user_group_data)->assign('page', $showx)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/user.html");
    }
    public function dosUser()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = md5(microtime(true));
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $mix = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res             = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "user where user='" . addslashes($_POST['suser']) . "'");
        $countx          = $res->fetch();
        $fenye           = new Fenye($countx['count'], 40);
        $showx           = $fenye->show();
        $showx           = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql             = $fenye->listcon("select * from " . $this->C('db_prefix') . "user where user='" . addslashes($_POST['suser']) . "' order by id desc");
        $list            = $this->select($sql);
        $user_group_data = $this->select("select * from " . $this->C('db_prefix') . "user_group order by id desc");
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('user_group_data', $user_group_data)->assign('page', $showx)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/user.html");
    }
    public function userSetGroup()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = intval($_POST['id']);
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $t->user_group = intval($_POST['user_group_data']);
        $t->arsave();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userForbid()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $t->status = 2;
        $t->arsave();
        $user_hot     = array();
        $user_hot_arr = $this->find($this->C('db_prefix') . "count", "string", "id=1");
        if ($user_hot_arr['user_hot']) {
            $user_hot = unserialize($user_hot_arr['user_hot']) ? unserialize($user_hot_arr['user_hot']) : array();
            foreach ($user_hot as $k => $v) {
                if ($k == $id) {
                    unset($user_hot[$k]);
                }
            }
            $data             = array();
            $data['user_hot'] = serialize($user_hot);
            $this->save($data, $this->C('db_prefix') . "count", "id=1");
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userAppoint()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $t->title = 'ico_title.png';
        $t->arsave();
        if (!$this->find($this->C('db_prefix') . "admin", "string", "user='" . $t->user . "'")) {
            $at          = T($this->C('db_prefix') . "admin");
            $at->user    = $t->user;
            $at->pass    = $t->pass;
            $at->isAdmin = 0;
            $at->aradd();
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userDepose()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $t->title = '';
        $t->arsave();
        if (!$this->find($this->C('db_prefix') . "admin", "string", "user='" . $t->user . "' and isAdmin=1")) {
            $this->delete($this->C('db_prefix') . "admin", "user='" . $t->user . "'");
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userEmpty()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $user = $t->user;
        $arr  = $this->select("select id from " . $this->C('db_prefix') . "talk where zuozhe='" . $user . "'", "id");
        if (!empty($arr)) {
            for ($k = 0; $k < count($arr); $k++) {
                $id = intval($arr[$k]);
                if ($this->is_exist_widget("delPostPicWidget") && $this->is_active_widget("delPostPicWidget")) {
                    w("delPostPicWidget")->judge($id);
                }
                $t = T($this->C('db_prefix') . "talk");
                $t->arfind($id);
                $t->ardelete();
                if ($vt = $this->find($this->C('db_prefix') . "vote", "string", "rid='" . $id . "'")) {
                    $this->delete($this->C('db_prefix') . "vote", "rid='" . $id . "'");
                    $this->delete($this->C('db_prefix') . "vote_ips", "vid='" . $vt['id'] . "'");
                }
            }
        }
        $this->delete($this->C('db_prefix') . "reply", "zuozhe1='" . $user . "'");
        $this->delete($this->C('db_prefix') . "mark1", "marker='" . $user . "'");
        $this->delete($this->C('db_prefix') . "mark2", "marker='" . $user . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userUnfor()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $openid  = $t->openid;
        $weiboid = $t->weiboid;
        if (!empty($openid)) {
            $t->status = 3;
        } else if (!empty($weiboid)) {
            $t->status = 4;
        } else {
            $t->status = 1;
        }
        $t->arsave();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function userDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "user");
        $t->arfind($id);
        $t->ardelete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function setting()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $site_config       = require("./Conf/site.config.php");
        $this->assign('token', $_SESSION['token'])->assign('site_config', $site_config)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/setting.html");
    }
    public function dosetting()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $site_config = require("./Conf/site.config.php");
        if (!empty($_POST['title'])) {
            $site_config['site_title']        = htmlspecialchars($_POST['title'], ENT_QUOTES, "UTF-8");
            $site_config['site_title_mobile'] = htmlspecialchars($_POST['title_mobile'], ENT_QUOTES, "UTF-8");
        }
        $site_config['site_keywords']    = htmlspecialchars($_POST['keywords'], ENT_QUOTES, "UTF-8");
        $site_config['site_description'] = htmlspecialchars($_POST['description'], ENT_QUOTES, "UTF-8");
        $site_config['site_logo']        = htmlspecialchars($_POST['logo'], ENT_QUOTES, "UTF-8");
        $site_config['site_foot']        = str_replace(array(
            '"',
            '<script>',
            '</script>'
        ), array(
            "'",
            "&lt;script&gt;",
            "&lt;/script&gt;"
        ), $_POST['foot']);
        $file                            = "<?php return " . var_export($site_config, true) . "; ?>";
        file_put_contents("./Conf/site.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "setting" . $this->C('static_url'));
    }
    public function mailset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $user_group_data   = $this->select("select * from " . $this->C('db_prefix') . "user_group order by id desc");
        $mail_config       = require("./Conf/mail.config.php");
        $config            = require("./Conf/config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', $config)->assign('mail_config', $mail_config)->assign('user_group_data', $user_group_data)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/mailset.html");
    }
    public function domailset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $config                          = require("./Conf/config.php");
        $config['register_mode']         = intval($_POST['reg']);
        $config['default_user_group']    = intval($_POST['default_user_group']);
        $config['not_log_in_user_group'] = intval($_POST['not_log_in_user_group']);
        $file                            = "<?php return " . var_export($config, true) . "; ?>";
        file_put_contents("./Conf/config.php", $file, LOCK_EX);
        if ($_POST['reg'] == 1 || $_POST['reg'] == 3) {
            $mail_config = require("./Conf/mail.config.php");
            if ($_POST['reg'] == 1) {
                $mail_config['mail_Host']     = htmlspecialchars($_POST['host'], ENT_QUOTES, "UTF-8");
                $mail_config['mail_Username'] = htmlspecialchars($_POST['huser'], ENT_QUOTES, "UTF-8");
                $mail_config['mail_Password'] = htmlspecialchars($_POST['hpass'], ENT_QUOTES, "UTF-8");
            }
            $mail_config['mail_From']     = htmlspecialchars($_POST['ufrom'], ENT_QUOTES, "UTF-8");
            $mail_config['mail_FromName'] = htmlspecialchars($_POST['uname'], ENT_QUOTES, "UTF-8");
            $mail_config['mail_Subject']  = htmlspecialchars($_POST['utitle'], ENT_QUOTES, "UTF-8");
            $mail_config['mail_Body']     = htmlspecialchars($_POST['ucon'], ENT_QUOTES, "UTF-8");
            $file                         = "<?php return " . var_export($mail_config, true) . "; ?>";
            file_put_contents("./Conf/mail.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "mailset" . $this->C('static_url'));
    }
    public function seoset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $config            = require("./Conf/config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', $config)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/seoset.html");
    }
    public function doseoset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $config            = require("./Conf/config.php");
        $config['seo_set'] = htmlspecialchars($_POST['seostatus'], ENT_QUOTES, "UTF-8");
        $file              = "<?php return " . var_export($config, true) . "; ?>";
        file_put_contents("./Conf/config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "seoset" . $this->C('static_url'));
    }
    public function customTitle()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $config            = require("./Conf/custom_title.config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', $config)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/custom_title.html");
    }
    public function docustomTitle()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $title = $_POST['title'];
        $min   = $_POST['min'];
        $max   = $_POST['max'];
        $file  = '';
        foreach ($title as $k => $v) {
            $file .= "array('title'=>'" . htmlspecialchars($v, ENT_QUOTES, "UTF-8") . "','min'=>'" . intval($min[$k]) . "','max'=>'" . $max[$k] . "'),";
        }
        $file = "array(" . $file . ")";
        $file = "<?php return " . $file . "; ?>";
        file_put_contents("./Conf/custom_title.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "customTitle" . $this->C('static_url'));
    }
    public function friendUrlSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $config            = require("./Conf/friend_url.config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', $config)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/friend_url_set.html");
    }
    public function doFriendUrl()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $title = $_POST['title'];
        $url   = $_POST['url'];
        $file  = '';
        foreach ($title as $k => $v) {
            $file .= "array('title'=>'" . htmlspecialchars($v, ENT_QUOTES, "UTF-8") . "','url'=>'" . htmlspecialchars($url[$k], ENT_QUOTES, "UTF-8") . "'),";
        }
        $file = "array(" . $file . ")";
        $file = "<?php return " . $file . "; ?>";
        file_put_contents("./Conf/friend_url.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "friendUrlSet" . $this->C('static_url'));
    }
    public function talkVote()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "vote");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "vote order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/talk_vote.html");
    }
    public function talkVoteDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "vote");
        $t->arfind($id);
        $t->ardelete();
        $this->delete($this->C('db_prefix') . "vote_ips", "vid='" . $id . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "talkVote" . $this->C('static_url'));
    }
    public function voteIp()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "vote_ips");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "vote_ips order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/vote_ip.html");
    }
    public function voteIpDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id = $this->getparam("id");
        $t  = T($this->C('db_prefix') . "vote_ips");
        $t->arfind($id);
        $t->ardelete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "voteIp" . $this->C('static_url'));
    }
    public function menuCnSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        if ($this->getparam("sp") == 'en') {
            $mc = require("./Conf/menu_en.config.php");
            $this->assign('sp', 'en');
        } else {
            $mc = require("./Conf/menu.config.php");
            $this->assign('sp', 'cn');
        }
        $this->assign('token', $_SESSION['token'])->assign('mc', $mc)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/menu_cn_set.html");
    }
    public function doMenuCnSet()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $array = array();
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        foreach ($_POST as $k => $v) {
            if ($k == 'x' || $k == 'y') {
                unset($_POST[$k]);
            }
            $num = preg_match_all('/-/', $k, $match);
            if ($num == 1) {
                $tmp = explode("-", $k);
                if (empty($array[$tmp[0]]['seclists'])) {
                    $array[$tmp[0]]['seclists'] = array();
                }
                $array[$tmp[0]][$tmp[1]] = htmlspecialchars($v, ENT_QUOTES, "UTF-8");
            }
            if ($num == 2) {
                $tmp = explode("-", $k);
                if (empty($array[$tmp[0]]['seclists'])) {
                    $array[$tmp[0]]['seclists'] = array();
                }
                $array[$tmp[0]]['seclists'][$tmp[1]][$tmp[2]] = htmlspecialchars($v, ENT_QUOTES, "UTF-8");
            }
        }
        $array = array_sort($array, 'ord', SORT_DESC);
        $file  = "<?php return " . var_export($array, true) . "; ?>";
        if ($_POST['sp'] == 'cn') {
            file_put_contents("./Conf/menu.config.php", $file, LOCK_EX);
        }
        if ($_POST['sp'] == 'en') {
            file_put_contents("./Conf/menu_en.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "menuCnSet" . $this->C('default_url') . "sp" . $this->C('default_url') . $_POST['sp'] . $this->C('static_url'));
    }
    public function doMenuCnSetDelone()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $array = array();
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        if ($this->getparam("sp") == 'cn') {
            $mc = require("./Conf/menu.config.php");
        }
        if ($this->getparam("sp") == 'en') {
            $mc = require("./Conf/menu_en.config.php");
        }
        $oid = $this->getparam("oid");
        foreach ($mc as $k => $v) {
            if ($k == $oid) {
                unset($mc[$k]);
            } else {
                $array[] = $v;
            }
        }
        $file = "<?php return " . var_export($array, true) . "; ?>";
        if ($this->getparam("sp") == 'cn') {
            file_put_contents("./Conf/menu.config.php", $file, LOCK_EX);
        }
        if ($this->getparam("sp") == 'en') {
            file_put_contents("./Conf/menu_en.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $sp                       = $this->getparam("sp");
        $this->redirect("admin" . $this->C('default_url') . "menuCnSet" . $this->C('default_url') . "sp" . $this->C('default_url') . $sp . $this->C('static_url'));
    }
    public function doMenuCnSetDeltwo()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $array = array();
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        if ($this->getparam("sp") == 'cn') {
            $mc = require("./Conf/menu.config.php");
        }
        if ($this->getparam("sp") == 'en') {
            $mc = require("./Conf/menu_en.config.php");
        }
        $oid = $this->getparam("oid");
        $tid = $this->getparam("tid");
        foreach ($mc as $k => $v) {
            if (!empty($v['seclists'])) {
                if ($k == $oid) {
                    foreach ($v['seclists'] as $kk => $vv) {
                        if ($kk == $tid) {
                            $array[$k]['title'] = $v['title'];
                            $array[$k]['url']   = $v['url'];
                            unset($mc[$k]['seclists'][$kk]);
                            if (!is_array($array[$k]['seclists'])) {
                                $array[$k]['seclists'] = array();
                            }
                            $array[$k]['ord'] = $v['ord'];
                        } else {
                            $array[$k]['title']      = $v['title'];
                            $array[$k]['url']        = $v['url'];
                            $array[$k]['seclists'][] = $vv;
                            $array[$k]['ord']        = $v['ord'];
                        }
                    }
                } else {
                    $array[$k] = $v;
                }
            } else {
                $array[$k]['title']    = $v['title'];
                $array[$k]['url']      = $v['url'];
                $array[$k]['seclists'] = array();
                $array[$k]['ord']      = $v['ord'];
            }
        }
        $file = "<?php return " . var_export($array, true) . "; ?>";
        if ($this->getparam("sp") == 'cn') {
            file_put_contents("./Conf/menu.config.php", $file, LOCK_EX);
        }
        if ($this->getparam("sp") == 'en') {
            file_put_contents("./Conf/menu_en.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $sp                       = $this->getparam("sp");
        $this->redirect("admin" . $this->C('default_url') . "menuCnSet" . $this->C('default_url') . "sp" . $this->C('default_url') . $sp . $this->C('static_url'));
    }
    public function doMenuCnSetAddone()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $array = array();
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        if ($_POST['sp2'] == 'cn') {
            $mc = require("./Conf/menu.config.php");
        }
        if ($_POST['sp2'] == 'en') {
            $mc = require("./Conf/menu_en.config.php");
        }
        $array['title']    = htmlspecialchars($_POST['oname'], ENT_QUOTES, "UTF-8");
        $array['url']      = htmlspecialchars($_POST['ourl'], ENT_QUOTES, "UTF-8");
        $array['seclists'] = array();
        $array['ord']      = 0;
        $mc[]              = $array;
        $file              = "<?php return " . var_export($mc, true) . "; ?>";
        if ($_POST['sp2'] == 'cn') {
            file_put_contents("./Conf/menu.config.php", $file, LOCK_EX);
        }
        if ($_POST['sp2'] == 'en') {
            file_put_contents("./Conf/menu_en.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "menuCnSet" . $this->C('default_url') . "sp" . $this->C('default_url') . $_POST['sp2'] . $this->C('static_url'));
    }
    public function doMenuCnSetAddtwo()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        $array = array();
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        if ($_POST['sp2'] == 'cn') {
            $mc = require("./Conf/menu.config.php");
        }
        if ($_POST['sp2'] == 'en') {
            $mc = require("./Conf/menu_en.config.php");
        }
        $array['title']                  = htmlspecialchars($_POST['tname'], ENT_QUOTES, "UTF-8");
        $array['url']                    = htmlspecialchars($_POST['turl'], ENT_QUOTES, "UTF-8");
        $mc[$_POST['oid']]['seclists'][] = $array;
        $file                            = "<?php return " . var_export($mc, true) . "; ?>";
        if ($_POST['sp2'] == 'cn') {
            file_put_contents("./Conf/menu.config.php", $file, LOCK_EX);
        }
        if ($_POST['sp2'] == 'en') {
            file_put_contents("./Conf/menu_en.config.php", $file, LOCK_EX);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "menuCnSet" . $this->C('default_url') . "sp" . $this->C('default_url') . $_POST['sp2'] . $this->C('static_url'));
    }
    public function filterSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $config            = require("./Conf/filter.config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', var_export($config, true))->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/filter_set.html");
    }
    public function doFilter()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $filter = $_POST['filter_area'];
        $file   = "<?php return " . stripslashes($filter) . "; ?>";
        file_put_contents("./Conf/filter.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "filterSet" . $this->C('static_url'));
    }
    public function adsSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $ads               = require("./Conf/ads.config.php");
        $this->assign('token', $_SESSION['token'])->assign('ads', $ads)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/ads_set.html");
    }
    public function doAds()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $filter = htmlspecialchars($_POST['ads'], ENT_QUOTES, "UTF-8");
        $file   = "<?php return '" . htmlspecialchars($filter, ENT_QUOTES, "UTF-8") . "'; ?>";
        file_put_contents("./Conf/ads.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "adsSet" . $this->C('static_url'));
    }
    public function pluginView()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $array             = array();
        $dir               = dir("Plugin");
        while (($file = $dir->read()) !== false) {
            if ($file != "." && $file != ".." && preg_match_all("/Widget\.php/", $file, $tmp)) {
                $array[] = $file;
            }
        }
        $dir->close();
        if (count($array) != count(array_unique($array))) {
            $this->assign("Tip", "插件名不能重复!")->display("Public/plugin_error.html");
            exit;
        } else {
            $array2 = array();
            $data   = $this->select("select * from " . $this->C('db_prefix') . "plugin where status=1");
            foreach ($data as $v) {
                $array2[] = $v['name'];
            }
            $this->assign('token', $_SESSION['token'])->assign('plu_arr', $array)->assign('plu_in_arr', $array2)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/plugin_view.html");
        }
    }
    public function mixSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        $this->assign('token', $_SESSION['token'])->assign('mix', $mix)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/mix_set.html");
    }
    public function doMix()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $config = require("./Conf/mix.config.php");
        if (!is_numeric($_POST['list_per']) || !is_numeric($_POST['admin_count_num'])) {
            $_SESSION['youyax_error'] = 2;
            $this->redirect("admin" . $this->C('default_url') . "mix_set" . $this->C('static_url'));
        }
        $config['list_per']        = intval($_POST['list_per']);
        $config['list_fold']       = ($_POST['list_fold'] == 1) ? true : false;
        $config['list_style']      = intval($_POST['list_style']);
        $config['talk_title']      = intval($_POST['talk_title']);
        $config['talk_content']    = intval($_POST['talk_content']);
        $config['talk_visible']    = ($_POST['talk_visible'] == 1) ? true : false;
        $config['fenye_style']     = intval($_POST['fenye_style']);
        $config['is_prevent_reg']  = ($_POST['is_prevent_reg'] == 1) ? true : false;
        $config['prevent_reg_num'] = intval($_POST['prevent_reg_num']);
        $config['is_limit_time']   = ($_POST['is_limit_time'] == 1) ? true : false;
        $config['limit_time']      = intval($_POST['limit_time']);
        $config['bid_init']        = intval($_POST['bid_init']);
        $config['admin_count_num'] = intval($_POST['admin_count_num']);
        $file                      = "<?php return " . var_export($config, true) . "; ?>";
        file_put_contents("./Conf/mix.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "mixSet" . $this->C('static_url'));
    }
    public function adsPollSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $poll              = require("./Conf/ads_poll.config.php");
        $this->assign('token', $_SESSION['token'])->assign('poll', $poll)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/ads_poll_set.html");
    }
    public function doAdsPollSet()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $img   = $_POST['img'];
        $title = $_POST['title'];
        $url   = $_POST['url'];
        $ord   = $_POST['ord'];
        $file  = '';
        foreach ($img as $k => $v) {
            $file .= "array('img'=>'" . htmlspecialchars($v, ENT_QUOTES, "UTF-8") . "','title'=>'" . htmlspecialchars($title[$k], ENT_QUOTES, "UTF-8") . "','url'=>'" . htmlspecialchars($url[$k], ENT_QUOTES, "UTF-8") . "','ord'=>'" . intval($ord[$k]) . "'),";
        }
        $file = "array(" . $file . ")";
        $file = "<?php return " . $file . "; ?>";
        file_put_contents("./Conf/ads_poll.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "adsPollSet" . $this->C('static_url'));
    }
    public function placardSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $placard           = require("./Conf/placard_set.config.php");
        $this->assign('token', $_SESSION['token'])->assign('placard', $placard)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/placard_set.html");
    }
    public function doPlacardSet()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $title = $_POST['title'];
        $url   = $_POST['url'];
        $ord   = $_POST['ord'];
        $file  = '';
        foreach ($title as $k => $v) {
            $file .= "array('title'=>'" . htmlspecialchars($title[$k], ENT_QUOTES, "UTF-8") . "','url'=>'" . htmlspecialchars($url[$k], ENT_QUOTES, "UTF-8") . "','ord'=>'" . intval($ord[$k]) . "'),";
        }
        $file = "array(" . $file . ")";
        $file = "<?php return " . $file . "; ?>";
        file_put_contents("./Conf/placard_set.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "placardSet" . $this->C('static_url'));
    }
    public function keyset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $key               = require("./Conf/key.config.php");
        $this->assign('token', $_SESSION['token'])->assign('key', $key)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/key_set.html");
    }
    public function dokey()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $oldkey = require("./Conf/key.config.php");
        $filter = htmlspecialchars($_POST['keys'], ENT_QUOTES, "UTF-8");
        $file   = "<?php return '" . htmlspecialchars($filter, ENT_QUOTES, "UTF-8") . "'; ?>";
        file_put_contents("./Conf/key.config.php", $file, LOCK_EX);
        $key_admin = $this->select("select * from " . $this->C('db_prefix') . "admin");
        foreach ($key_admin as $k => $n) {
            $oldpass = $this->cc_decrypt($n['pass'], $oldkey);
            $this->db->exec("update " . $this->C('db_prefix') . "admin set pass='" . $this->cc_encrypt($oldpass,$filter) . "' where id=" . $n['id']);
        }
        $key_user = $this->select("select id,pass from " . $this->C('db_prefix') . "user");
        foreach ($key_user as $k => $n) {
            $oldpass = $this->cc_decrypt($n['pass'], $oldkey);
            $this->db->exec("update " . $this->C('db_prefix') . "user set pass='" . $this->cc_encrypt($oldpass,$filter) . "' where id=" . $n['id']);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "keyset" . $this->C('static_url'));
    }
    public function qqset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $qq                = require("./Conf/qq.config.php");
        $this->assign('token', $_SESSION['token'])->assign('qq', $qq)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/qq_set.html");
    }
    public function doqqset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $qq               = require("./Conf/qq.config.php");
        $qq['app_id']     = htmlspecialchars($_POST['app_id'], ENT_QUOTES, "UTF-8");
        $qq['app_secret'] = htmlspecialchars($_POST['app_secret'], ENT_QUOTES, "UTF-8");
        $file             = "<?php return " . var_export($qq, true) . "; ?>";
        file_put_contents("./Conf/qq.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "qqset" . $this->C('static_url'));
    }
    public function weiboset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $weibo             = require("./Conf/weibo.config.php");
        $this->assign('token', $_SESSION['token'])->assign('weibo', $weibo)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/weibo_set.html");
    }
    public function doWeiboset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $wb               = require("./Conf/weibo.config.php");
        $wb['app_id']     = htmlspecialchars($_POST['app_id'], ENT_QUOTES, "UTF-8");
        $wb['app_secret'] = htmlspecialchars($_POST['app_secret'], ENT_QUOTES, "UTF-8");
        $wb['callback']   = htmlspecialchars($_POST['callback'], ENT_QUOTES, "UTF-8");
        $file             = "<?php return " . var_export($wb, true) . "; ?>";
        file_put_contents("./Conf/weibo.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "weiboset" . $this->C('static_url'));
    }
    public function verticalSet()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $placard           = require("./Conf/vertical_set.config.php");
        $this->assign('token', $_SESSION['token'])->assign('placard', $placard)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/vertical_set.html");
    }
    public function doVerticalSet()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $title = $_POST['title'];
        $url   = $_POST['url'];
        $ord   = $_POST['ord'];
        $file  = '';
        foreach ($title as $k => $v) {
            $file .= "array('title'=>'" . htmlspecialchars($title[$k], ENT_QUOTES, "UTF-8") . "','url'=>'" . htmlspecialchars($url[$k], ENT_QUOTES, "UTF-8") . "','ord'=>'" . intval($ord[$k]) . "'),";
        }
        $file = "array(" . $file . ")";
        $file = "<?php return " . $file . "; ?>";
        file_put_contents("./Conf/vertical_set.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "verticalSet" . $this->C('static_url'));
    }
    public function userGroup()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "user_group");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "user_group order by id asc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/user_group.html");
    }
    public function userGroupAdd()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $name = addslashes(htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8"));
        if (!empty($name)) {
            $t       = T($this->C('db_prefix') . "user_group");
            $t->name = $name;
            $t->aradd();
            $_SESSION['youyax_error'] = 1;
        } else {
            $_SESSION['youyax_error'] = 2;
            echo '<script>alert("名称必填项");</script>';
        }
        $this->redirect("admin" . $this->C('default_url') . "userGroup" . $this->C('static_url'));
    }
    public function userGroupMod()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id   = intval($_POST["id"]);
        $name = addslashes(htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8"));
        if (empty($name)) {
            $_SESSION['youyax_error'] = 2;
        } else {
            $t = T($this->C('db_prefix') . "user_group");
            $t->arfind($id);
            $t->name                  = $name;
            $_SESSION['youyax_error'] = 1;
            $t->arsave();
        }
        $this->redirect("admin" . $this->C('default_url') . "userGroup" . $this->C('static_url'));
    }
    public function userGroupDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id  = $this->getparam("id");
        $sql = "delete from " . $this->C('db_prefix') . "user_group where id=" . $id;
        $this->db->exec($sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "userGroup" . $this->C('static_url'));
    }
    public function jubao()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $mix               = require("./Conf/mix.config.php");
        require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
        $res    = $this->db->query("select count(*) as count from " . $this->C('db_prefix') . "jubao");
        $countx = $res->fetch();
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("<span style='width:2px;display:inline-block;'></span>", $showx);
        $sql    = $fenye->listcon("select * from " . $this->C('db_prefix') . "jubao order by id desc");
        $list   = $this->select($sql);
        $this->assign('token', $_SESSION['token'])->assign('data', $list)->assign('page', $showx)->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/jubao.html");
    }
    public function jubaoDel()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id  = $this->getparam("id");
        $sql = "delete from " . $this->C('db_prefix') . "jubao where id=" . $id;
        $this->db->exec($sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "jubao" . $this->C('static_url'));
    }
    public function bidSet()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $id         = intval($_POST['id']);
        $arr        = $this->find($this->C('db_prefix') . "user", 'string', "id='" . $id . "'");
        $bid_reason = empty($_POST['bid_reason']) ? '无' : addslashes(htmlspecialchars($_POST["bid_reason"], ENT_QUOTES, "UTF-8"));
        if ($_POST['bid_op'] == 1) {
            $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+" . intval($_POST['bid_text']) . " where  id='" . $id . "'");
            CommonAction::adminSend($arr['user'], '管理员奖励了你 ' . intval($_POST['bid_text']) . ' 金币，操作原因: ' . $bid_reason);
        }
        if ($_POST['bid_op'] == 2) {
            $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid-" . intval($_POST['bid_text']) . " where  id='" . $id . "'");
            CommonAction::adminSend($arr['user'], '管理员处罚了你 ' . intval($_POST['bid_text']) . ' 金币，操作原因: ' . $bid_reason);
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "user" . $this->C('static_url'));
    }
    public function blockSetPurview()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $user_group       = array();
        $user_group_query = $this->db->query("select * from " . $this->C('db_prefix') . "user_group");
        while ($user_group_arr = $user_group_query->fetch()) {
            $tmp            = array();
            $tmp['id']      = intval($user_group_arr['id']);
            $tmp['name']    = addslashes($user_group_arr['name']);
            $tmp['purview'] = unserialize($user_group_arr['purview']) ? unserialize($user_group_arr['purview']) : array();
            $user_group[]   = $tmp;
        }
        $str = '';
        foreach ($user_group as $v) {
            $str .= '<input type="checkbox" name="purview[]" ' . ($v['purview'][$_POST['data']]['access'] == '1' ? "checked" : "") . ' value="' . $v['id'] . '">' . $v['name'] . '&nbsp;';
        }
        echo $str;
    }
    public function blockSetPurviewDo()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $config                = require("./Conf/config.php");
        $not_log_in_user_group = $config['not_log_in_user_group'];
        $user_groups           = $_POST['purview'];
        if (empty($user_groups)) {
            $user_groups = array();
        }
        $sid              = intval($_POST['id']);
        $jumpurl          = addslashes(htmlspecialchars($_POST["jumpurl"], ENT_QUOTES, "UTF-8"));
        $user_group_query = $this->db->query("select * from " . $this->C('db_prefix') . "user_group");
        while ($user_group_arr = $user_group_query->fetch()) {
            $purview = array();
            $arr     = $this->find($this->C('db_prefix') . "user_group", "string", "id='" . $user_group_arr['id'] . "'");
            if (in_array($user_group_arr['id'], $user_groups)) {
                $purview = unserialize($arr['purview']) ? unserialize($arr['purview']) : array();
                $tmp     = array();
                if (!in_array($sid, array_keys($purview))) {
                    $tmp['access'] = 1;
                    if ($user_group_arr['id'] != $not_log_in_user_group) {
                        $tmp['publish'] = 1;
                        $tmp['reply']   = 1;
                        $tmp['mark']    = 1;
                    } else {
                        $tmp['publish'] = '';
                        $tmp['reply']   = '';
                        $tmp['mark']    = '';
                    }
                    $purview[$sid] = $tmp;
                }
                $data['purview'] = serialize($purview);
                $this->save($data, $this->C('db_prefix') . "user_group", "id='" . $user_group_arr['id'] . "'");
            } else {
                $purview = unserialize($arr['purview']) ? unserialize($arr['purview']) : array();
                if (in_array($sid, array_keys($purview))) {
                    foreach ($purview as $o => $p) {
                        if ($o == $sid) {
                            unset($purview[$o]);
                        }
                    }
                }
                $data['purview'] = serialize($purview);
                $this->save($data, $this->C('db_prefix') . "user_group", "id='" . $user_group_arr['id'] . "'");
            }
        }
        $_SESSION['youyax_error'] = 1;
        echo '<script>window.location.href="' . $jumpurl . '";</script>';
    }
    public function scblockPurview()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $arr         = $this->find($this->C('db_prefix') . "small_block", "string", "id='" . intval($_POST['data']) . "'");
        $arr['mark'] = preg_replace("/<br\s?\/?>/i", '', $arr['mark']);
        echo json_encode($arr);
    }
    public function backupSQL()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('token', $_SESSION['token'])->assign('shtml', $this->C('static_url'))->assign('site', $this->C('SITE'))->assign('url', $this->C('default_url'))->display("admin/backupSQL.html");
    }
    public function optimizeSQL()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $this->db->exec("optimize table `" . base64_decode($this->getparam("name")) . "`");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "backupSQL" . $this->C('static_url'));
    }
    public function dobackupSQL()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $db_server      = $this->C('db_host');
        $db             = $this->C('db_name');
        $mysql_username = $this->C('db_user');
        $mysql_password = $this->C('db_pwd');
        require("./ext_public/phpmysqlautobackup/run.php");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "backupSQL" . $this->C('static_url'));
    }
    public function downloadBackup()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $file_name = base64_decode($this->getparam("file"));
        $file_name = str_replace(array(
            "./",
            "../"
        ), "", $file_name);
        $file_dir  = "./ext_public/phpmysqlautobackup/backups/";
        if (file_exists($file_dir . $file_name)) {
            header("Content-Type:text/plain");
            header("Accept-Ranges:bytes");
            header("Content-Disposition:attachment;filename=" . $file_name);
            $file = fopen($file_dir . $file_name, "r");
            echo fread($file, filesize($file_dir . $file_name));
            fclose($file);
        }
    }
    public function deleteBackup()
    {
        if ($_SESSION['token'] != $_GET["token"]) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $file_name = base64_decode($this->getparam("file"));
        $file_name = str_replace(array(
            "./",
            "../"
        ), "", $file_name);
        $file_dir  = "./ext_public/phpmysqlautobackup/backups/";
        if (file_exists($file_dir . $file_name))
            @unlink($file_dir . $file_name);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "backupSQL" . $this->C('static_url'));
    }
    public function delimite()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $_SESSION['token'] = md5(microtime(true));
        $config            = require("./Conf/config.php");
        $this->assign('token', $_SESSION['token'])->assign('config', $config)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/delimite.html");
    }
    public function dodelimite()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $config                = require("./Conf/config.php");
        $config['default_url'] = addslashes($_POST['newdefault_url']);
        $config['static_url']  = addslashes($_POST['newstatic_url']);
        $file                  = "<?php return " . var_export($config, true) . "; ?>";
        $file_js               = 'var rooturl="' . $config['SITE'] . '";
var url="' . addslashes($_POST['newdefault_url']) . '";
var shtml="' . addslashes($_POST['newstatic_url']) . '";';
        file_put_contents("./Conf/config.php", $file, LOCK_EX);
        file_put_contents("./Public/JScript/public.js", $file_js, LOCK_EX);
        echo "<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/public.js?" . time() . "'></script>
            			<script type='text/javascript' src='" . $this->C('SITE') . "/Public/JScript/Tip2.js'></script>
            			<script>Tip2('更新成功,3秒后刷新页面',3,1,'parent');
								        for(var i=3;i>=0;i--){
								        (function(){
								          var TipNum=i;
									        t=setTimeout(
									         function(){	         	  
									          	if(TipNum == 0){
									          	 window.clearTimeout(t);
									          	 	top.location.href='" . $this->youyax_url . "/admin" . addslashes($_POST['newdefault_url']) . "login" . addslashes($_POST['newstatic_url']) . "';
									          	}
									          	parent.document.getElementById('TipMsg').innerHTML='更新成功,'+TipNum+'秒后刷新页面';          	
									          },(3-TipNum)*1000);
								          })()
								         }</script>";
    }
    public function searchset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $search            = require("./Conf/search.config.php");
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('token', $_SESSION['token'])->assign('search', $search)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/searchset.html");
    }
    public function dosearchset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $search                   = require("./Conf/search.config.php");
        $search['search_allow']   = ($_POST['search_allow'] == 1) ? true : false;
        $search['search_time']    = htmlspecialchars($_POST['search_time'], ENT_QUOTES, "UTF-8");
        $search['search_results'] = htmlspecialchars($_POST['search_results'], ENT_QUOTES, "UTF-8");
        $file                     = "<?php return " . var_export($search, true) . "; ?>";
        file_put_contents("./Conf/search.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "searchset" . $this->C('static_url'));
    }
    public function waterset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $water             = require("./Conf/water.config.php");
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('token', $_SESSION['token'])->assign('water', $water)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/waterset.html");
    }
    public function dowaterset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $water                     = require("./Conf/water.config.php");
        $water['water_allow']      = ($_POST['water_allow'] == 1) ? true : false;
        $water['water_pic_width']  = htmlspecialchars($_POST['water_pic_width'], ENT_QUOTES, "UTF-8");
        $water['water_pic_height'] = htmlspecialchars($_POST['water_pic_height'], ENT_QUOTES, "UTF-8");
        $water['water_str']        = htmlspecialchars($_POST['water_str'], ENT_QUOTES, "UTF-8");
        $file                      = "<?php return " . var_export($water, true) . "; ?>";
        file_put_contents("./Conf/water.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "waterset" . $this->C('static_url'));
    }
    public function mphotoset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $mphoto            = require("./Conf/mobile.photo.config.php");
        $_SESSION['token'] = md5(microtime(true));
        $this->assign('token', $_SESSION['token'])->assign('mphoto', $mphoto)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display("admin/mphotoset.html");
    }
    public function domphotoset()
    {
        if ($_SESSION['token'] != $_POST['token']) {
            $this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");
            exit;
        } else {
            $_SESSION['token'] = '';
        }
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . $this->C('default_url') . "login" . $this->C('static_url'));
        }
        $mphoto                       = require("./Conf/mobile.photo.config.php");
        $mphoto['mobile_photo_allow'] = ($_POST['mobile_photo_allow'] == 1) ? true : false;
        $mphoto['mobile_pic_width']   = htmlspecialchars($_POST['mobile_pic_width'], ENT_QUOTES, "UTF-8");
        $mphoto['mobile_pic_height']  = htmlspecialchars($_POST['mobile_pic_height'], ENT_QUOTES, "UTF-8");
        $file                         = "<?php return " . var_export($mphoto, true) . "; ?>";
        file_put_contents("./Conf/mobile.photo.config.php", $file, LOCK_EX);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "mphotoset" . $this->C('static_url'));
    }
}
?>