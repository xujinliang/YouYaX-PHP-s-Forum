<?php
class LoginAction extends YouYaX
{
    public function loginMobile()
    {
        $site_config = require("./Conf/site.config.php");
        $qq          = require('./Conf/qq.config.php');
        $weibo       = require('./Conf/weibo.config.php');
        $this->assign('site_config', $site_config)->assign('url', $this->C('default_url'))->assign('shtml', $this->C('static_url'))->assign('qq', $qq)->assign('weibo', $weibo)->display("reglog/login.html");
    }
    public function dologinMobile()
    {
        if ($this->limitTime()) {
            $sql = "select * from " . $this->config['db_prefix'] . "user where binary user='" . addslashes($_POST['user']) . "'  and status=1 and complete=0";
            $res = $this->db->query($sql);
            if ($res) {
                $arr      = $res->fetch();
                $cookieid = md5(microtime(true));
                $key      = require("./Conf/key.config.php");
                if ($arr && $this->cc_decrypt($arr['pass'], $key) == $_POST['pass']) {
                    $user                    = $_POST['user'];
                    $_SESSION['youyax_user'] = $user;
                    $this->db->exec("update " . $this->config['db_prefix'] . "user set cookieid='" . $cookieid . "' where user='" . addslashes($_POST['user']) . "'");
                    @setcookie('youyax_user', $user, time() + (60 * 60 * 24 * 30), "/");
                    @setcookie('youyax_cookieid', $cookieid, time() + (60 * 60 * 24 * 30), "/");
                    $this->clearError();
                    echo '<script>alert("登陆成功!");window.location.href="' . $this->C('SITE') . '";</script>';
                    exit;
                } else {
                    $this->addError();
                    echo '<script>alert("输入错误 or 尚未激活");</script>';
                    $this->redirect("Login" . $this->C('default_url') . "loginMobile" . $this->C('static_url'));
                }
            } else {
                $this->addError();
                echo '<script>alert("输入错误 or 尚未激活");</script>';
                $this->redirect("Login" . $this->C('default_url') . "loginMobile" . $this->C('static_url'));
            }
        } else {
            echo '<script>alert("登录出错累计3次 , 请10分钟后再试!");</script>';
            $this->redirect("Login" . $this->C('default_url') . "loginMobile" . $this->C('static_url'));
        }
    }
    public function dologin()
    {
        if ($this->limitTime()) {
            $sql = "select * from " . $this->config['db_prefix'] . "user where binary user='" . addslashes($_POST['user']) . "'  and status=1 and complete=0";
            $res = $this->db->query($sql);
            if ($res) {
                $arr      = $res->fetch();
                $cookieid = md5(microtime(true));
                $key      = require("./Conf/key.config.php");
                if ($arr && $this->cc_decrypt($arr['pass'], $key) == $_POST['pass']) {
                    $user                    = $_POST['user'];
                    $_SESSION['youyax_user'] = $user;
                    $this->db->exec("update " . $this->config['db_prefix'] . "user set cookieid='" . $cookieid . "' where user='" . addslashes($_POST['user']) . "'");
                    @setcookie('youyax_user', $user, time() + (60 * 60 * 24 * 30), "/");
                    @setcookie('youyax_cookieid', $cookieid, time() + (60 * 60 * 24 * 30), "/");
                    $this->clearError();
                    echo '1';
                    exit;
                } else {
                    $this->addError();
                    echo '2';
                    exit;
                }
            } else {
                $this->addError();
                echo '2';
                exit;
            }
        } else {
            echo '3';
            exit;
        }
    }
    public function limitTime()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        if (!filter_var($myIp, FILTER_VALIDATE_IP)) {
            echo '4';
            exit;
        }
        $arr = $this->find($this->C('db_prefix') . "login_limit", "string", "ip='" . $myIp . "'");
        if (($arr['errornum'] < 3) || (time() - $arr['time'] >= 600)) {
            if ((time() - $arr['time'] >= 600) && $arr['errornum'] == 3) {
                $this->clearError();
            }
            return true;
        } else {
            return false;
        }
    }
    public function clearError()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        if (!filter_var($myIp, FILTER_VALIDATE_IP)) {
            echo '4';
            exit;
        }
        $arr = $this->find($this->C('db_prefix') . "login_limit", "string", "ip='" . $myIp . "'");
        if ($arr) {
            $data['time']     = time();
            $data['errornum'] = 0;
            $this->save($data, $this->C('db_prefix') . "login_limit", "ip='" . $myIp . "'");
        }
    }
    public function addError()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        if (!filter_var($myIp, FILTER_VALIDATE_IP)) {
            echo '4';
            exit;
        }
        $arr = $this->find($this->C('db_prefix') . "login_limit", "string", "ip='" . $myIp . "'");
        if ($arr) {
            $data['time']     = time();
            $data['errornum'] = $arr['errornum'] + 1;
            $this->save($data, $this->C('db_prefix') . "login_limit", "ip='" . $myIp . "'");
        } else {
            $data['ip']       = $myIp;
            $data['errornum'] = 1;
            $data['time']     = time();
            $this->add($data, $this->C('db_prefix') . "login_limit");
        }
    }
}
?>