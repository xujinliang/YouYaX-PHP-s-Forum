function open_close_menu(e) {
	//event = e || window.event;
	//event.preventDefault();
	//var cn = document.getElementsByTagName("body")[0].className;
	var cn = document.body.className.replace(/\s*/g, '');
	if (cn == '') {
		//document.getElementsByTagName("body")[0].className = "nav-view";
		var callback = function() {
				//document.body.className = "nav-view";
				document.getElementById("navdrawer").style.display = "block";
				//document.getElementsByTagName("body")[0].removeEventListener('webkitTransitionEnd', callback);
				document.body.removeEventListener('webkitTransitionEnd', callback);
			}
		document.body.addEventListener('webkitTransitionEnd', callback);
		document.body.className = "nav-view";
		document.getElementById("mainsite").style.backgroundPosition = "10px -27px";
		//document.getElementsByTagName("body")[0].addEventListener('webkitTransitionEnd', callback);
		//		for (var i = 0; i <= 50; i++) {
		//        (function() {
		//            var mt = i;
		//            setTimeout(function() {
		//                document.getElementById("navdrawer").style.opacity = mt / 50;
		//              },(mt + 1) * 20)
		//            })();
		//          }
	} else {
		var callback_cancel = function() {
				document.getElementById("navdrawer").style.display = "none";
				document.body.removeEventListener('webkitTransitionEnd', callback_cancel);
			}
		document.body.addEventListener('webkitTransitionEnd', callback_cancel);
		document.body.className = "";
		document.getElementById("navdrawer").style.display = "none";
		document.getElementById("mainsite").style.backgroundPosition = "10px 8px";
	}
}
//document.onreadystatechange = function(){
//    if (document.readyState == "complete"){
/*		var startX,endX;
		var bn = navigator.userAgent;
		if(	!bn.match(/qqbrowser/i) && !bn.match(/uc/i) ){
			document.getElementById("touchpanel").addEventListener("touchstart", touchStart, false);
			document.getElementById("touchpanel").addEventListener("touchmove", touchMove, false);
			document.getElementById("touchpanel").addEventListener("touchend", touchEnd, false);
		}
		function touchStart(event) {
		    var touch = event.touches[0];
		    startX = Number(touch.pageX);
		}
		function touchMove(event) {
		    var touch = event.touches[0];
		    endX = Number(touch.pageX);
		}
		function touchEnd(event) {
			event.preventDefault();
		    if ((startX - endX) > 100) {
		    		//window.event.returnValue = false;
		        if(document.getElementsByTagName("body")[0].className == "nav-view"){
		        		open_close_menu(event);
		        }
		    } if ((startX - endX)< -100) {
		    		//window.event.returnValue = false;
		        if(document.getElementsByTagName("body")[0].className == ""){
		        		open_close_menu(event);
		        }
		    }
		}
*/
//	}
//}