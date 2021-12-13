<?php
class delPostPicWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="此插件用于当删除帖子时，帖子若有图片，则将图片也一并删除。";
		return $this;
	}
	public function judge(){
	  if($this->find($this->C('db_prefix') . "admin","string", "user='" . $_SESSION['youyax_user'] . "'")){
		$arg_list = func_get_args();
		$con='';
		$talk = T($this->C('db_prefix') . "talk");
		$talk -> arfind($arg_list[0]);
		$con.=$talk -> content;
		$data=$this->select("select rid,content1 from ".$this->C('db_prefix') . "reply where rid=". $arg_list[0]);
		if(!empty($data)){
			foreach($data as $v){
				$con.=$v['content1'];
			}
		}
		if(preg_match_all("/<img (.*?)src=\"([^<]*?upload[^<]*?)\">/",$con,$tmp)){
			foreach($tmp[2] as $k => $v){
					$pic_o=explode("Public",$v);
					$pic_t="./Public/".$pic_o[1];
					if(file_exists($pic_t)){
						@unlink($pic_t);
					}
			}
		}
	  }
	}
	public function judgeReply(){
	  if($this->find($this->C('db_prefix') . "admin","string", "user='" . $_SESSION['youyax_user'] . "'")){
		$arg_list = func_get_args();
		$con='';
		$data=$this->select("select id2,content1 from ".$this->C('db_prefix') . "reply where id2=". $arg_list[0]);
		if(!empty($data)){
			foreach($data as $v){
				$con.=$v['content1'];
			}
		}
		if(preg_match_all("/<img (.*?)src=\"([^<]*?upload[^<]*?)\">/",$con,$tmp)){
			foreach($tmp[2] as $k => $v){
					$pic_o=explode("Public",$v);
					$pic_t="./Public/".$pic_o[1];
					if(file_exists($pic_t)){
						@unlink($pic_t);
					}
			}
		}
	  }
	}
}
?>