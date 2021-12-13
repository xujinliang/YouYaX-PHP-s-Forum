<?php
class FavorAction extends YouYaX
{
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        if (!empty($_SESSION['youyax_user'])) {
            $rid = $this->getparam("id");
            if (!is_numeric($rid)) {
                exit;
            }
            if ($favors_arr = $this->find($this->C('db_prefix') . "favor", "string", "user='" . $_SESSION['youyax_user'] . "'")) {
                $favors = unserialize($favors_arr['favor']);
                if (in_array($rid, $favors)) {
                    echo '您已经收藏了这个帖子';
                    exit;
                } else {
                    $favors[]      = $rid;
                    $data['favor'] = serialize($favors);
                    $this->save($data, $this->C('db_prefix') . "favor", "user='" . $_SESSION['youyax_user'] . "'");
                    echo '收藏成功，请至个人中心查看';
                    exit;
                }
            } else {
                $array         = array();
                $array[]       = $rid;
                $data['user']  = $_SESSION['youyax_user'];
                $data['favor'] = serialize($array);
                $this->add($data, $this->C('db_prefix') . "favor");
                echo '收藏成功，请至个人中心查看';
                exit;
            }
        } else {
            echo '未登录用户没有权限';
            exit;
        }
    }
    public function show()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $arr = $this->find($this->C('db_prefix') . "favor", "string", "user='" . $_SESSION['youyax_user'] . "'");
        if ($arr) {
            $con  = '';
            $tids = unserialize($arr['favor']);
            if (!empty($tids)) {
                foreach ($tids as $id) {
                    $con .= "id=" . $id . " or ";
                }
                $con   = substr($con, 0, strrpos($con, "or"));
                $sql="select * from " . $this->C('db_prefix') . "talk where " . $con;
                $count = $this->db->query("select count(*) from " . $this->C('db_prefix') . "talk where " . $con)->fetchColumn();
            } else {
                $count = 0;
            }
            if ($count <= 0) {
                $show    = '';
                $results = '';
            } else {
                $mix = require("./Conf/mix.config.php");
                require("./ORG/Page/" . $mix['fenye_style'] . "/Fenye.class.php");
                $fenye   = new Fenye($count, 10);
                $show    = $fenye->show();
                $show    = implode("<span style='width:2px;display:inline-block;'></span>", $show);
                $sql2    = $fenye->listcon($sql);
                $results = $this->select($sql2);
            }
        } else {
            $results = '';
        }
        $this->assign('results', $results)->assign('page', $show);
        $site_config = require("./Conf/site.config.php");
        $mix         = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $this->assign('site_config', $site_config)->assign('site', $this->C('SITE'))->assign('user', $user)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'))->display('home/favor.html');
    }
    public function cancel()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $id  = $this->getparam("id");
        $arr = $this->find($this->C('db_prefix') . "favor", "string", "user='" . $_SESSION['youyax_user'] . "'");
        if ($arr) {
            $tids = unserialize($arr['favor']);
            foreach ($tids as $k => $v) {
                if ($v == $id) {
                    unset($tids[$k]);
                }
            }
            $data['favor'] = serialize($tids);
            $this->save($data, $this->C('db_prefix') . "favor", "user='" . $_SESSION['youyax_user'] . "'");
            $this->redirect("Favor" . $this->C('default_url') . "show" . $this->C('static_url'));
        }
    }
}
?>