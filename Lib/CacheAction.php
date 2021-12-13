<?php
class CacheAction extends YouYaX
{
    public $fileName;
    function __construct($time)
    {
        ob_start();
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ||strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0') !== false||strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0') !== false){
        	$this->path = 'cache/LessIE8';
        }else{
        	$this->path = 'cache/MoreIE8';
        }
        if (!is_dir($this->path)) {
            mkdir($this->path,0777,true);
        }
        $this->time     = $time;
        $this->fileType = 'php';
        if (isset($_COOKIE['youyax_lang'])) {
            $suffix = $_COOKIE['youyax_lang'];
        } else {
            $default_language = $this->C('default_language');
            if (!empty($default_language)) {
                $suffix = $this->C('default_language');
            } else {
                $suffix = 'cn';
            }
        }
        if ($this->getparam("l") != "" && $this->getparam("l") != null) {
            $suffix = $this->getparam("l");
            setcookie("youyax_lang", $this->getparam("l"), time() + 3600 * 24 * 7, "/");
        }
        $this->fileName = "./" . $this->path . "/" . base64_encode($_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"]) . '_' . $suffix . '.' . $this->fileType;
        if (file_exists($this->fileName) && (time() - $this->time < filemtime($this->fileName))) {
            $fp = fopen($this->fileName, "r");
            echo fread($fp, filesize($this->fileName));
            fclose($fp);
            ob_end_flush();
            exit;
        }
    }
    public function endCache()
    {
        $fp = @fopen($this->fileName, "w");
        if (@flock($fp, LOCK_EX)) {
            fwrite($fp, ob_get_contents());
            @flock($fp, LOCK_UN);
        }
        @fclose($fp);
        ob_end_flush();
    }
}
?>