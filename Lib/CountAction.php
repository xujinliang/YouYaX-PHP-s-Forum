<?php
class CountAction extends YouYaX
{
    static function doPostCount($tag_sk = null)
    {
        if (match($_SESSION['youyax_user'], "session_user")) {
            $count_arr = self::getInstance()->find(self::getInstance()->C('db_prefix') . "count", "string", "id=1");
            $data      = unserialize($count_arr['post_count']) == false ? array() : unserialize($count_arr['post_count']);
            $hot       = unserialize($count_arr['user_hot']) == false ? array() : unserialize($count_arr['user_hot']);
            $tags      = unserialize($count_arr['tags_hot']) == false ? array() : unserialize($count_arr['tags_hot']);
            $date      = date('w', time());
            $date2     = date('W', time());
            if ($date2 != $count_arr['week_order']) {
                $array               = array();
                $array['user_count'] = '';
                $array['post_count'] = '';
                $array['user_hot']   = '';
                $array['tags_hot']   = '';
                $array['week_order'] = $date2;
                self::getInstance()->save($array, self::getInstance()->C('db_prefix') . "count", "id=1");
                $count_arr = self::getInstance()->find(self::getInstance()->C('db_prefix') . "count", "string", "id=1");
                $data      = unserialize($count_arr['post_count']) == false ? array() : unserialize($count_arr['post_count']);
                $hot       = unserialize($count_arr['user_hot']) == false ? array() : unserialize($count_arr['user_hot']);
                $tags      = unserialize($count_arr['tags_hot']) == false ? array() : unserialize($count_arr['tags_hot']);
            }
            switch ($date) {
                case 0:
                    @$data['g']++;
                    break;
                case 1:
                    @$data['a']++;
                    break;
                case 2:
                    @$data['b']++;
                    break;
                case 3:
                    @$data['c']++;
                    break;
                case 4:
                    @$data['d']++;
                    break;
                case 5:
                    @$data['e']++;
                    break;
                case 6:
                    @$data['f']++;
                    break;
            }
            $user_arr = self::getInstance()->find(self::getInstance()->C('db_prefix') . "user", "string", "user='" . $_SESSION['youyax_user'] . "'");
            $hot[$user_arr['id']]++;
            if (!empty($tag_sk)) {
                $tag_sk_lists = explode(",", $tag_sk);
                foreach ($tag_sk_lists as $n) {
                    $tags[$n]++;
                }
            }
            $array               = array();
            $array['post_count'] = serialize($data);
            $array['user_hot']   = serialize($hot);
            $array['tags_hot']   = serialize($tags);
            self::getInstance()->save($array, self::getInstance()->C('db_prefix') . "count", "id=1");
        }
    }
}
?>