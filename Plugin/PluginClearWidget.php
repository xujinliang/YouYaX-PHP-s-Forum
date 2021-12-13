<?php
class PluginClearWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="此插件用于清理后台不需要的插件，可删除插件文件和数据库插件记录，因为youyax 2.3系统默认是不删除任何数据的";
		return $this;
	}
	public function uninstallShow(){
		if (empty($_SESSION['youyax_admin'])) {
            exit;
        }
		$arg_list = func_get_args();
		return '<a style="color:#222;font-size:12px;font-family:Tahoma;font-weight:bold" href="'.$this->youyax_url.'/Widget'.$this->C('default_url').'getAction'.$this->C('default_url').'PluginClearWidget'.$this->C('default_url').'delInstall'.$this->C('default_url').'delname'.$this->C('default_url').$arg_list[0].$this->C('static_url').'" onclick="return confirm(\'您确定要卸载?\');">卸载</a>';
	}
	public function delInstall(){
		if (empty($_SESSION['youyax_admin'])) {
            exit;
        }
		$arg_list = func_get_args();
		if(file_exists("./Plugin/".$arg_list[0]['delname'].".php")){
			@unlink("./Plugin/".$arg_list[0]['delname'].".php");
		}
		$this->delete($this->C('db_prefix')."plugin","name='".$arg_list[0]['delname']."'");
		$_SESSION['youyax_error'] = 1;
		$this->redirect("admin" . $this->C('default_url') . "pluginView" . $this->C('static_url'));
	}
}
?>