<?php
class PicMagnifierWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="图片放大镜插件，仅针对本地图片，不支持网络图片，当图片宽度尺寸超过798px，则整体缩小使其不溢出，鼠标变成一个放大镜图标";
		return $this;
	}
	public function judge(){
		$arg_list = func_get_args();
		if(substr_count($arg_list[0],"<img ")){
			if(preg_match_all("/<img (.*?)src=\"([^<]*?upload[^<]*?)\">/",$arg_list[0],$tmp)){
				foreach($tmp[2] as $k => $v){
					$pic_o=explode("Public",$v);
					if(file_exists("./Public/".$pic_o[1])){
						$pic_t=getimagesize("./Public/".$pic_o[1]);
						if($pic_t[0] > 794){
							$arg_list[0] = str_replace($tmp[0][$k],"<a target='_blank' href='".$v."'><img onerror='nofind();' style='cursor:url(".$this->C('SITE')."/Public/images/magplus.gif),pointer;border:none;' width=794 src='".$v."'></a>",$arg_list[0]);
						}
					}
				}
				return $arg_list[0];
			}else{
				return $arg_list[0];
			}
		}else{
			return $arg_list[0];
		}
	}
}
?>