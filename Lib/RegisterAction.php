<?php
class RegisterAction extends YouYaX
{
    public function ismobile()
    {
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'android') || stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') || stristr($_SERVER['HTTP_USER_AGENT'], 'windows phone')) {
            return true;
        } else {
            return false;
        }
    }
    public function show()
    {
        $mix = require("./Conf/mix.config.php");
        $this->assign('mix', $mix);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config);
        $this->assign('url', $this->C('default_url'));
        $this->assign('shtml', $this->C('static_url'));
        $this->display("reglog/register.html");
    }
    public function doUserCount()
    {
        $res       = $this->db->query("select * from " . $this->config['db_prefix'] . "count where id=1");
        $count_arr = $res->fetch();
        $data      = unserialize($count_arr['user_count']);
        $date      = date('w', time());
        $date2     = date('W', time());
        if ($date2 != $count_arr['week_order']) {
            $this->db->exec("update " . $this->config['db_prefix'] . "count set user_count='',post_count='',week_order='" . $date2 . "' where id=1");
            $count_arr_res = $this->db->query("select * from " . $this->config['db_prefix'] . "count where id=1");
            $count_arr     = $count_arr_res->fetch();
            $data          = unserialize($count_arr['user_count']);
        }
        switch ($date) {
            case 0:
                @$data['g']++;
                break;
            case 1:
                @$data['a']++;
                break;
            case 2:
                @$data['b']++;
                break;
            case 3:
                @$data['c']++;
                break;
            case 4:
                @$data['d']++;
                break;
            case 5:
                @$data['e']++;
                break;
            case 6:
                @$data['f']++;
                break;
        }
        $this->db->exec("update " . $this->config['db_prefix'] . "count set user_count='" . serialize($data) . "' where id=1");
    }
    public function doregister()
    {
        echo '<script>
    	   				if (window.parent.document.getElementById("register")) {
    	   					window.parent.document.getElementById("register").style.display="none";
    	   				}
    	   			</script>';
        $mix = require("./Conf/mix.config.php");
        if (empty($this->config['default_user_group']) || empty($this->config['not_log_in_user_group'])) {
            if ($this->ismobile()) {
                echo "<script>alert('????????????[??????????????????-??????]???????????????????????????????????????');</script>";
                exit;
            } else {
                echo '<script>
                				var txt=  "????????????[??????????????????-??????]<br>???????????????????????????????????????";
			  				window.parent.Tip3(txt, 2, "parent");
			  				if (!window.parent.document.getElementById("Tip")) {
								alert("????????????[??????????????????-??????]???????????????????????????????????????");
							}
                  	   </script>';
                exit;
            }
        }
        $user = addslashes(htmlspecialchars(trim($_POST['user']), ENT_QUOTES, "UTF-8"));
        if (empty($_POST['user'])) {
            if ($this->ismobile()) {
                echo "<script>alert('???????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "???????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (mb_strlen($user, 'utf8') > 7 || mb_strlen($user, 'utf8') < 2) {
            if ($this->ismobile()) {
                echo "<script>alert('????????????????????????2~7???????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "????????????????????????2~7???????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????2~7???????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (mb_substr($_POST['user'], 0, 1, 'utf-8') == ' ') {
            if ($this->ismobile()) {
                echo "<script>alert('??????????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "??????????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("??????????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $_POST['user'])) {
            if ($this->ismobile()) {
                echo "<script>alert('??????????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "??????????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("??????????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (empty($_POST['pass'])) {
            if ($this->ismobile()) {
                echo "<script>alert('????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (!preg_match("/^[A-Za-z0-9_]+$/u", $_POST['pass'])) {
            if ($this->ismobile()) {
                echo "<script>alert('???????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "???????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        $pass           = addslashes($this->cc_encrypt($_POST['pass']));
        $_POST['email'] = addslashes($_POST['email']);
        if (empty($_POST['email'])) {
            if ($this->ismobile()) {
                echo "<script>alert('???????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "???????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            if ($this->ismobile()) {
                echo "<script>alert('??????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "??????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("??????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if ($mix['is_prevent_reg']) {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                $myIp = $_SERVER['HTTP_CLIENT_IP'];
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $myIp = $_SERVER['REMOTE_ADDR'];
            if (!filter_var($myIp, FILTER_VALIDATE_IP)) {
                if ($this->ismobile()) {
                    echo "<script>alert('???IP??????????????????!');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "???IP??????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???IP??????????????????");
								}
                        	   </script>';
                    exit;
                }
            }
            $sql    = "select * from " . $this->config['db_prefix'] . "user where ip_addr='" . $myIp . "'";
            $result = $this->db->query($sql);
            $num    = count($result->fetchAll());
            if ($num >= $mix['prevent_reg_num']) {
                if ($this->ismobile()) {
                    echo "<script>alert('????????????,???IP???????????????????????? " . $mix['prevent_reg_num'] . " ??????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "????????????<br>???IP???????????????????????? ' . $mix['prevent_reg_num'] . ' ??????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????,???IP???????????????????????? ' . $mix['prevent_reg_num'] . ' ??????");
								}
                        	   </script>';
                    exit;
                }
            }
        }
        $str  = "abcdefghijklmnopqrstuvwxyz0123456789";
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($str, mt_rand(0, 35), 1);
        }
        $mailconf = require("./Conf/mail.config.php");
        if ($this->config['register_mode'] == 1) {
            if (empty($mailconf['mail_Host']) || empty($mailconf['mail_Username']) || empty($mailconf['mail_Password'])) {
                if ($this->ismobile()) {
                    echo "<script>alert('????????????????????????SMTP???????????????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "????????????????????????SMTP????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????SMTP????????????");
								}
                        	   </script>';
                    exit;
                }
            }
        }
        if ($this->config['register_mode'] == 1 || $this->config['register_mode'] == 3) {
            if (empty($mailconf['mail_From']) || empty($mailconf['mail_FromName']) || empty($mailconf['mail_Subject']) || empty($mailconf['mail_Body'])) {
                if ($this->ismobile()) {
                    echo "<script>alert('????????????????????????????????????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "????????????????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????????????????");
								}
                        	   </script>';
                    exit;
                }
            }
        }
        $this->db->exec("SET NAMES 'utf8'");
        $this->db->exec("SET sql_mode=''");
        date_default_timezone_set('Asia/Shanghai');
        $sql    = "select * from " . $this->config['db_prefix'] . "user where user='" . $user . "'";
        $result = $this->db->query($sql);
        $num    = count($result->fetchAll());
        if ($num > 0) {
            if ($this->ismobile()) {
                echo "<script>alert('????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
            } else {
                echo '<script>
                        			var txt=  "????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????");
								}
                        	</script>';
            }
        } else {
            $sql2    = "select * from " . $this->config['db_prefix'] . "user where email='" . $_POST['email'] . "'";
            $result2 = $this->db->query($sql2);
            $num2    = count($result2->fetchAll());
            if ($num2 > 0) {
                if ($this->ismobile()) {
                    echo "<script>alert('?????????????????????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                } else {
                    echo '<script>
                        				var txt=  "?????????????????????";
					  				window.parent.Tip3(txt, 2, "parent");
					  				if (!window.parent.document.getElementById("Tip")) {
										alert("?????????????????????");
									}
                        		</script>';
                }
                exit;
            } else {
                if ($this->config['register_mode'] == 1) {
                    require_once("./ext_public/phpmailer/class.phpmailer.php");
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host     = $mailconf['mail_Host'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $mailconf['mail_Username'];
                    $mail->Password = $mailconf['mail_Password'];
                    $mail->From     = $mailconf['mail_From'];
                    $mail->FromName = $mailconf['mail_FromName'];
                    $mail->AddAddress($_POST['email']);
                    $mail->IsHTML(true);
                    $mail->CharSet  = "UTF-8";
                    $mail->Encoding = "base64";
                    $mail->Subject  = $mailconf['mail_Subject'];
                    $mail->Body     = $mailconf['mail_Body'] . "<br><a href='" . $this->youyax_url . "/Register" . $this->C('default_url') . "mailActive" . $this->C('default_url') . "user" . $this->C('default_url') . urlencode($user) . $this->C('default_url') . "email" . $this->C('default_url') . $_POST['email'] . $this->C('default_url') . "code" . $this->C('default_url') . $code . $this->C('static_url') . "?pass=" . rawurlencode($this->cc_encrypt($_POST['pass'])) . "'>????????????</a>";
                    if (!$mail->Send()) {
                        echo $mail->ErrorInfo;
                        exit;
                    }
                    if ($mix['is_prevent_reg']) {
                        $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,ip_addr,user_group) values('" . $user . "','" . $pass . "',0,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $myIp . "','" . $this->config['default_user_group'] . "')";
                    } else {
                        $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,user_group) values('" . $user . "','" . $pass . "',0,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $this->config['default_user_group'] . "')";
                    }
                    $this->db->exec($sql);
                    $this->doUserCount();
                    if ($this->ismobile()) {
                        echo "<script>alert('????????????,?????????????????????');</script>";
                        echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    } else {
                        echo '<script>
                        				var txt=  "????????????<br>?????????????????????";
					  				window.parent.Tip3(txt, 3, "parent");
					  				if (!window.parent.document.getElementById("Tip")) {
										alert("????????????,?????????????????????");
									}
                        		   </script>';
                    }
                } else if ($this->config['register_mode'] == 3) {
                    $to      = $_POST['email'];
                    $subject = $mailconf['mail_Subject'];
                    $body    = $mailconf['mail_Body'] . "<br><a href='" . $this->youyax_url . "/Register" . $this->C('default_url') . "mailActive" . $this->C('default_url') . "user" . $this->C('default_url') . urlencode($user) . $this->C('default_url') . "email" . $this->C('default_url') . $_POST['email'] . $this->C('default_url') . "code" . $this->C('default_url') . $code . $this->C('static_url') . "?pass=" . rawurlencode($this->cc_encrypt($_POST['pass'])) . "'>????????????</a>";
                    $from    = $mailconf['mail_From'];
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8\r\n";
                    $headers .= "From: " . $mailconf['mail_FromName'] . "<" . $from . ">";
                    if (mail($to, $subject, $body, $headers)) {
                        if ($mix['is_prevent_reg']) {
                            $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,ip_addr,user_group) values('" . $user . "','" . $pass . "',0,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $myIp . "','" . $this->config['default_user_group'] . "')";
                        } else {
                            $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,user_group) values('" . $user . "','" . $pass . "',0,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $this->config['default_user_group'] . "')";
                        }
                        $this->db->exec($sql);
                        $this->doUserCount();
                        if ($this->ismobile()) {
                            echo "<script>alert('????????????,??????????????????!');</script>";
                            echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                        } else {
                            echo '<script>
                        					var txt=  "????????????<br>?????????????????????";
					  					window.parent.Tip3(txt, 3, "parent");
					  					if (!window.parent.document.getElementById("Tip")) {
											alert("????????????,?????????????????????");
										}
                        			 </script>';
                        }
                    }
                } else {
                    if (addslashes($_POST['valicode']) != $_SESSION['verify']) {
                        if ($this->ismobile()) {
                            echo "<script>alert('??????????????????????????????');</script>";
                            echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                            exit;
                        } else {
                            echo '<script>
                        				var txt=  "??????????????????????????????";
					  				window.parent.Tip3(txt, 2, "parent");
					  				if (!window.parent.document.getElementById("Tip")) {
										alert("??????????????????????????????");
									}
                        			 </script>';
                            exit;
                        }
                    } else {
                        if ($mix['is_prevent_reg']) {
                            $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,ip_addr,user_group) values('" . $user . "','" . $pass . "',1,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $myIp . "','" . $this->config['default_user_group'] . "')";
                        } else {
                            $sql = "insert into " . $this->config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,bid,codes,user_group) values('" . $user . "','" . $pass . "',1,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $mix['bid_init'] . "','" . $code . "','" . $this->config['default_user_group'] . "')";
                        }
                        $this->db->exec($sql);
                        $this->doUserCount();
                        $_SESSION['youyax_user'] = $user;
                        if ($this->ismobile()) {
                            echo "<script>alert('????????????????????????\n?????????????????????????????????');</script>";
                            echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                        } else {
                            echo '<script>
                        				var txt=  "????????????????????????<br>?????????????????????????????????";
					  				window.parent.Tip3(txt, 3, "parent");
					  				 if (!window.parent.document.getElementById("Tip")) {
										alert("????????????????????????\n??????????????????????????????");
									}
                        			</script>';
                        }
                    }
                }
            }
        }
    }
    public function validate()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if ($user == "" || $user == null) {
            echo "1";
            exit;
        }
        if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $user)) {
            echo "5";
            exit;
        }
        $sql    = "select * from " . $this->config['db_prefix'] . "user where user='" . addslashes($user) . "'";
        $result = $this->db->query($sql);
        $num    = count($result->fetchAll());
        if ($num > 0) {
            echo "2";
            exit;
        } else if ($num == 0) {
            if (!preg_match("/^[A-Za-z0-9_]+$/u", $pass)) {
                echo "6";
                exit;
            }
            echo "3";
            exit;
        } else {
            echo "4";
            exit;
        }
    }
    public function mailActive()
    {
        $sql = "select * from " . $this->config['db_prefix'] . "user where user='" . urldecode($this->getparam("user")) . "' and email='" . $this->getparam("email") . "' and codes='" . $this->getparam("code") . "'";
        $res = $this->db->query($sql);
        if ($res) {
            $arr = $res->fetch();
            $key = require("./Conf/key.config.php");
            if ($arr && ($this->cc_decrypt($arr['pass'], $key) == $this->cc_decrypt(rawurldecode($_GET["pass"]), $key))) {
                $str  = "abcdefghijklmnopqrstuvwxyz0123456789";
                $code = '';
                for ($i = 0; $i < 6; $i++) {
                    $code .= substr($str, mt_rand(0, 35), 1);
                }
                $sql = "update " . $this->config['db_prefix'] . "user set status=1,codes='" . $code . "' where user='" . urldecode($this->getparam("user")) . "'";
                $this->db->exec($sql);
                $tip1 = "????????????";
                $tip2 = "??????????????????";
            } else {
                $tip1 = "????????????";
                $tip2 = "???????????????????????????";
            }
        } else {
            $tip1 = "????????????";
            $tip2 = "???????????????????????????";
        }
        $this->assign('tip1', $tip1)->assign('tip2', $tip2)->display('reglog/mail_active.html');
    }
    public function forgotPassword()
    {
        $this->display("reglog/forgot_password.html");
    }
    public function doForgotPassword()
    {
        echo '<script>
    	   				if (window.parent.document.getElementById("register")) {
    	   					window.parent.document.getElementById("register").style.display="none";
    	   				}
    	   			</script>';
        $default_user_group    = $this->C('default_user_group');
        $not_log_in_user_group = $this->C('not_log_in_user_group');
        if (empty($default_user_group) || empty($not_log_in_user_group)) {
            if ($this->ismobile()) {
                echo "<script>alert('????????????[??????????????????-??????]???????????????????????????????????????');</script>";
                exit;
            } else {
                echo '<script>
                				var txt=  "????????????[??????????????????-??????]<br>???????????????????????????????????????";
			  				window.parent.Tip3(txt, 2, "parent");
			  				if (!window.parent.document.getElementById("Tip")) {
								alert("????????????[??????????????????-??????]???????????????????????????????????????");
							}
                  	   </script>';
                exit;
            }
        }
        $_POST['email'] = addslashes($_POST['email']);
        $_POST['pass']  = addslashes($_POST['pass']);
        if (empty($_POST['email']) || empty($_POST['pass'])) {
            if ($this->ismobile()) {
                echo "<script>alert('???????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "???????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        if (!preg_match("/^[A-Za-z0-9_]+$/u", $_POST['pass'])) {
            if ($this->ismobile()) {
                echo "<script>alert('??????????????????????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "??????????????????????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("??????????????????????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
        $mailconf = require("./Conf/mail.config.php");
        if ($this->config['register_mode'] == 1) {
            if (empty($mailconf['mail_Host']) || empty($mailconf['mail_Username']) || empty($mailconf['mail_Password'])) {
                if ($this->ismobile()) {
                    echo "<script>alert('????????????????????????SMTP???????????????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "????????????????????????SMTP???????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????SMTP???????????????");
								}
                        	   </script>';
                    exit;
                }
            }
        } else {
            if (empty($mailconf['mail_From']) || empty($mailconf['mail_FromName']) || empty($mailconf['mail_Subject']) || empty($mailconf['mail_Body'])) {
                if ($this->ismobile()) {
                    echo "<script>alert('????????????????????????????????????');</script>";
                    echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                    exit;
                } else {
                    echo '<script>
                        			var txt=  "????????????????????????????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????????????????");
								}
                        	   </script>';
                    exit;
                }
            }
        }
        $sql = "select * from " . $this->C('db_prefix') . "user where email='" . $_POST['email'] . "'";
        $res = $this->db->query($sql);
        $num = $this->db->query("select count(*) from " . $this->C('db_prefix') . "user where email='" . $_POST['email'] . "'")->fetchColumn();
        if ($num <= 0) {
            if ($this->ismobile()) {
                echo "<script>alert('???????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "???????????????";
					  			window.parent.Tip3(txt, 2, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("???????????????");
								}
                        	   </script>';
                exit;
            }
        } else {
            $arr  = $res->fetch();
            $code = $arr['codes'];
            if ($this->config['register_mode'] == 1) {
                require_once("./ext_public/phpmailer/class.phpmailer.php");
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host     = $mailconf['mail_Host'];
                $mail->SMTPAuth = true;
                $mail->Username = $mailconf['mail_Username'];
                $mail->Password = $mailconf['mail_Password'];
                $mail->From     = $mailconf['mail_From'];
                $mail->FromName = $mailconf['mail_FromName'];
                $mail->AddAddress($_POST['email']);
                $mail->IsHTML(true);
                $mail->CharSet  = "UTF-8";
                $mail->Encoding = "base64";
                $mail->Subject  = "????????????????????????";
                $mail->Body     = "????????????????????????????????????????????????????????????????????????????????????<br><a href='" . $this->youyax_url . "/Register" . $this->C('default_url') . "forgot_password_active" . $this->C('default_url') . "email" . $this->C('default_url') . $_POST['email'] . $this->C('default_url') . "code" . $this->C('default_url') . $code . $this->C('static_url') . "?pass=" . rawurlencode($this->cc_encrypt($_POST['pass'])) . "'>????????????</a>";
                if (!$mail->Send()) {
                    exit;
                }
            } else {
                $to      = $_POST['email'];
                $subject = "????????????????????????";
                $body    = "????????????????????????????????????????????????????????????????????????????????????<br><a href='" . $this->youyax_url . "/Register" . $this->C('default_url') . "forgot_password_active" . $this->C('default_url') . "email" . $this->C('default_url') . $_POST['email'] . $this->C('default_url') . "code" . $this->C('default_url') . $code . $this->C('static_url') . "?pass=" . rawurlencode($this->cc_encrypt($_POST['pass'])) . "'>????????????</a>";
                $from    = $mailconf['mail_From'];
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "From: " . $mailconf['mail_FromName'] . "<" . $from . ">";
                if (!mail($to, $subject, $body, $headers)) {
                    exit;
                }
            }
            if ($this->ismobile()) {
                echo "<script>alert('????????????????????????????????????????????????');</script>";
                echo "<script>window.parent.location.href='" . $this->C('SITE') . "';</script>";
                exit;
            } else {
                echo '<script>
                        			var txt=  "??????????????????<br>???????????????????????????";
					  			window.parent.Tip3(txt, 3, "parent");
					  			if (!window.parent.document.getElementById("Tip")) {
									alert("????????????????????????????????????????????????");
								}
                        	   </script>';
                exit;
            }
        }
    }
    public function forgot_password_active()
    {
        $sql = "select * from " . $this->C('db_prefix') . "user where  email='" . $this->getparam("email") . "' and codes='" . $this->getparam("code") . "'";
        $res = $this->db->query($sql);
        $num = count($res->fetchAll());
        if ($num > 0) {
            $str  = "abcdefghijklmnopqrstuvwxyz0123456789";
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= substr($str, mt_rand(0, 35), 1);
            }
            $sql = "update " . $this->C('db_prefix') . "user set  pass='" . addslashes(rawurldecode($_GET["pass"])) . "',codes='" . $code . "' where email='" . $this->getparam("email") . "'";
            $this->db->exec($sql);
            $tip1 = "????????????";
            $tip2 = "??????????????????";
        } else {
            $tip1 = "????????????";
            $tip2 = "???????????????????????????";
        }
        $this->assign('tip1', $tip1)->assign('tip2', $tip2)->display('reglog/forgot_password_active.html');
    }
}
?>