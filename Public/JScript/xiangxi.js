//document.onreadystatechange = function() {
//	if (document.readyState == "complete") {
function xuanran(){
		var url = window.location.href;
		url = url.substring(url.indexOf("?") + 1, url.length);
		// if(url.indexOf("=")!=-1){
		var url_array = url.split("=");
		var page;
		if (typeof(url_array[url_array.length - 1]) != 'undefined') {
			if (url_array[url_array.length - 1].indexOf("#") != -1) {
				page = url_array[url_array.length - 1].substring(0, url_array[url_array.length - 1].indexOf("#"));
			} else {
				page = url_array[url_array.length - 1];
			}
			var page_tmp = page.split("&");
			page = page_tmp[0];
		}
		var uclass = document.getElementsByTagName("a");
		for(var n=0;n<uclass.length;n++){
			if ((uclass[n].className == 'fy' + page) && (uclass[n].className != undefined)) {
				uclass[n].style.background = "#1c7bc5";
				uclass[n].style.color = "#ffffff";
			}
		}
		//  }else{
		if (url.indexOf("#") != -1) {
			page = url.substring(0, url.indexOf("#"));
		} else {
			page = url;
		}
		var page_tmp = page.split("&");
		page = page_tmp[page_tmp.length - 1];
		if (typeof(page) != 'undefined') {
			var url_tmp = page.split("_");
			var uclass = document.getElementsByTagName("a");
			for(var n=0;n<uclass.length;n++){
				if ((uclass[n].className == 'comments' + url_tmp[0] + "_" + url_tmp[1] + "_" + url_tmp[2]) && (uclass[n].className != undefined)) {
					uclass[n].style.background = "#1c7bc5";
					uclass[n].style.color = "#ffffff";
				}
			}
		}
}
		// }
//	}
//}
var xmlhttp;
if (window.ActiveXObject) {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} else {
	xmlhttp = new XMLHttpRequest();
}

function showdiv(e) {
	var e = window.event || e;
	document.getElementById("czz1div").style.left = e.clientX - 10 + "px";
	document.getElementById("czz1div").style.top = e.clientY - 10 + "px";
	document.getElementById("czz1div").style.display = "block";
}

function hidediv() {
	document.getElementById("czz1div").style.display = "none";
}

function showdiv2() {
	document.getElementById("czz1div").style.display = "block";
}

function hidediv2() {
	document.getElementById("czz1div").style.display = "none";
}

function showdivn(id, e) {
	var e = window.event || e;
	document.getElementById("czzdiv" + id).style.left = e.clientX - 10 + "px";
	document.getElementById("czzdiv" + id).style.top = e.clientY - 10 + document.documentElement.scrollTop + document.body.scrollTop + "px";
	document.getElementById("czzdiv" + id).style.display = "block";
}

function hidedivn(id) {
	document.getElementById("czzdiv" + id).style.display = "none";
}

function showdiv4(id) {
	document.getElementById("czzdiv" + id).style.display = "block";
}

function hidediv4(id) {
	document.getElementById("czzdiv" + id).style.display = "none";
}

function check() {
	document.getElementById("sub").disabled = true;
	var addr = window.location.pathname;
	addr = addr.substring(0, addr.length - shtml.length);
	addr = addr.split(url);
	addr = addr[addr.length - 1];
	if (document.form1.zuozhe1.value == "") {
		document.getElementById("sub").disabled = false;
		Tip("您没有权限发帖，请先登陆", 2);
		if (!document.getElementById("Tip")) {
			alert("您没有权限发帖，请先登陆");
		}
		return false;
	}
	if (document.getElementById("content").value == "") {
		document.getElementById("sub").disabled = false;
		Tip("回复内容不能为空！", 1);
		if (!document.getElementById("Tip")) {
			alert("回复内容不能为空！");
		}
		return false;
	}
	xmlhttp.open("POST", rooturl + "/index.php/Content" + url + "setParentID" + shtml, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("talk_id=" + addr);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			document.forms['form1'].submit();
		} else {
			document.getElementById("sub").disabled = false;
			return false;
		}
	}
	return false;
}

