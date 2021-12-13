<?php

class Fenye_comments
{
	public $comments_size;//每页条数
	public $comments;  //第几页
	public $comments_count;//总页数
	public $num;//总条数
	function __construct($count,$comments_size)
	{
		$this->comments=1;
		$this->num=$count;
		$this->comments_size=$comments_size;	
		$this->comments_count=ceil($this->num/$this->comments_size);	
	}
	function geturl()
	{
		parse_str($_SERVER['QUERY_STRING'],$myArray);
		$myArray = array_diff($myArray, array(''));
		if(empty($_GET['page'])){
			$myArray['page']=1;
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return substr($url,0,strpos($url,"?")) ."?".http_build_query($myArray) . "&";
	}
	function  show()
	{
		$arg_list = func_get_args();
		$id = $arg_list[0];
		$num = !empty($arg_list[1]) ? $arg_list[1] : '';
		$id2 = !empty($arg_list[2]) ? $arg_list[2] : '';
		$request = !empty($arg_list[3]) ? $arg_list[3] : 1;
		if($this->comments_count<=5)
		{
			 $array=array();
			 array_push($array,"<a  href='".$this->geturl().$id."_".$id2."_1"."#p".$num."'>首</a>");	
		 	 for($i=1;$i<=$this->comments_count;$i++)
		 	 {	
  				 array_push($array,"<a class=comments".$id."_".$id2."_".$i."  href='".$this->geturl().$id."_".$id2."_".$i."#p".$num."'>$i</a>");
			 }
  			array_push($array,"<a  href='".$this->geturl().$id."_".$id2."_".$this->comments_count."#p".$num."'>末</a>");
  			return $array;
		}
		else
		{
			$this->comments=$request;
			if($this->comments+2>=$this->comments_count)
				$this->comments=$this->comments_count-2;
			if($this->comments-2<=1)
				$this->comments=3;
			 $array=array();
			 array_push($array,"<a  href='".$this->geturl().$id."_".$id2."_1"."#p".$num."'>首</a>");	
		 	 for($i=$this->comments-2;$i<=$this->comments+2;$i++)
		 	 {
  				 array_push($array,"<a class=comments".$id."_".$id2."_".$i."  href='".$this->geturl().$id."_".$id2."_".$i."#p".$num."'>$i</a>");
			 }
  			array_push($array,"<a  href='".$this->geturl().$id."_".$id2."_".$this->comments_count."#p".$num."'>末</a>");
  			return $array;
  		}
	}
	/*
	function listcon($sql)
    {
        $this->comments = empty($_REQUEST['comments']) ? 0 : $_REQUEST['comments'];
        if ($this->comments <= 0)
            $this->comments = 1;
        if ($this->comments >= $this->comments_count)
            $this->comments = $this->comments_count;
        $offset = ($this->comments - 1) * $this->comments_size;
        $sql .= " limit " . $offset . "," . $this->comments_size;
        return $sql;
    }*/
}
?>