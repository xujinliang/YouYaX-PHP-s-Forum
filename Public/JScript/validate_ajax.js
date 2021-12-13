var xmlhttp;
if (window.ActiveXObject) {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
} else {
    xmlhttp = new XMLHttpRequest()
}
function $(o) {
    return document.getElementById(o)
}
var error;
function check(val) {
	  error=0;
    if (document.forms['form'].user.value == "") {
        $("msg").innerHTML = "<font color=red>用户名不能为空！</font>";
        //document.forms['form'].user.focus();
        error=1;
        return false;
    }
    if (document.forms['form'].user.value.length > 7 || document.forms['form'].user.value.length < 2) {
        $("msg").innerHTML = "<font color=red>用户名长度必须在2~7个字符之间</font>";
        //document.forms['form'].user.focus();
        error=1;
        return false;
    }
    if ((document.forms['form'].user.value).indexOf(" ") == 0) {
        $("msg").innerHTML = "<font color=red>用户名首字符不能为空</font>";
        //document.forms['form'].user.focus();
        error=1;
        return false;
    }
    if (document.forms['form'].pass.value == "") {
        $("msg").innerHTML = "<font color=red>密码不能为空！</font>";
        //document.forms['form'].pass.focus();
        error=1;
        return false;
    }
    if(document.getElementById("email")){
	    if (document.forms['form'].email.value == "") {
	       $("msg").innerHTML = "<font color=red>邮箱不能为空！</font>";
	       //document.forms['form'].email.focus();
	       error=1;
	       return false;
	    }
  	}
  	if(document.getElementById("valicode")){
	    if (document.forms['form'].valicode.value == "" && document.getElementById("valicode")) {
	        $("msg").innerHTML = "<font color=red>验证码不能为空！</font>";
	        //document.forms['form'].valicode.focus();
	        error=1;
	        return false;
	    }
  	}
  	if(error==0 && val=='ok'){
  		$("msg").innerHTML = '';
  		document.forms['form'].submit();
  	}else{
  		return true;	
  	}
}
function senddata(val) {
    xmlhttp.open("POST", rooturl + "/index.php/Register" + url + "validate" + shtml, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("username="+document.getElementById('username').value+"&password="+document.getElementById('pass').value);
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	switch(xmlhttp.responseText){
        		case "1":
        			document.getElementById("msg").innerHTML = '<FONT color=RED>用户名不能为空！</FONT>';
        			//document.forms['form'].user.focus();
        			break;
        		case "2":
        			document.getElementById("msg").innerHTML = '<FONT color=RED>该用户名已被人使用</FONT>';
        			//document.forms['form'].user.focus();
        			break;
        		case "3":
        			if(check(null)){
        				document.getElementById("msg").innerHTML = '<FONT color=GREEN>该用户名可以使用</FONT>';
        				//document.forms['form'].user.focus();
        			}if(val=='ok'){
        				check('ok');
        			}
        			break;
        		case "4":
        			document.getElementById("msg").innerHTML = '<FONT color=RED>用户名验证程序出错</FONT>';
        			break;
        		case "5":
        			document.getElementById("msg").innerHTML = '<FONT color=RED>用户名仅支持中文、英文、数字、下划线</FONT>';
        			//document.forms['form'].user.focus();
        			break;
        		case "6":
        			document.getElementById("msg").innerHTML = '<FONT color=RED>密码仅支持英文、数字、下划线</FONT>';
        			//document.forms['form'].pass.focus();
        			break;
        		default:
        			return false;
        			break;
        	}
        }
    }
}