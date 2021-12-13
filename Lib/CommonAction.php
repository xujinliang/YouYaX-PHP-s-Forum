<?php
class CommonAction extends YouYaX
{
    static function tongji()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        if (!filter_var($myIp, FILTER_VALIDATE_IP)) {
            self::getInstance()->delete(self::getInstance()->C('db_prefix') . "online", "lasttime<" . $lastTime);
            $num = self::getInstance()->db->query("select count(*) from " . self::getInstance()->C('db_prefix') . "online")->fetchColumn();
            return $num;
            exit;
        }
        $myTime   = time();
        $lastTime = $myTime - 600;
        $data     = array();
        $num      = self::getInstance()->db->query("select count(*) from " . self::getInstance()->C('db_prefix') . "online where ip='" . $myIp . "'")->fetchColumn();
        if ($num < 1) //无此IP，就增加一条在线记录
            {
            $c   = curl_init();
            $url = "http://whois.pconline.com.cn/ip.jsp?ip=" . $myIp;
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            $iper = curl_exec($c);
            curl_close($c);
            $ips              = iconv("gb2312","utf-8//IGNORE",$iper);
            $str1             = $myIp;
            $str2             = $ips;
            $str3             = '';
            $str4             = '';
            $str5             = '';
            $zone             = $str1 . " ," . $str2;
            $data['ip']       = $myIp;
            $data['lasttime'] = $myTime;
            $data['user']     = $_SESSION['youyax_user'];
            $data['zone']     = $zone;
            self::getInstance()->add($data, self::getInstance()->C('db_prefix') . "online");
        } else //有此用户，就更改此用户的最后活动时间
            {
            $data['lasttime'] = $myTime;
            $data['user']     = $_SESSION['youyax_user'];
            self::getInstance()->save($data, self::getInstance()->C('db_prefix') . "online", "ip='" . $myIp . "'");
            $res              = self::getInstance()->db->query("select * from " . self::getInstance()->C('db_prefix') . "online where user='" . $_SESSION['youyax_user'] . "'");
            $arr              = $res->fetch();
            $data             = array();
            $data['lasttime'] = time();
            $data['lastzone'] = $arr['zone'];
            self::getInstance()->save($data, self::getInstance()->C('db_prefix') . "user", "user='" . $_SESSION['youyax_user'] . "'");
        }
        self::getInstance()->delete(self::getInstance()->C('db_prefix') . "online", "lasttime<" . $lastTime);
        $num = self::getInstance()->db->query("select count(*) from " . self::getInstance()->C('db_prefix') . "online")->fetchColumn();
        return $num;
    }
    static function callSend($pos, $check, $tid, $url)
    {
        if ($_SESSION['youyax_user'] != $check && !empty($check)) {
            $pos           = empty($pos) ? '楼主位' : $pos . '楼';
            $data          = array();
            $data['mfrom'] = '系统提示:';
            $data['mto']   = $check;
            $data['mcon']  = $pos . " 有新信息动态，<a href=\'" . $url . "/Content" . self::getInstance()->C('default_url') . "index" . self::getInstance()->C('default_url') . "id" . self::getInstance()->C('default_url') . $tid . self::getInstance()->C('static_url') . "\'>查看</a>";
            $data['time']  = time();
            self::getInstance()->add($data, self::getInstance()->C('db_prefix') . "message");
            $result_mess = self::getInstance()->find(self::getInstance()->C('db_prefix') . "message_status", 'string', "muser='" . $check . "'");
            if ($result_mess) {
                $data2            = array();
                $data2['mstatus'] = 1;
                self::getInstance()->save($data2, self::getInstance()->C('db_prefix') . "message_status", "muser='" . $check . "'");
            } else {
                $data2            = array();
                $data2['muser']   = $check;
                $data2['mstatus'] = 1;
                self::getInstance()->add($data2, self::getInstance()->C('db_prefix') . "message_status");
            }
        }
    }
    static function adminSend($mto, $mcon)
    {
        $data          = array();
        $data['mfrom'] = '系统提示:';
        $data['mto']   = $mto;
        $data['mcon']  = $mcon;
        $data['time']  = time();
        self::getInstance()->add($data, self::getInstance()->C('db_prefix') . "message");
        $result = self::getInstance()->find(self::getInstance()->C('db_prefix') . "message_status", 'string', "muser='" . $mto . "'");
        if ($result) {
            $data2            = array();
            $data2['mstatus'] = 1;
            self::getInstance()->save($data2, self::getInstance()->C('db_prefix') . "message_status", "muser='" . $mto . "'");
        } else {
            $data2            = array();
            $data2['muser']   = $mto;
            $data2['mstatus'] = 1;
            self::getInstance()->add($data2, self::getInstance()->C('db_prefix') . "message_status");
        }
    }
    static function competence($user)
    {
        if (self::getInstance()->find(self::getInstance()->C('db_prefix') . "user", "string", "user='" . $user . "' and status!=2")) {
            return true;
        } else {
            return false;
        }
    }
    static function lock($id)
    {
        $arr = self::getInstance()->find(self::getInstance()->C('db_prefix') . "talk", "string", "id=" . $id);
        if ($arr['lock_status'] == 0) {
            return true;
        } else {
            return false;
        }
    }
    static function userGroupVisit($param, $youyax_f = '')
    {
        if (empty($youyax_f)) {
            if (empty($_SESSION['youyax_f'])) {
                return false;
            }
            $youyax_f = $_SESSION['youyax_f'] > 10000 ? $_SESSION['youyax_f'] - 10000 : $_SESSION['youyax_f'];
        } else {
            $youyax_f = $youyax_f > 10000 ? $youyax_f - 10000 : $youyax_f;
        }
        if (!empty($_SESSION['youyax_user'])) {
            $user_arr           = self::getInstance()->find(self::getInstance()->C('db_prefix') . "user", "string", "user='" . $_SESSION['youyax_user'] . "'");
            $user_group         = $user_arr['user_group'];
            $user_group_arr     = self::getInstance()->find(self::getInstance()->C('db_prefix') . "user_group", "string", "id='" . $user_group . "'");
            $user_group_purview = unserialize($user_group_arr['purview']);
            if (empty($user_group_purview)) {
                $user_group_purview = array();
            }
            if ($user_group_purview[$youyax_f][$param] != '1') {
                return false;
            } else {
                return true;
            }
        } else {
            $not_log_in_user_group = self::getInstance()->C('not_log_in_user_group');
            if (empty($not_log_in_user_group)) {
                return false;
                exit;
            }
            $user_group_arr     = self::getInstance()->find(self::getInstance()->C('db_prefix') . "user_group", "string", "id='" . self::getInstance()->C('not_log_in_user_group') . "'");
            $user_group_purview = unserialize($user_group_arr['purview']);
            if (empty($user_group_purview)) {
                $user_group_purview = array();
            }
            if ($user_group_purview[$youyax_f][$param] != '1') {
                return false;
            } else {
                return true;
            }
        }
    }
    static function continuePost($t3, $t4)
    {
        for ($i = 1; $i < 4; $i++) {
            $res = self::getInstance()->db->query("select zuozhe1 from " . self::getInstance()->C('db_prefix') . "reply where rid=" . $t3 . " and num2=" . intval($t4 - $i));
            $num = self::getInstance()->db->query("select count(zuozhe1) from " . self::getInstance()->C('db_prefix') . "reply where rid=" . $t3 . " and num2=" . intval($t4 - $i))->fetchColumn();
            if ($num <= 0) {
                return false;
                break;
            } else {
                $arr = $res->fetch();
                if ($arr['zuozhe1'] != $_SESSION['youyax_user']) {
                    return false;
                    break;
                }
            }
        }
        return true;
    }
    static function fname($param)
    {
        $sql = "select szone from " . self::getInstance()->C('db_prefix') . "small_block where id='" . $param . "' or id='" . ($param - 10000) . "'";
        $res = self::getInstance()->db->query($sql);
        $arr = $res->fetch();
        return $arr['szone'];
    }
    static function getTitle($id)
    {
        $sql = "select title from " . self::getInstance()->C('db_prefix') . "talk where id='" . $id . "'";
        $res = self::getInstance()->db->query($sql);
        $arr = $res->fetch();
        return strip_tags($arr['title']);
    }
    static function getUserGroup($id)
    {
        if (!empty($id)) {
            $sql = "select name from " . self::getInstance()->C('db_prefix') . "user_group where id='" . $id . "'";
            $res = self::getInstance()->db->query($sql);
            $arr = $res->fetch();
            return $arr['name'];
        } else {
            return 'NULL';
        }
    }
    static function getUserGroupByName($param)
    {
        $sql = "select user_group from " . self::getInstance()->C('db_prefix') . "user where user='" . $param . "'";
        $res = self::getInstance()->db->query($sql);
        $num = self::getInstance()->db->query("select count(user_group) from " . self::getInstance()->C('db_prefix') . "user where user='" . $param . "'")->fetchColumn();
        if ($num > 0) {
            $arr = $res->fetch();
            return self::getUserGroup($arr['user_group']);
        } else {
            return false;
        }
    }
    static function getUserInfo($param, $field)
    {
        $sql = "select " . $field . " from " . self::getInstance()->C('db_prefix') . "user where user='" . $param . "'";
        $res = self::getInstance()->db->query($sql);
        $arr = $res->fetch();
        if ($field == 'title') {
            if (!empty($arr['title'])) {
                return '<img style="position: relative;left: 10px;top: 8px;" src="' . self::getInstance()->C('SITE') . '/Public/images/' . $arr['title'] . '">';
            }
        }
        if ($field == 'bid') {
            return $arr['bid'];
        }
        if ($field == 'id') {
            return $arr['id'];
        }
    }
    static function getUser($param)
    {
        $sql = "select user from " . self::getInstance()->C('db_prefix') . "user where id='" . $param . "'";
        $res = self::getInstance()->db->query($sql);
        $arr = $res->fetch();
        return $arr['user'];
    }
}
?>