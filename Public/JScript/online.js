var xmlhttp,expand=false;
if (window.ActiveXObject) {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} else {
	xmlhttp = new XMLHttpRequest();
}

function getonline() {
	if (document.getElementById("ip")) {
		alert("禁止重复查询！");
		return;
	}
	var bheight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight) + "px";
	var bwidth = document.body.clientWidth + "px";
	var bg = document.createElement("div");
	bg.setAttribute("id", "mbg");
	bg.style.cssText = "position:absolute;left:0;top:0;width:" + bwidth + ";height:" + bheight + ";background:#333333;z-index:10;filter:alpha(opacity=30);-moz-opacity:0.3;opacity:0.3;";
	document.body.appendChild(bg);
	var mydiv = document.createElement("div");
	mydiv.setAttribute("id", "ip");
	mydiv.style.cssText = "position:fixed;left:50%;top:50%;margin-left:-270px;margin-top:-175px;width:540px;height:350px;border:1px solid #e3e3e3;background:#f5f5f5;z-index:11;padding:20px;border-radius:4px;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);";
	mydiv.innerHTML = '<div align="right" id="ipclose" style="width:540px;height:16;background:#f5f5f5"><span style="font-size:14px;font-weight:bold;cursor:pointer" onclick="var mbg = document.getElementById(\'mbg\'); mbg.parentNode.removeChild(mbg);var cdiv = document.getElementById(\'ip\'); cdiv.parentNode.removeChild(cdiv);">关闭</span></div> ' + '<div id="ipcon" style="width:540px;height:334px;overflow-y:scroll;"><img style="margin-left:250px;margin-top:140px;" src="' + rooturl + '/Public/images/waiting.gif"></div>';
	document.body.appendChild(mydiv);
	xmlhttp.open("POST", rooturl + "/index.php/Index" + url + "showip" + shtml, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("data=1");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var jsonObject = eval("(" + xmlhttp.responseText + ")");
			var con = "";
			for (var i in jsonObject) {
				con += jsonObject[i] + "<br>";
			}
			document.getElementById("ipcon").innerHTML = con;
		}
	}
}

function stopEvent(event) {
	expand = true;
	var e = arguments.callee.caller.arguments[0] || event;
	if (e && e.stopPropagation) {
		e.stopPropagation();
	} else if (window.event) {
		window.event.cancelBubble = true;
	}
}

function mouseoutfun(event, _this) {
	expand = false;
	var event = event || window.event;
	if (checkFather(_this, relatedTarget(event, 'mouseout'))) {
		document.getElementById("secmenu").style.display = "none";
	}
}

function relatedTarget(event, method) {
	var event = event || window.event;
	if (event.relatedTarget) return event.relatedTarget;
	if (method == 'mouseover') {
		return event.fromElement;
	}
	if (method == 'mouseout') {
		return event.toElement;
	}
}

function checkFather(obj, relatedTarget) {
	return obj != relatedTarget && !obj.contains(relatedTarget)
}

function getSecondMenu(_this, param, lan) {
	document.getElementById("secmenu").style.display="none";
	if (lan == '' || lan == null) {
		xmlhttp.open("POST", rooturl + "/index.php/Index" + url + "getsecmenu" + shtml, true);
	} else {
		xmlhttp.open("POST", rooturl + "/index.php/Index" + url + "getsecmenu" + url + "l" + url + lan + shtml, true);
	}
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("data=" + param);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			if(!expand){return;}
			var jsonObject = eval("(" + xmlhttp.responseText + ")");
			var len = jsonObject.length;
			var num = 0;
			var con = "<ul style=\"text-align:left;margin:0px;padding:0px;width:150px;list-style-type:none;\">";
			for (var i in jsonObject) {
				num++;
				if (num == len) {
					con += "<li style=\"width:150px;height:30px;line-height:30px;background:#03415d;\" onmouseover=\"this.style.background='#00a0ea'\" onmouseout=\"this.style.background='#03415d'\"><a style=\"font-family:Arial;font-size:12px;color:#fff;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href='" + jsonObject[i].url + "'>" + jsonObject[i].title + "</a></li>";
				} else {
					con += "<li style=\"width:150px;height:30px;line-height:30px;background:#03415d;\" onmouseover=\"this.style.background='#00a0ea'\" onmouseout=\"this.style.background='#03415d'\"><a style=\"font-family:Arial;font-size:12px;color:#fff;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href='" + jsonObject[i].url + "'>" + jsonObject[i].title + "</a></li><div><img src=\"" + rooturl + "/Public/images/menu_li_bg.png\"></div>";
				}
			}
			con += "</ul>";
			document.getElementById("secmenu").innerHTML = con;
			document.getElementById("secmenu").style.display="block";
			document.getElementById("secmenu").style.position="absolute";
			document.getElementById("secmenu").style.zIndex="999";
			document.getElementById("secmenu").style.left=getLeft(_this)+"px";
			document.getElementById("secmenu").style.top=getTop(_this)+_this.offsetHeight+"px";
		}
	}
}

function login_new(user, pass) {
	xmlhttp.open("POST", rooturl + "/index.php/Login" + url + "dologin" + shtml, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("user=" + user + "&pass=" + pass + "&sub=1");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			if (xmlhttp.responseText == 1) {
				Tip2('登陆成功,3秒后自动跳转', 3, 1, 'parent');
				for (var i = 3; i >= 0; i--) {
					(function() {
						var TipNum = i;
						t = setTimeout(
						function() {
							if (TipNum == 0) {
								window.clearTimeout(t);
								parent.window.location.href = rooturl;
							}
							if(parent.document.getElementById('TipMsg')){
								parent.document.getElementById('TipMsg').innerHTML='<table width=\"100%\" height=\"46\" border=\"0\"><tr><td>登陆成功,'+TipNum+'秒后自动跳转</td></tr></table>';
							}
						}, (3 - TipNum) * 1000);
					})()
				}
			} else if (xmlhttp.responseText == 2) {
				Tip2('输入有误 or 尚未激活！', 2, 1, 'parent');
			} else if (xmlhttp.responseText == 3) {
				Tip2('登录出错累计3次 <br> 请10分钟后再试!', 2, 1, 'parent');
			} else {
				Tip2('IP地址无效', 2, 1, 'parent');
			}
		}
	}
}