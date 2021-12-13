<?php
class validationAction extends Model
{
    /*
    required maxlength minlength email digital letter alpha
    */
    public $mix;
    public $validation;
    function __construct(){
	    $this->mix               = require("./Conf/mix.config.php");
	    $this->validation = array(
	    	"rules"   => 
	    						array(
	    							//此处输入验证规则
	        					'session_user' => array('required' => 'true'), 
	        					'title'      => array('required' => 'true','maxlength' => $this->mix['talk_title']),
	        					'content'      => array('required' => 'true','minlength' => $this->mix['talk_content']),
	        					'lival'        => array('min' => 2, 'max' => 15), 
	        					'vote'         => array('required' => 'true')
	        				 ), 
	       "messages"=>
	       					 array(
	    						 //此处输入错误提示信息
	        				'session_user' => array('required' => '您没有权限操作，请先登陆'), 
	        				'title'      => array('required' => '标题不能为空','maxlength' => '标题最大为'.$this->mix['talk_title'].'个字符'),
	        				'content'      => array('required' => '内容不能为空','minlength' => '内容最少为'.$this->mix['talk_content'].'个字符'),
	         				'lival'        => array('min' => '投票选项至少为2项', 'max' => '投票选项至多为15项'), 
	         				'vote'         => array('required' => '投票选项不能为空')
	                 )
	    );
  	}
}
?>