function showmarkone(id, mid, val) {
	val = typeof(val) == "undefined" ? '' : val;
	mid = typeof(mid) == "undefined" ? '' : mid;
	if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0") {
		document.getElementById("markone").style.cssText = "position:absolute;left:" + eval(document.documentElement.scrollLeft + (window.screen.availWidth - 420) / 2) + "px;top:" + eval(document.documentElement.scrollTop + (window.screen.availHeight - 250) / 2) + "px;z-index:99;width:400px;height:250px;border:10px solid rgba(0,0,0,0.3);border-radius:5px;background-clip:padding-box;background-color:#ebe8e3;";
	} else {
		document.getElementById("markone").style.cssText = "position:fixed;left:50%;top:50%;margin-left:-200px;margin-top:-125px;z-index:99;width:400px;height:250px;border:10px solid rgba(0,0,0,0.3);border-radius:5px;background-clip:padding-box;background-color:#ebe8e3;";
	}
	document.getElementById("markone").style.display = "block";
	document.getElementById("markone_iframe").src = rooturl + "/index.php/Content" + url + "mark" + shtml + "?id=" + id + "&reply_u=" + val + "&mid=" + mid;
/*if(val!=null){
    	document.frames["markone_iframe"].document.getElementById("reply_u").value = val;
    }else{
    	document.frames["markone_iframe"].document.getElementById("reply_u").value = '';
    }*/
}

function turnmarkone() {
	document.getElementById("markone").style.display = "none";
}

function showmark(m, id, mid, val) {
	val = typeof(val) == "undefined" ? '' : val;
	mid = typeof(mid) == "undefined" ? '' : mid;
	if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0") {
		document.getElementById("mark" + m).style.cssText = "position:absolute;left:" + eval(document.documentElement.scrollLeft + (window.screen.availWidth - 420) / 2) + "px;top:" + eval(document.documentElement.scrollTop + (window.screen.availHeight - 250) / 2) + "px;z-index:99;width:400px;height:250px;border:10px solid rgba(0,0,0,0.3);border-radius:5px;background-clip:padding-box;background-color:#ebe8e3;";
	} else {
		document.getElementById("mark" + m).style.cssText = "position:fixed;left:50%;top:50%;margin-left:-200px;margin-top:-125px;z-index:99;width:400px;height:250px;border:10px solid rgba(0,0,0,0.3);border-radius:5px;background-clip:padding-box;background-color:#ebe8e3;";
	}
	document.getElementById("mark" + m).style.display = "block";
	document.getElementById("mark_iframe" + m).src = rooturl + "/index.php/Content" + url + "mark" + shtml + "?id2=" + m + "&id=" + id + "&reply_u=" + val + "&mid=" + mid;
}

function turnmark(m) {
	document.getElementById("mark" + m).style.display = "none";
}

function show(val) {
	if (document.getElementById("ms")) return;
	var mess = document.createElement("div");
	mess.id = "ms";
	if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0") {
		mess.style.cssText = "position:absolute;left:" + eval(document.documentElement.scrollLeft + (window.screen.availWidth - 320) / 2) + "px;top:" + eval(document.documentElement.scrollTop + (window.screen.availHeight - 70) / 2) + "px;z-index:99;width:300px;height:70px;border:10px solid rgba(0,0,0,0.3);border-radius:4px;background-clip:padding-box;background-color:#f5f5f5;";
	} else {
		mess.style.cssText = "position:fixed;left:50%;top:50%;margin-left:-150px;margin-top:-35px;z-index:99;width:300px;height:70px;border:10px solid rgba(0,0,0,0.3);border-radius:4px;background-clip:padding-box;background-color:#f5f5f5;";
	}
	mess.innerHTML = '<div align="right" style="height:14px;font-size:14px">' + '<span style="cursor:pointer;" onclick="document.getElementById(\'ms\').parentNode.removeChild(document.getElementById(\'ms\'));"><img style="margin-top:2px;margin-right:4px;" border="0" src="' + rooturl + '/Public/images/close.gif"></span>' + '</div>' + '<div style="width:280px;height:40px;margin-left:10px;margin-top:2px;overflow:hidden">' + '<textarea id="ta" placeholder="向 ' + val + ' 发送短消息" style="float:left;width:230px;width:200px\9;_width:200px;height:40px;border:none;background:#e9e6e6;resize:none;overflow:hidden"></textarea>' + '<div style="width:40px;height:40px;background:#1c7bc5;color:#fff;text-align:center;float:left;margin-left:4px;font-size:13px;">' + '<span onclick="send(\'' + val + '\',document.getElementById(\'ta\').value)" style="position:relative;top:12px;cursor:pointer">发送</span>' + '</div>' + '</div>';
	document.body.appendChild(mess);
}

function send(val, tc) {
	xmlhttp.open("POST", rooturl + "/index.php/Message" + url + "send" + shtml, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("mto=" + val + "&mcon=" + tc);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			alert(xmlhttp.responseText);
		}
	}
}

