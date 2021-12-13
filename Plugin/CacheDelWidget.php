<?php
class CacheDelWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="此插件用来清空缓存文件夹中的文件，激活后，在缓存容量信息栏会出现‘清空操作’";
		return $this;
	}
	public function show(){
		return '<a style="color:#222;font-size:12px;font-family:Tahoma;font-weight:bold" href="'.$this->youyax_url.'/Widget'.$this->C('default_url').'getAction'.$this->C('default_url').'CacheDelWidget'.$this->C('default_url').'clearCache'.$this->C('static_url').'" onclick="return confirm(\'您确定要清空?\');">( 清空缓存 )</a>';
	}
	public function deldir($dir){
	    $dh = opendir($dir);
	    while ($file = readdir($dh)) {
	        if ($file != "." && $file != "..") {
	            $fullpath = $dir . "/" . $file;
	            if (!is_dir($fullpath)) {
	                @unlink($fullpath);
	            } else {
	                self::deldir($fullpath);
	            }
	        }
	    }
	    @closedir($dir);
	}
	public function clearCache(){
		if (empty($_SESSION['youyax_admin'])) {
            exit;
        }
		$directory="./cache";
		$this->deldir($directory);
		echo "<script>window.parent.location.href='" . $this->youyax_url . "/admin" . $this->C('default_url') . "index" . $this->C('static_url')  . "';</script>";
	}
}
?>