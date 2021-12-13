<?php
class WidgetAction extends YouYaX
{
    public function setActive()
    {
	  	if ($_SESSION['token'] != $_GET["token"]) {
	  		$this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");exit;
	  	}else{
	  		$_SESSION['token']='';	
	  	}
  	  if (!empty($_SESSION['youyax_admin'])) {
        $class_name = $this->getparam("name");
        $data       = $this->find($this->C('db_prefix') . "plugin", "string", "name='" . $class_name . "'");
        if (empty($data)) {
            $dat['name']   = $class_name;
            $dat['status'] = 1;
            $this->add($dat, $this->C('db_prefix') . "plugin");
        } else {
            $dat['status'] = 1;
            $this->save($dat, $this->C('db_prefix') . "plugin", "name='" . $class_name . "'");
        }
        if (method_exists(w($class_name), 'install')) {
            w($class_name)->install();
        }
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "pluginView" . $this->C('static_url'));
      }
    }
    public function setUnActive()
    {
    	if ($_SESSION['token'] != $_GET["token"]) {
    		$this->assign("code", "操作错误!")->assign("msg", "Token失效，请刷新重试")->display("Public/exception.html");exit;
    	}else{
    		$_SESSION['token']='';	
    	}
    	if (!empty($_SESSION['youyax_admin'])) {
        $class_name    = $this->getparam("name");
        $dat['status'] = 0;
        $this->save($dat, $this->C('db_prefix') . "plugin", "name='" . $class_name . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . $this->C('default_url') . "pluginView" . $this->C('static_url'));
      }
    }
    public function postAction()
    {
        w($_POST['name'])->$_POST['method']($_POST);
    }
    public function getAction()
    {
        $class_name  = $this->getparam("name");
        $method_name = $this->getparam("method");
        w($class_name)->$method_name($this->array_url);
    }
}
?>