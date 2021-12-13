<?php
class VoteAction extends YouYaX
{
    public function dovote()
    {
        if (match($_SESSION['youyax_user'], "session_user")) {
            $vradio = is_numeric($_POST['vradio']) ? intval($_POST['vradio']) : '';
            $vid    = intval($_POST['vid']);
            $cid    = intval($_POST['cid']);
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                $myIp = $_SERVER['HTTP_CLIENT_IP'];
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $myIp = $_SERVER['REMOTE_ADDR'];
            if(!filter_var($myIp, FILTER_VALIDATE_IP)){
	    		$this->assign("code", "操作错误!")->assign("msg", "此IP地址是无效的!")->display("Public/exception.html");
                  echo "<script>setTimeout(function(){location.href = document.referrer;},2000);</script>";
			    exit;
		    }
            if (match($vradio, "vote")) {
                if ($ips_arr = $this->find($this->C('db_prefix') . "vote_ips", "string", "vid=" . $vid)) {
                    $ips = unserialize($ips_arr['ips']);
                    
                    if (in_array($myIp, $ips)) {
                        $this->assign("code", "操作错误!")->assign("msg", "您已经投过票了!")->display("Public/exception.html");
                    	  echo "<script>setTimeout(function(){location.href = document.referrer;},2000);</script>";
                        exit;
                    } else {
                        $ips[]       = $myIp;
                        $data['ips'] = serialize($ips);
                        $this->save($data, $this->C('db_prefix') . "vote_ips", "vid=" . $vid);
                        
                        $vote_arr = $this->find($this->C('db_prefix') . "vote", "string", "id=" . $vid);
                        $comb     = unserialize($vote_arr['comb']);
                        $comb[$vradio]['nums']++;
                        $data['comb'] = serialize($comb);
                        $this->save($data, $this->C('db_prefix') . "vote", "id=" . $vid);
                    }
                } else {
                    $array       = array();
                    $array[]     = $myIp;
                    $data['vid'] = $vid;
                    $data['ips'] = serialize($array);
                    $this->add($data, $this->C('db_prefix') . "vote_ips");
                    
                    $vote_arr = $this->find($this->C('db_prefix') . "vote", "string", "id=" . $vid);
                    $comb     = unserialize($vote_arr['comb']);
                    $comb[$vradio]['nums']++;
                    $data['comb'] = serialize($comb);
                    $this->save($data, $this->C('db_prefix') . "vote", "id=" . $vid);
                }
            }
            $this->redirect("Content" . $this->C('default_url') .$cid . $this->C('static_url'));
        }
    }
}
?>