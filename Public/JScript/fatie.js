function check() {
	var error = 0;
	var terror = 0;
	var cerror = 0;
	document.getElementById("sub").disabled = true;
	if (document.forms['form'].elements['title'].value == '') {
		document.getElementById("titerror").innerHTML = "标题不能为空";
		error = 1;
		terror = 1;
	} else {
		if ((document.forms['form'].title.value).indexOf(" ") == 0) {
			document.getElementById("titerror").innerHTML = '标题首字符不能为空！';
			error = 1;
			terror = 1;
		}
	}
	if (terror == 0) {
		document.getElementById("titerror").innerHTML = '';
	}
	if (document.forms['form'].elements['content'].value == '') {
		document.getElementById("conerror").innerHTML = "内容不能为空";
		error = 1;
		cerror = 1;
	}
	if (cerror == 0) {
		document.getElementById("conerror").innerHTML = '';
	}
	if (error == 0) {
		return true;
	} else {
		document.getElementById("sub").disabled = false;
		return false;
	}
}