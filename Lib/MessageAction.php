<?php
class MessageAction extends YouYaX
{
    public function send()
    {
        header("Content-Type:text/html; charset=utf-8");
        if (!empty($_SESSION['youyax_user']) && CommonAction::competence($_SESSION['youyax_user'])) {
            $mto  = addslashes(htmlspecialchars($_POST['mto'], ENT_QUOTES, "UTF-8"));
            $mcon = addslashes(htmlspecialchars($_POST['mcon'], ENT_QUOTES, "UTF-8"));
            $mcon = trim(preg_replace('/[　]+/u', '', $mcon));
            if (empty($mcon)) {
                echo '消息不能为空';
                exit;
            }
            if ($_SESSION['youyax_user'] == $mto) {
                echo '您不能给自己发消息';
                exit;
            } else if ($mto == '系统提示:') {
                echo '这是系统自动发送的信息，请不要回复，谢谢';
                exit;
            } else if (empty($mto)) {
                echo '收信人不能为空';
                exit;
            } else if (!$this->find($this->C('db_prefix') . "user", 'string', "user='" . $mto . "'")) {
                echo '用户不存在';
                exit;
            } else {
                $data          = array();
                $data['mfrom'] = $_SESSION['youyax_user'];
                $data['mto']   = $mto;
                $data['mcon']  = filter_var($mcon, FILTER_CALLBACK, array(
                    "options" => "filter_function"
                ));
                $data['time']  = time();
                $this->add($data, $this->C('db_prefix') . "message");
                $result = $this->find($this->C('db_prefix') . "message_status", 'string', "muser='" . $mto . "'");
                if ($result) {
                    $data2            = array();
                    $data2['mstatus'] = 1;
                    $this->save($data2, $this->C('db_prefix') . "message_status", "muser='" . $mto . "'");
                } else {
                    $data2            = array();
                    $data2['muser']   = $mto;
                    $data2['mstatus'] = 1;
                    $this->add($data2, $this->C('db_prefix') . "message_status");
                }
                echo '发送成功';
            }
        } else {
            echo '未登陆用户不能发送消息';
        }
    }
    public function showbar()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null) {
            $this->redirect("Login" . $this->C('default_url') . "loginMobile" . $this->C('static_url'));
        } else {
            $this->show();
        }
    }
    public function show()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $data2            = array();
        $data2['mstatus'] = 0;
        $this->save($data2, $this->C('db_prefix') . "message_status", "muser='" . $_SESSION['youyax_user'] . "'");
        $sql   = "select * from " . $this->C('db_prefix') . "message where mto='" . $_SESSION['youyax_user'] . "' order by id desc";
        $res   = $this->db->query($sql);
        $count = count($res->fetchAll());
        if ($count <= 0) {
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
        $this->assign('data', $result)->assign('page', $show)->assign('site', $this->C('SITE'))->assign('user', $user)->assign('shtml', $this->C('static_url'))->assign('url', $this->C('default_url'));
        $mix = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)->display("home/show.html");
    }
    public function delMess()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        $id     = $this->getparam("mid");
        $result = $this->find($this->C('db_prefix') . "message", 'string', "mto='" . $_SESSION['youyax_user'] . "' and id='" . $id . "'");
        if ($result) {
            $this->delete($this->C('db_prefix') . "message", "mto='" . $_SESSION['youyax_user'] . "' and id='" . $id . "'");
            $this->assign('jumpurl', $this->youyax_url . "/Message" . $this->C('default_url') . "show" . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '消息已删除！')->success();
        } else {
            $this->assign('jumpurl', $this->youyax_url . "/Message" . $this->C('default_url') . "show" . $this->C('static_url'))->assign('msgtitle', '操作失败')->assign('message', '请仔细检查！')->error();
        }
    }
    public function delMesses()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . $this->C('default_url') . "index" . $this->C('static_url'));
        for ($k = 0; $k < count($_POST['cb']); $k++) {
            $id     = intval($_POST['cb'][$k]);
            $result = $this->find($this->C('db_prefix') . "message", 'string', "mto='" . $_SESSION['youyax_user'] . "' and id='" . $id . "'");
            if ($result) {
                $this->delete($this->C('db_prefix') . "message", "mto='" . $_SESSION['youyax_user'] . "' and id='" . $id . "'");
            }
        }
        $this->assign('jumpurl', $this->youyax_url . "/Message" . $this->C('default_url') . "show" . $this->C('static_url'))->assign('msgtitle', '操作成功')->assign('message', '消息已删除！')->success();
    }
}
?>