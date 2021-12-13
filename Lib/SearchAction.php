<?php
class SearchAction extends YouYaX
{
		public function searchusers()
		{
			header("Content-Type:text/html; charset=utf-8");
			$arr = array();
			$user_arr = $this->select("select user from ". $this->C('db_prefix') . "user where user like '%".$_GET['q']."%' and user!='".$_SESSION['youyax_user']."'");
			foreach($user_arr as $u){
				$arr[]['user'] = $u['user'];
			}
			echo json_encode($arr);
		}
		
    public function query()
    {
        if (empty($_SESSION['youyax_user']) && isset($_COOKIE['youyax_user']) && preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $_COOKIE['youyax_user']) && preg_match("/^[A-Za-z0-9]+$/u", $_COOKIE['youyax_cookieid'])) {
            if ($this->find($this->C('db_prefix') . "user", 'string', "user='" . addslashes($_COOKIE['youyax_user']) . "' and cookieid='" . addslashes($_COOKIE['youyax_cookieid']) . "'")) {
                $_SESSION['youyax_user'] = $_COOKIE['youyax_user'];
            }
        }
        $q            = addslashes(htmlspecialchars($_GET['q']));
        $action       = addslashes(htmlspecialchars($_GET['action']));
        $search_limit = require("./Conf/search.config.php");
        if ($search_limit['search_allow']) {
            if ($search_limit['search_time']) {
                if (!LimitAction::limitTime($search_limit['search_time'])) {
                    if (@$_COOKIE['search_q'] != $q && !empty($_COOKIE['search_q'])) {
                        $this->assign('code', "操作限制")->assign('msg', $search_limit['search_time'] . "秒内不能操作");
                        $this->display("Public/exception.html");
                        echo "<script>setTimeout(function(){location.href = '" . $this->C('SITE') . "';},2000);</script>";
                        exit;
                    }
                }
                ob_clean();
                @setcookie("search_q", $q, time() + $search_limit['search_time'], "/");
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
            $start_time = microtime();
            if ($action == 'tags') {
                $q_con        = '';
                $tag_sk_lists = explode(",", urldecode($q));
                foreach ($tag_sk_lists as $n) {
                    $q_con .= "tags like '%" . trim($n) . "%' or ";
                }
                $q_con = substr($q_con, 0, strrpos($q_con, "or"));
            } else {
                $q_arr = preg_split("/\s+/", $q, -1, PREG_SPLIT_NO_EMPTY);
                $q_con = '';
                foreach ($q_arr as $qv) {
                    $q_con .= "title like '%" . trim($qv) . "%' or ";
                }
                $q_con = substr($q_con, 0, strrpos($q_con, "or"));
            }
            if ($search_limit['search_results']) {
                $res = $this->db->query("select id,zuozhe,title,content,time1 from " . $this->C('db_prefix') . "talk where " . $q_con . " order by time1 desc limit 0," . $search_limit['search_results']);
            } else {
                $res = $this->db->query("select id,zuozhe,title,content,time1 from " . $this->C('db_prefix') . "talk where " . $q_con . " order by time1 desc");
            }
            $search_count = count($res->fetchAll());
            if ($search_count > 0) {
                require("./ORG/Page/Fenye_search.class.php");
                $fenye          = new Fenye($search_count, 10);
                $show           = $fenye->show();
                $show           = implode("<span style='width:2px;display:inline-block;'></span>", $show);
                $search_sql     = $fenye->listcon("select id,zuozhe,title,content,parentid,time1 from " . $this->C('db_prefix') . "talk where " . $q_con . " order by time1 desc");
                $search_results = array();
                $search_query   = $this->db->query($search_sql);
                $search_num     = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where " . $q_con . " order by time1 desc")->fetchColumn();
                if ($search_num) {
                    while ($tmp = $search_query->fetch(PDO::FETCH_ASSOC)) {
                        if ($action != 'tags') {
                            $tmp['title']   = preg_replace("/($q)/i", "<span class='highlight'>\\1</span>", stripslashes($tmp['title']));
                            $tmp['content'] = preg_replace("/($q)/i", "<span class='highlight'>\\1</span>", strip_tags($tmp['content']));
                        }
                        if (!CommonAction::userGroupVisit('access', $tmp['parentid'])) {
                            $tmp['content'] = '系统提示: 无权限获取内容';
                        }
                        $search_results[] = $tmp;
                    }
                }
                $this->assign('page', $show)->assign('search_results', $search_results);
            }
            $this->assign('search_count', $search_count);
            $end_time  = microtime();
            $starttime = explode(" ", $start_time);
            $endtime   = explode(" ", $end_time);
            $totaltime = $endtime[0] - $starttime[0] + $endtime[1] - $starttime[1];
            $timecost  = number_format($totaltime, 3);
            $this->assign('timecost', $timecost);
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
            $ads         = require("Conf/ads.config.php");
            $this->assign('site_config', $site_config)->assign('ads', $ads)->assign('site', $this->C('SITE'))->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
            $this->display("home/search.html");
        } else {
            $this->assign("msgtitle", "操作错误!")->assign("message", "未登录用户禁止搜索!")->assign("jumpurl", $this->C('SITE'))->error();
        }
    }
}
?>