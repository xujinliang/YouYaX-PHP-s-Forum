<?php
class PrivacyAction extends YouYaX
{
    static function NoPermission($user,$ID)
    {
    	if(empty($user)){
    		$user_group = self::getInstance()->C('not_log_in_user_group');
    	} else {
       //第一步操作根据$user判断所属用户组
       		$arr = self::getInstance()->find(self::getInstance()->C('db_prefix')."user","string","user='".$user."'");
       		$user_group = $arr['user_group'];
       	}
       //第二步根据这个用户组，查找该用户组的版块权限
       $arr2 = self::getInstance()->find(self::getInstance()->C('db_prefix')."user_group","string","id='".$user_group."'");
       $purview = unserialize($arr2['purview']);
       if(empty($purview)){$purview=array();}
	     if($purview[$ID]['access']==1){
	       	return false;
	      }else{
	      	return true;
	      }
    }
}
?>