<?php
/**
 * File Name       :YouYa.php
 * Author          :xujinliang
 * Website         :http://www.youyax.com
 * Description     :The core of the YouYaX for PHP framework class files 
 * 
 数据库连接，选择数据库，类，类方法,loop,list,一维数组解析错，二维数组错，一维数组空，二维数组空,model
 
 */
class YouYaX
{
    public $array; //普通替换
    public $array_array; //一维数组
    public $array_two; //二维数组
    public $config;
    public $lang;
    public $array_url; //url地址栏参数
    public $youyax_url;
    public $db;
    public static $_instance;
    function __construct($str_url = array())
    {
        $this->array       = array();
        $this->array_array = array(
            array()
        );
        $this->array_two   = array();
        $this->array_url   = array();
        $this->config      = require("Conf/config.php");
        if ((!empty($this->config['db_host'])) && (!empty($this->config['db_user'])) && (!empty($this->config['db_name']))) {
            $db_host = $this->config['db_host'];
            $db_user = $this->config['db_user'];
            $db_pwd  = $this->config['db_pwd'];
            $db_name = $this->config['db_name'];
            try {
                $this->db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pwd, array(
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
                ));
            }
            catch (PDOException $e) {
                $this->exception($e);
            }
            $this->db->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
            $this->db->exec("SET sql_mode=''");
            date_default_timezone_set('PRC');
        }
        if ($this->config['seo_set'] == 'on') {
            $script_name = substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], "/index.php"));
            if ($this->is_SSL()) {
                $this->youyax_url = "https://" . $_SERVER['HTTP_HOST'] . $script_name;
            } else {
                $this->youyax_url = "http://" . $_SERVER['HTTP_HOST'] . $script_name;
            }
        } else {
            if ($this->is_SSL()) {
                $this->youyax_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
            } else {
                $this->youyax_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
            }
        }
        if (!empty($str_url)) {
            $youyax_array_param = array_slice($str_url, 2);
            array_walk($youyax_array_param, function(&$v)
            {
                if (!json_encode($v)) {
                    $v = mb_convert_encoding(urldecode($v), "utf-8", "gbk");
                }
            });
            if (sizeof($youyax_array_param) % 2 == 1) {
                $this->exception(null);
            }
            for ($i = 0; $i < sizeof($youyax_array_param); $i = $i + 2) {
                $this->array_url[$youyax_array_param[$i]] = addslashes(htmlentities(preg_replace("/\s/", '', $youyax_array_param[$i + 1]), ENT_QUOTES, 'utf-8'));
            }
        }
    }
    public function is_SSL()
    {
        if ($_SERVER['HTTPS'] === 1) {
            return true;
        } else if ($_SERVER['HTTPS'] === 'on') {
            return true;
        } elseif ($_SERVER['HTTP_FROM_HTTPS'] == 'on') {
            return true;
        } elseif ($_SERVER['SERVER_PORT'] == 443) {
            return true;
        }
        return false;
    }
    public function exception($e)
    {
        if (empty($e)) {
            echo file_get_contents("Tpl/Public/exception_url.html");
            exit;
        } else {
            $info = new YouYaX();
            $info->assign('code', "系统异常编号: " . $e->getCode())->assign('msg', $e->getMessage());
            $info->display("Public/exception.html");
            exit;
        }
    }
    public function assign($obj, $quo)
    {
        if (is_array($quo)) {
            if (@is_array($quo[0])) {
                $this->array_two[$obj] = $quo;
            } else {
                $this->array_array[$obj] = $quo;
            }
        } else {
            $key               = $obj;
            $obj               = $quo;
            $this->array[$key] = $obj;
        }
        return $this;
    }
    private function deal($tp)
    {
        if (isset($_COOKIE['youyax_lang']) && in_array($_COOKIE['youyax_lang'], array(
            'en',
            'cn'
        ))) {
            $this->lang                = require("lang/" . $_COOKIE['youyax_lang'] . "/lang.php");
            $this->array_array['lang'] = $this->lang;
        } else {
            if (!empty($this->config['default_language'])) {
                $this->lang                = require("lang/" . $this->config['default_language'] . "/lang.php");
                $this->array_array['lang'] = $this->lang;
            } else {
                $this->lang                = require("lang/cn/lang.php");
                $this->array_array['lang'] = $this->lang;
            }
        }
        if ($this->getparam("l") != "" && $this->getparam("l") != null && in_array($this->getparam("l"), array(
            'en',
            'cn'
        ))) {
            $this->lang                = require("lang/" . $this->getparam("l") . "/lang.php");
            $this->array_array['lang'] = $this->lang;
            setcookie("youyax_lang", $this->getparam("l"), time() + 3600 * 24 * 7, "/");
        }
        $txt        = file_get_contents($tp);
        //include替换
        $include_bz = true;
        while ($include_bz) {
            if (preg_match_all("/<\s*include\s+file=\"([^>]*?)\"\s*\/??>/", $txt, $inc)) {
                foreach ($inc[1] as $v) {
                    if (file_exists($v)) {
                        $sub = file_get_contents($v);
                        foreach ($inc[0] as $v1) {
                            //区分大小写匹配
                            if (preg_match_all("#" . $v . "#", $v1, $tmp)) {
                                $txt = str_replace($v1, $sub, $txt);
                            }
                        }
                    } else {
                        $this->assign("code", "操作错误!")->assign("msg", "include标签解析出错!")->display("Public/exception.html");
                        exit;
                    }
                }
            } else {
                $include_bz = false;
            }
        }
        //--include替换
        //原样替换
        if (preg_match_all("/<\s*original\s*>\s*(.+?)\s*<\s*\/original\s*>/s", $txt, $match)) {
            $ori = 0;
            foreach ($match[0] as $o0) {
                $match[1][$ori] = htmlspecialchars($match[1][$ori]);
                $match[1][$ori] = str_replace("|", "&#124;", $match[1][$ori]);
                $match[1][$ori] = str_replace("{", "&#123;", $match[1][$ori]);
                $match[1][$ori] = str_replace("}", "&#125;", $match[1][$ori]);
                $txt            = str_replace($match[0][$ori], $match[1][$ori], $txt);
                $ori++;
            }
        }
        //----原样替换
        //注释替换
        if (preg_match_all("/<\s*comments\s*>\s*(.+?)\s*<\s*\/comments\s*>/s", $txt, $match)) {
            foreach ($match[0] as $v) {
                $txt = str_replace($v, '', $txt);
            }
        }
        //----注释替换
        //PHP代码块执行
        /*if(preg_match_all("/<\s*php\s*>\s*(.+?)\s*<\s*\/php\s*>/s", $txt, $p)){
        $pnum = -1;
        foreach ($p[1] as $v) {
        ob_start();
        $pnum++;
        eval($v);
        $out = ob_get_clean();
        $txt = str_replace($p[0][$pnum], $out, $txt);
        }
        }*/
        //---PHP代码块执行
        //普通替换
        if (preg_match_all('/\{([^{]*?)}/', $txt, $match)) {
            foreach ($match[0] as $v) {
                $tmp = substr($v, 1, strlen($v) - 2);
                if (array_key_exists($tmp, $this->array)) {
                    $txt = str_replace("{" . $tmp . "}", $this->array[$tmp], $txt);
                }
            }
        }
        //——普通替换
        //单个输出数组值
        if (preg_match_all('/\{[^{\s]*->[^{}\s]*}/', $txt, $single)) {
            foreach ($single[0] as $v) {
                $tmp = preg_split('/->/', substr($v, 1, strlen($v) - 2), -1, PREG_SPLIT_NO_EMPTY);
                $txt = str_replace($v, $this->array_array[$tmp[0]][$tmp[1]], $txt);
            }
        }
        //数组替换
        if (preg_match_all("/<\s*loop\s*>\s*(.+?)\s*<\s*\/loop\s*>/s", $txt, $match)) {
            try {
                foreach ($match[1] as $n => $r_no_loop) {
                    if (preg_match_all("/<\s*loop\s*>/", $r_no_loop, $tmp)) {
                        throw new Exception(htmlspecialchars("<loop>标签不能嵌套<loop>！"), "304");
                        break;
                    }
                    preg_match_all("/\{([^{\s]*?)}/s", $r_no_loop, $match2);
                    $real_array = $this->array_array[$match2[1][0]];
                    try {
                        if (!is_array($real_array))
                            throw new Exception(htmlspecialchars("<loop>标签解析出错，仅支持一维数组！"), "306");
                    }
                    catch (Exception $e) {
                        $this->exception($e);
                    }
                    $real_data = '';
                    foreach ($real_array as $v) {
                        $real_data .= str_replace("{" . $match2[1][0] . "}", $v, $r_no_loop);
                    }
                    $r_with_loop = $match[0][$n];
                    if (preg_match_all("#" . $match2[0][0] . "#", $r_with_loop, $tmp))
                        $txt = str_replace($r_with_loop, $real_data, $txt);
                }
            }
            catch (Exception $e) {
                $this->exception($e);
            }
        }
        //--数组替换
        $txt = str_replace("__APP__", $this->youyax_url, $txt);
        //二维数组
        if (preg_match_all("/<\s*list\s*>\s*(.+?)\s*<\s*\/list\s*>/s", $txt, $match)) {
            try {
                foreach ($match[1] as $r_no_list) {
                    if (preg_match_all("/<\s*list\s*>/", $r_no_list, $tmp)) {
                        throw new Exception(htmlspecialchars("<list>标签不能嵌套<list>！"), "305");
                        break;
                    }
                }
            }
            catch (Exception $e) {
                $this->exception($e);
            }
            foreach ($match[1] as $n => $r_no_list) {
                $real_data = '';
                //获取模板标记名称	start
                preg_match_all("/\{([^{\s]*?)}/s", $r_no_list, $r_no_list_tmp);
                try {
                    foreach ($r_no_list_tmp[1] as $tmp) {
                        if (!preg_match_all("/\./", $tmp, $tmpp))
                            throw new Exception(htmlspecialchars("<list>标签解析出错，仅支持二维数组！"), "307");
                    }
                }
                catch (Exception $e) {
                    $this->exception($e);
                }
                $str = preg_split('/\./', $r_no_list_tmp[1][0], -1, PREG_SPLIT_NO_EMPTY);
                //获取模板标记名称 end
                if (!empty($this->array_two[$str[0]])) {
                    foreach ($this->array_two[$str[0]] as $real_array) {
                        $final = $r_no_list;
                        foreach ($r_no_list_tmp[1] as $v) {
                            $str1 = preg_split('/\./', $v, -1, PREG_SPLIT_NO_EMPTY);
                            if (preg_match_all("/\|/", $str1[1], $tmp)) {
                                $str1_tmp = explode("|", $str1[1]);
                                $final    = str_replace("{" . $str1[0] . "." . $str1[1] . "}", $str1_tmp[1]($real_array[$str1_tmp[0]]), $final);
                            } else {
                                $final = str_replace("{" . $str1[0] . "." . $str1[1] . "}", $real_array[$str1[1]], $final);
                            }
                        }
                        $real_data .= $final;
                    }
                }
                $txt = str_replace($match[0][$n], $real_data, $txt);
            }
        }
        //--二维数组结束
        //链接替换可以选择性开启，和或符号"|"有干扰
        /*
        $txt=preg_replace("/\<\s*link\s*>/","<a href=",$txt);
        $txt=preg_replace("/\<\s*link\s+target=\'?_blank\'?>/","<a target='_blank' href=",$txt);
        $txt=preg_replace("/(?<!\|)\|(?!\|)/", '>', $txt);
        $txt=preg_replace("/<\s*\/link\s*>/","</a>",$txt);	
        */
        eval("?>" . $txt);
    }
    public function display($tp)
    {
        $tpw = "Tpl/" . $tp;
        $tpm = "Tpl/mobile/" . $tp;
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') || stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
            if (file_exists($tpm)) {
                $this->deal($tpm);
            } else {
                if ($tp == 'list/index-normal.html') {
                    $this->deal("Tpl/mobile/list/index.html");
                } else {
                    $this->assign("Tip", "调用的模板不存在!")->display("Public/no_template.html");
                    exit;
                }
            }
        } else {
            $this->deal($tpw);
        }
    }
    public function redirect($control)
    {
        if ($this->config['seo_set'] == 'on') {
            $script_name = substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], "/index.php"));
        } else {
            $script_name = $_SERVER['SCRIPT_NAME'];
        }
        if ($this->is_SSL()) {
            $url = "https://" . $_SERVER['HTTP_HOST'] . $script_name . "/" . $control;
        } else {
            $url = "http://" . $_SERVER['HTTP_HOST'] . $script_name . "/" . $control;
        }
        echo "<script>window.location.href='" . $url . "';</script>";
        exit;
    }
    /*-----------------------------------------数据库常规查询封装-------------------------------*/
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    public function select($sql, $parameter = "")
    {
        $array_param = array();
        if (empty($parameter)) {
            $tmp = $this->db->query($sql);
            if ($tmp) {
                foreach ($this->db->query($sql) as $v) {
                    array_push($array_param, $v);
                }
            }
            return $array_param;
        } else {
            foreach ($this->db->query($sql) as $v) {
                array_push($array_param, $v[$parameter]);
            }
            return $array_param;
        }
    }
    public function add($data = array(), $table)
    {
        $sql = "insert into " . $table . "(" . implode(",", array_keys($data)) . ") values('" . implode("','", array_values($data)) . "')";
        $this->db->exec($sql);
    }
    public function find($table, $ext = "string", $param)
    {
        //在 param 中寻找与给定的正则表达式 pattern 所匹配的子串
        if (!preg_match_all("/=/", $param, $tmp)) {
            $param = "id=" . intval($param);
        }
        $sql    = "select * from " . $table . " where " . $param;
        $result = $this->db->query($sql);
        $num    = $this->db->query("select count(*) from " . $table . " where " . $param)->fetchColumn();
        if ($num <= 0) {
            return false;
        } else {
            switch ($ext) {
                case "number":
                    $arr = $result->fetch(PDO::FETCH_NUM);
                    break;
                case "string":
                    $arr = $result->fetch(PDO::FETCH_ASSOC);
                    break;
            }
            return $arr;
        }
    }
    public function save($data, $table, $param)
    {
        if (!preg_match_all("/[=><!]/", $param, $tmp))
            $param = "id=" . intval($param);
        foreach ($data as $k => $v) {
            $sql = "update " . $table . " set " . $k . "='" . $v . "' where " . $param;
            $this->db->exec($sql);
        }
    }
    public function delete($table, $param)
    {
        if (!preg_match_all("/[=><!]/", $param, $tmp))
            $param = "id=$param";
        $sql = "delete from " . $table . " where " . $param;
        $this->db->exec($sql);
    }
    /*-----------------------------------------数据库常规查询封装 end-------------------------------*/
    public function error($param = '')
    {
        $this->display("Public/error.html");
        exit;
    }
    public function success($param = '')
    {
        $this->display("Public/success.html");
        exit;
    }
    public function getparam($param)
    {
        if (is_array($this->array_url)) {
            if (in_array($param, array_keys($this->array_url))) {
                return $this->array_url[$param];
            } else {
                return null;
            }
        }
    }
    public function validateTip($param, $_this)
    {
        $_this->assign('Tip', $param);
        $_this->display("Public/validation.html");
        exit;
    }
    public function is_exist_widget($plu_name)
    {
        if (file_exists("./Plugin/" . $plu_name . ".php")) {
            return true;
        } else {
            return false;
        }
    }
    public function is_active_widget($plu_name)
    {
        $res = $this->db->query("select * from " . $this->C('db_prefix') . "plugin where name='" . $plu_name . "'");
        $arr = $res->fetch();
        if ($arr['status'] == 1) {
            return true;
        } else {
            return false;
        }
    }
    function cc_encrypt($txtStream, $key = null)
    {
        if (empty($key)) {
            $key = include("./Conf/key.config.php");
        }
        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
        //随机找一个数字，并从密锁串中找到一个密锁值
        $lockLen    = strlen($lockstream);
        $lockCount  = rand(0, $lockLen - 1);
        $randomLock = $lockstream[$lockCount];
        //结合随机密锁值生成MD5后的密码
        $password   = md5($key . $randomLock);
        //开始对字符串加密
        $txtStream  = base64_encode($txtStream);
        $tmpStream  = '';
        $i          = 0;
        $j          = 0;
        $k          = 0;
        for ($i = 0; $i < strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = (strpos($lockstream, $txtStream[$i]) + $lockCount + ord($password[$k])) % ($lockLen);
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return $tmpStream . $randomLock;
    }
    function cc_decrypt($txtStream, $key)
    {
        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
        $lockLen    = strlen($lockstream);
        //获得字符串长度
        $txtLen     = strlen($txtStream);
        //截取随机密锁值
        $randomLock = $txtStream[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount  = strpos($lockstream, $randomLock);
        //结合随机密锁值生成MD5后的密码
        $password   = md5($key . $randomLock);
        //开始对字符串解密
        $txtStream  = substr($txtStream, 0, $txtLen - 1);
        $tmpStream  = '';
        $i          = 0;
        $j          = 0;
        $k          = 0;
        for ($i = 0; $i < strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = strpos($lockstream, $txtStream[$i]) - $lockCount - ord($password[$k]);
            while ($j < 0) {
                $j = $j + ($lockLen);
            }
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return base64_decode($tmpStream);
    }
    public function C($param)
    {
        return $this->config[$param];
    }
}
/*-------------------------------核心类结束--------------------------------*/
function dump($value)
{
    ob_start();
    var_dump($value);
    $out = ob_get_clean();
    echo "<pre>" . $out . "</pre>";
}
function w($plu_name)
{
    if (file_exists("./Plugin/" . $plu_name . ".php")) {
        $o = new $plu_name();
        return $o;
    }
}
/*-----------------------------------------控制器入口类-------------------------------*/
class App
{
    static function run()
    {
        $config    = require("Conf/config.php");
        $path_info = !empty($_SERVER['PATH_INFO']) ? @$_SERVER['PATH_INFO'] : @$_SERVER['ORIG_PATH_INFO'];
        if (empty($path_info) || (strtolower(substr($path_info, strrpos($path_info, "/"))) == '/index.php')) {
            if (empty($config['default_action'])) {
                try {
                    if (class_exists("IndexAction"))
                        $app = new IndexAction();
                    else
                        throw new Exception('无法加载模块Index!', "302");
                }
                catch (Exception $e) {
                    call_user_func(array(
                        new YouYaX(),
                        'exception'
                    ), $e);
                }
            } else {
                try {
                    if (class_exists($config['default_action'] . "Action")) {
                        $class = $config['default_action'] . "Action";
                        $app   = new $class();
                    } else
                        throw new Exception('无法加载模块' . $config['default_action'], "302");
                }
                catch (Exception $e) {
                    call_user_func(array(
                        new YouYaX(),
                        'exception'
                    ), $e);
                }
            }
            try {
                if (method_exists($app, 'index'))
                    $app->index();
                else
                    throw new Exception('无法加载方法index!', "303");
            }
            catch (Exception $e) {
                call_user_func(array(
                    new YouYaX(),
                    'exception'
                ), $e);
            }
        } else {
            $str = preg_split("#" . $config['default_url'] . "#", substr($path_info, 1, strlen($path_info) - strlen($config['static_url']) - 1), -1, PREG_SPLIT_NO_EMPTY);
            /*  URL short start*/
            //length is zero,insert a new value
            if ($str[0] == 'List' && is_numeric($str[1])) {
                array_splice($str, 1, 0, array(
                    1 => 'index',
                    2 => 'f'
                ));
            }
            if ($str[0] == 'Content' && is_numeric($str[1])) {
                array_splice($str, 1, 0, array(
                    1 => 'index',
                    2 => 'id'
                ));
            }
            if ($str[0] == 'Widget' && $str[1] == 'getAction') {
                array_splice($str, 2, 0, array(
                    1 => 'name'
                ));
                array_splice($str, 4, 0, array(
                    1 => 'method'
                ));
            }
            if (($str[0] == 'quote' || $str[0] == 'edit') && is_numeric($str[1]) && is_numeric($str[2])) {
                array_splice($str, 0, 0, array(
                    1 => 'Content'
                ));
                array_splice($str, 2, 0, array(
                    1 => 'id2'
                ));
                array_splice($str, 4, 0, array(
                    1 => 'id'
                ));
            } else if (($str[0] == 'quote' || $str[0] == 'edit') && is_numeric($str[1])) {
                array_splice($str, 0, 0, array(
                    1 => 'Content'
                ));
                array_splice($str, 2, 0, array(
                    1 => 'id'
                ));
            } else if ($str[0] == 'accept' && is_numeric($str[1])) {
                array_splice($str, 0, 0, array(
                    1 => 'Bid'
                ));
                array_splice($str, 2, 0, array(
                    1 => 'id2'
                ));
                array_splice($str, 4, 0, array(
                    1 => 'id'
                ));
            } else {
            }
            /*  URL short end*/
            $class = $str[0] . "Action";
            try {
                if (class_exists($class))
                    $app = new $class($str);
                else
                    throw new Exception('无法加载模块' . $str[0] . '!', "302");
            }
            catch (Exception $e) {
                call_user_func(array(
                    new YouYaX(),
                    'exception'
                ), $e);
            }
            try {
                if (method_exists($app, $str[1])) {
                    //$app->$str[1]();
                    call_user_func(array(
                        $app,
                        $str[1]
                    ));
                } else {
                    throw new Exception('无法加载方法' . $str[1], "303");
                }
            }
            catch (Exception $e) {
                call_user_func(array(
                    new YouYaX(),
                    'exception'
                ), $e);
            }
        }
    }
}
/*-----------------------------------------控制器入口类 end-------------------------------*/
function match($value, $field)
{
    $modelvalidation = new validationAction();
    return $modelvalidation->match($value, $field);
}
/*-----------------------------------------验证模型类-------------------------------*/
class Model
{
    public function match($val, $field)
    {
        header("Content-type: text/html; charset=utf-8");
        if (array_key_exists($field, $this->validation['rules']))
            $rules = $this->validation['rules'][$field];
        try {
            if (empty($rules))
                throw new Exception(htmlspecialchars("验证模型加载异常!"), "310");
        }
        catch (Exception $e) {
            call_user_func(array(
                new YouYaX(),
                'exception'
            ), $e);
        }
        foreach ($rules as $k => $v) {
            if ($k == 'required' && $v == 'true') {
                $val = preg_replace("/\s*/", "", $val);
                $val = preg_replace("/&nbsp;*/", "", $val);
                if (empty($val) && $val != '0') {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'maxlength') {
                if (mb_strlen($val, 'utf8') > $v) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'minlength') {
                if (mb_strlen($val, 'utf8') < $v) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'max') {
                if ($val > $v) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'min') {
                if ($val < $v) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'email' && $v == 'true') {
                if (!preg_match('/^\w+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/', $val)) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'digital' && $v == 'true') {
                if (!preg_match('/^\d+$/', $val)) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'letter' && $v == 'true') {
                if (!preg_match('/^[a-zA-Z]+$/', $val)) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'alpha' && $v == 'true') {
                if (!preg_match('/^\w+$/', $val)) {
                    call_user_func(array(
                        new YouYaX(),
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
        }
        return true;
    }
}
/*-----------------------------------------验证模型类 end-------------------------------*/
function T($table)
{
    $t = new ActiveRecordAction($table);
    return $t;
}
require("ext/common.php");
?>