<?php
class BidAction extends YouYaX
{
    static function queryBid($user, $bid)
    {
        $arr = self::getInstance()->find(self::getInstance()->C('db_prefix') . "user", "string", "user='" . $user . "' and status!=2");
        if ($arr['bid'] >= $bid) {
            return true;
        } else {
            return false;
        }
    }
    public function accept()
    {
        $id  = $this->getparam("id");
        $id2 = $this->getparam("id2");
        if (is_numeric($id2) && ($id2>0)) {
            $reply = $this->find($this->C('db_prefix') . "reply", "string", "id2='" . $id2 . "' and rid='" . $id . "'");
            if ($reply) {
                $talk = $this->find($this->C('db_prefix') . "talk", "string", "id='" . $id . "'");
                if ($talk) {
                    if (($talk['zuozhe'] == $_SESSION['youyax_user']) && ($talk['zuozhe'] != $reply['zuozhe1']) && ($talk['is_question'] == 1)) {
                        $this->db->exec("update " . $this->C('db_prefix') . "reply set content1=CONCAT('<div style=\'border: 1px solid #ff999a;background: #fbeded;padding: 10px;\'><h3 style=\'background-image: url(" . $this->C('SITE') . "/Public/images/medals.gif);background-repeat: no-repeat;padding-left: 50px;border: 0;height: 60px;line-height: 60px;\'>采纳的答案</h3>',content1,'</div>') where id2=" . $id2);
                        $this->db->exec("update " . $this->C('db_prefix') . "talk set lock_status=1 where id=$id");
                        $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+" . $talk['question_bid'] . " where user='" . $reply['zuozhe1'] . "'");
                        $this->redirect("Content" . $this->C('default_url') . $id . $this->C('static_url'));
                    } else {
                        $this->error();
                    }
                } else {
                    $this->error();
                }
            } else {
                $this->error();
            }
        } else if ($id2 == '0') {
            $talk = $this->find($this->C('db_prefix') . "talk", "string", "id='" . $id . "'");
            if ($talk) {
                if (($talk['zuozhe'] == $_SESSION['youyax_user']) && ($talk['is_question'] == 1)) {
                    $this->db->exec("update " . $this->C('db_prefix') . "talk set content=CONCAT('<div style=\'border: 1px solid #ff999a;background: #fbeded;padding: 10px;\'><h3 style=\'height: 60px;line-height: 60px;\'>[已关闭问题]</h3>',content,'</div>') where id=" . $id);
                    $this->db->exec("update " . $this->C('db_prefix') . "talk set lock_status=1 where id=$id");
                    $this->db->exec("update " . $this->C('db_prefix') . "user set bid=bid+" . floor($talk['question_bid'] / 2) . " where user='" . $talk['zuozhe'] . "'");
                    $this->redirect("Content" . $this->C('default_url') . $id . $this->C('static_url'));
                } else {
                    $this->error();
                }
            } else {
                $this->error();
            }
        } else {
            $this->error();
        }
    }
    public function error()
    {
        $this->assign("msgtitle", "操作错误!")->assign("message", "您可能处于非法操作中!")->assign("jumpurl", $this->C('SITE'))->error();
    }
}
?>