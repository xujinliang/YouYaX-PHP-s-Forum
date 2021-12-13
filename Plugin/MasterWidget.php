<?php
class MasterWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="显示版块的版主名称插件";
		return $this;
	}
	public function show(){
		$arg_list = func_get_args();
		$con='';
		$data = $this->select("select * from " . $this->C('db_prefix') . "admin");
		foreach($data as $v){
			$purview = unserialize($v['purview']);
			if(empty($purview)){$purview = array();}
			if(in_array($arg_list[0],$purview)){
				$con.=$v['user'].",";
			}
		}
		if(!empty($con)){
			$con = '<div style="color:#940100;clear:both;text-align:left;margin-bottom:4px;margin-left:8px;">[ 版主 ] '.substr($con,0,strlen($con)-1)."</div>";
			return $con;
		}
	}
}
?>