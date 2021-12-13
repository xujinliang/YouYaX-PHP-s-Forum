var xmlhttp;
if (window.ActiveXObject) {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
} else {
	xmlhttp = new XMLHttpRequest()
}

function setcookie(str) {
	var expDate = new Date();
	var dayPuls = expDate.getTime() + (24 * 60 * 60 * 1000);
	expDate.setTime(dayPuls);
	document.cookie = 'scrollbar=' + str + ';expires=' + expDate.toGMTString();
	alert("设置成功，请刷新页面！")
}

function setcookie2(str) {
	var expDate = new Date();
	var dayPuls = expDate.getTime() + (24 * 60 * 60 * 1000);
	expDate.setTime(dayPuls);
	document.cookie = 'record=' + str + ';expires=' + expDate.toGMTString();
	alert("设置成功，请刷新页面！")
}
/*
function delreply(val, rpass) {
	if (val == "" || val == null) {
		alert("id不能为空")
	} else if (rpass == "" || rpass == null) {
		alert("密码不能为空")
	} else {
		serverpage = rooturl + "/index.php/Content" + url + "delreply" + url + "rid" + url + val + url + "rpass" + url + rpass + shtml;
		xmlhttp.open("GET", serverpage);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				alert(xmlhttp.responseText)
			}
		}
		xmlhttp.send(null)
	}
}

function createDiv() {
	var h = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
	var bg = document.createElement("div");
	bg.id = "mybg";
	bg.style.cssText = "position:absolute;left:0px;top:0px;width:100%;height:" + h + "px;background:#333333;z-index:10;filter:alpha(opacity=50);-moz-opacity: 0.5;opacity: 0.5";
	document.body.appendChild(bg);
	var dv = document.createElement("div");
	dv.id = "mydiv";
//	if (document.all) 
//		dv.style.cssText = "width:300px;height:180px;border:6px solid #d13433;background:#d13433;z-index:20;position:absolute;left:" + w1 + "px;top:" + h1 + "px;-moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;box-shadow: rgb(255, 255, 255) 0px 0px 100px;-webkit-box-shadow: rgb(255, 255, 255) 0px 0px 100px;";
//	else 
		dv.style.cssText = "width:300px;height:180px;border:6px solid #d13433;background:#d13433;z-index:20;position:fixed;left:50%;top:50%;margin-left:-150px;margin-top:-90px;-moz-border-radius: 10px; -khtml-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;box-shadow: rgb(255, 255, 255) 0px 0px 100px;-webkit-box-shadow: rgb(255, 255, 255) 0px 0px 100px;";
	dv.innerHTML = '<table width=100% height=180 cellspacing=0 cellpadding=0><tr height=20><td align="right" width="100%" style="height:20px;line-height:20px;font-size:18px;float:right;text-align:right;background:#f5f5f5;color:#3d7800;border-top-right-radius: 10px; border-top-left-radius: 10px;"><span style="cursor:pointer;font-size:10px;font-weight:bold;margin-right:10px;" onclick="var bg=document.getElementById(\'mybg\');bg.parentNode.removeChild(bg);var dv=document.getElementById(\'mydiv\');dv.parentNode.removeChild(dv)">关闭</span></td></tr><tr><td valign="top" style="padding-top:10px;padding-left:30px;background:#ffffff;border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;"><span style="font-size:12px;float:left;">输入任意回复贴ID</span><div style="height:4px;clear:both;"></div><input type="text" name="replyid" id="replyid" style="clear:both;width:100px;height:20px;border:1px solid #aed0c9;outline:none"><div style="height:10px;clear:both;"></div><span style="font-size:12px;float:left;">输入管理密码</span><div style="height:4px;clear:both;"></div><input type="text" name="rpass" id="rpass" style="clear:both;width:100px;height:20px;border:1px solid #aed0c9;outline:none"><div style="clear:both;margin-top:10px;border:1px solid #f29f4b;width:50px;height:22px;background:#fff5ea;text-align:center;line-height:22px;font-size:12px;cursor:pointer" onclick="delreply(document.getElementById(\'replyid\').value,document.getElementById(\'rpass\').value)">删除</div></td></tr></table>';
	document.body.appendChild(dv)
}
*/
function favor(vid) {
	if (vid == "" || vid == null) {
		alert("id不能为空")
	} else {
		serverpage = rooturl + "/index.php/Favor" + url + "index" + url + "id" + url + vid + shtml;
		xmlhttp.open("GET", serverpage);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				alert(xmlhttp.responseText)
			}
		}
		xmlhttp.send(null)
	}
}