function vote_stack(e, val, bz, val2, types) {
	types = typeof(types) == "undefined" ? '' : types;
	val2 = typeof(val2) == "undefined" ? '' : val2;
	e = e || window.event;
	if (bz == 1) {
		e.target.style.backgroundPosition = '0 0';
	}
	if (bz == 2) {
		e.target.style.backgroundPosition = '-100px 0';
	}
	xmlhttp.open("POST", rooturl + "/index.php/Laud" + url + "dolaud" + shtml, true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("tid=" + val + "&bz=" + bz + "&val2=" + val2 + "&types=" + types);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			setTimeout(function() {
				if (bz == 1) {
					e.target.style.backgroundPosition = '-28px 0';
				}
				if (bz == 2) {
					e.target.style.backgroundPosition = '-75px 0';
				}
			}, 1000)
			if (xmlhttp.responseText == 'success') {
				var target_span = e.target.parentNode.getElementsByTagName("span")[0];
				var target_div = e.target.parentNode.getElementsByTagName("div")[0];
				if (bz == 1) {
					target_span.innerHTML = parseInt(target_span.innerHTML) + 1;
					target_div.innerHTML = '帖子作者金币+1';
				}
				if (bz == 2) {
					target_span.innerHTML = parseInt(target_span.innerHTML) - 1;
					target_div.innerHTML = '帖子作者金币-1';
				}
				target_div.style.background = '#59b61d';
				target_div.style.visibility = 'visible';
				setTimeout(function() {
					target_div.style.visibility = 'hidden';
				}, 2000);
			} else {
				var target_div = e.target.parentNode.getElementsByTagName("div")[0];
				target_div.innerHTML = xmlhttp.responseText;
				target_div.style.background = '#c04848';
				target_div.style.visibility = 'visible';
				setTimeout(function() {
					target_div.style.visibility = 'hidden';
				}, 2000);
			}
		}
	}
}

function set_dialog_display(author, sessionuser, id2, num2) {
	var radio = document.getElementsByName("select_action");
	for(i=0; i<radio.length; i++) {
  	radio[i].checked = false;
  }
  document.getElementById('dia_hd').value = '';
	document.getElementById('Dialog').style.display = 'block';
	document.getElementById('dia_con_1').style.display = 'block';
	document.getElementById('dia_con_2').style.display = 'none';
	document.getElementById('dia_con_3').style.display = 'none';
	document.getElementById('dia_2').value = '';
	document.getElementById('dia_3').value = '';
	document.getElementById('jbyh').innerHTML = author;
	document.getElementById('jbyh_hd').value = author;
	if (typeof(id2) == 'undefined') {
		document.getElementById('jburl').value = window.location.href;
	} else {
		document.getElementById('jburl').value = window.location.href + "#p" + num2;
	}
	if (typeof(sessionuser) != 'undefined' && (author == sessionuser)) {
		document.getElementById('select_action_1').style.display  = 'none';
	} else {
		document.getElementById('select_action_1').style.display  = 'inline-block';
	}
	if (typeof(id2) == 'undefined') {
		document.getElementById('select_action_2').style.visibility  = 'hidden';
	} else {
		document.getElementById('select_action_2').style.visibility  = 'visible';
		document.getElementById('rid').value = id2;
	}
}

function do_action() {
	if (document.getElementById('dia_2').value == 1) {
		document.forms['dia_form'].action = rooturl + "/index.php/Content" + url + "doJubao" + shtml;
		document.forms['dia_form'].submit();
		return;
	}
	if (document.getElementById('dia_3').value == 1) {
		document.forms['dia_form'].action = rooturl + "/index.php/Content" + url + "delreply" + shtml;
		document.forms['dia_form'].submit();
		return;
	}
	if (document.getElementById('dia_hd').value == '1') {
		document.getElementById('dia_con_2').style.display = 'block';
		document.getElementById('dia_con_1').style.display = 'none';
		document.getElementById('dia_con_3').style.display = 'none';
		document.getElementById('dia_2').value = 1;
		document.getElementById('dia_3').value = '';
	}
	if (document.getElementById('dia_hd').value == '2') {
		document.getElementById('dia_con_3').style.display = 'block';
		document.getElementById('dia_con_1').style.display = 'none';
		document.getElementById('dia_con_2').style.display = 'none';
		document.getElementById('dia_2').value = '';
		document.getElementById('dia_3').value = 1;
	}
}