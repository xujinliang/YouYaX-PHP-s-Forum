<?php
class SignatureWidget extends YouYaX
{
	//用于后台查看插件信息，必填函数,函数名不能随意
	public function desc(){
		$this->version="1.0";
		$this->author="youyax";
		$this->description="个性签名插件，激活后将会在user表增加一个新的字段";
		return $this;
	}
	//激活前的安装,有就执行，数据表user中添加一个字段'sign'，函数名不能随意
	public function install(){
		if (empty($_SESSION['youyax_admin'])) {
            exit;
        }
		$sign_query = $this->db->query('Describe '.$this->C('db_prefix').'user sign');
		$sign_arr   = $sign_query->fetch();
		if(empty($sign_arr[0])){
			$this->db->exec('alter table '.$this->C('db_prefix').'user add sign varchar(30) NULL');
		}
	}
	//个人中心前台左侧区域
	public function show(){
		if (empty($_SESSION['youyax_user'])) {
            exit;
        }
		$data=$this->find($this->C('db_prefix')."user","string","user='".$_SESSION['youyax_user']."'");
		return '<form method="post" action="'.$this->youyax_url.'/Widget'.$this->C('default_url').'postAction'.$this->C('static_url').'">		
			<p>
				<label>设置个性签名</label>
          		<input class="text-input medium-input" type="text" name="sign_title" value="'.$data['sign'].'">
          	</p>
         	<p>
          		<input class="button" type=submit value="更新">
        	</p>
        	<input type="hidden" name="name" value="SignatureWidget">
        	<input type="hidden" name="method" value="showDeal">        
      	</form>';
	}
	//个人中心前台右侧菜单
	public function slideName(){
		if (empty($_SESSION['youyax_user'])) {
            exit;
        }
       if(!stristr($_SERVER['HTTP_USER_AGENT'], 'android') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') && !stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')){
		$label = '设置个性签名';
	  }else{
	  	$label = '个性签名';
	  }
	  return '<li><a rel="signature" href="'.$this->youyax_url.'/Widget'.$this->C('default_url').'getAction'.$this->C('default_url').'SignatureWidget'.$this->C('default_url').'slideDisplay'.$this->C('static_url').'"  class="btn">'.$label.'</a></li>';
	}
	//内容页前台签名展示
	public function showSign(){
		$arg_list = func_get_args();
		$data=$this->find($this->C('db_prefix')."user","string","user='".$arg_list[0]."'");
		if(!empty($data['sign'])){
			return '<img style="margin-left:20px;height:14px;" src="'.$this->C('SITE').'/Public/images/ico1.png" border="0"><span style="position:relative;top:-2px;color:rgba(51,51,51,0.5);font-size:12px;font-family:Tahoma">'.$data['sign'].'</span>';
		}
	}
	//右侧菜单操作逻辑
	public function slideDisplay(){
		if (empty($_SESSION['youyax_user'])) {
            exit;
        }
		$site_config = require("./Conf/site.config.php");
    $this->assign('site_config', $site_config);
	$this->assign('site', $this->C('SITE'))
		   ->assign('user', $_SESSION['youyax_user'])
           ->assign('shtml', $this->C('static_url'))
           ->assign('url', $this->C('default_url'))
		   ->display("home/signature.html");
	}
	//左侧区域操作逻辑
	public function showDeal(){
		if (empty($_SESSION['youyax_user'])) {
            exit;
        }
		$arg_list = func_get_args();
		$sign_title=$arg_list[0]['sign_title'];
		$data['sign']=addslashes(htmlspecialchars($sign_title, ENT_QUOTES, "UTF-8"));
		$this->save($data,$this->C('db_prefix')."user","user='".$_SESSION['youyax_user']."'");
		$this->assign('jumpurl', $this->youyax_url . "/Index" . $this->C('default_url') . "self" . $this->C('static_url'))
                 ->assign('msgtitle', '操作成功')
                 ->assign('message', '签名设置成功')
                 ->success();
	}
}
?>