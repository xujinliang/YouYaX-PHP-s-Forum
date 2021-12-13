<?php
class LaudAction extends YouYaX
{
    public function dolaud()
    {
        $mix = require("./Conf/mix.config.php");
        if ($mix['is_limit_time']) {
            if (!LimitAction::limitTime($mix['limit_time'])) {
                echo $mix['limit_time'] . "秒内不能操作";
                exit;
            }
        }
        if (!empty($_SESSION['youyax_user'])) {
            $tid = intval($_POST['tid']);
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                $myIp = $_SERVER['HTTP_CLIENT_IP'];
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $myIp = $_SERVER['REMOTE_ADDR'];
            if(!filter_var($myIp, FILTER_VALIDATE_IP)){
		    		echo '此IP地址是无效的';
			    exit;
		    }
            if (empty($_POST['types'])) {
                if ($ips_arr = $this->find($this->C('db_prefix') . "talk", "string", "id=" . $tid . " and is_question=1")) {
                    if ($ips_arr['zuozhe'] != $_SESSION['youyax_user']) {
                        $ips  = unserialize($ips_arr['laud_ips']);
                        $laud = $ips_arr['laud'];
                        if (empty($ips)) {
                            $ips = array();
                        }
                        if (in_array($myIp, $ips)) {
                            echo '您已经操作过了';
                            exit;
                        } else {
                            $ips[]            = $myIp;
                            $data['laud_ips'] = serialize($ips);
                            if (intval($_POST['bz']) == 1) {
                                $data['laud'] = $laud + 1;
                                $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+1 where user='" . $ips_arr['zuozhe'] . "'");
                            } else {
                                $data['laud'] = $laud - 1;
                                $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid-1 where user='" . $ips_arr['zuozhe'] . "'");
                            }
                            $this->save($data, $this->C('db_prefix') . "talk", "id=" . $tid);
                            echo 'success';
                            exit;
                        }
                    } else {
                        echo "不能给自己操作";
                        exit;
                    }
                } else {
                    echo "非法操作";
                    exit;
                }
            } else {
                if ($ips_arr = $this->find($this->C('db_prefix') . "reply", "string", "id2=" . intval($_POST['val2']) . " and rid=" . $tid)) {
                    if ($ips_arr['zuozhe1'] != $_SESSION['youyax_user']) {
                        $ips  = unserialize($ips_arr['laud2_ips']);
                        $laud = $ips_arr['laud2'];
                        if (empty($ips)) {
                            $ips = array();
                        }
                        if (in_array($myIp, $ips)) {
                            echo '您已经操作过了';
                            exit;
                        } else {
                            $ips[]             = $myIp;
                            $data['laud2_ips'] = serialize($ips);
                            if (intval($_POST['bz']) == 1) {
                                $data['laud2'] = $laud + 1;
                                $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+1 where user='" . $ips_arr['zuozhe1'] . "'");
                            } else {
                                $data['laud2'] = $laud - 1;
                                $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid-1 where user='" . $ips_arr['zuozhe1'] . "'");
                            }
                            $this->save($data, $this->C('db_prefix') . "reply", "id2=" . intval($_POST['val2']));
                            echo 'success';
                            exit;
                        }
                    } else {
                        echo "不能给自己操作";
                        exit;
                    }
                } else {
                    echo "非法操作";
                    exit;
                }
            }
        } else {
            echo "未登录用户无法操作";
            exit;
        }
    }
}
?>