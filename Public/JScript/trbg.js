var trs = document.getElementById("lists").getElementsByTagName("tr");
for (var i = 0; i < trs.length; i++) {
    if (i % 2 == 1)
    trs[i].style.background = "#cbe0e5";
    if (i % 2 == 0)
    trs[i].style.background = "#ffffff";
}
var urls = window.location.href;
var url_array = urls.split("=");
var page = url_array[1];
if (page != undefined){
	var uclass = document.getElementsByTagName("a");
  for(var n=0;n<uclass.length;n++){
  	if((uclass[n].className=='fy'+page) && (uclass[n].className != undefined)){
      uclass[n].style.background = "#1c7bc5";
      uclass[n].style.color = "#ffffff";
    }
	}
}
document.getElementById("fxt").onmouseover = function() {
    if (document.getElementById("pop")) {
        document.getElementById("pop").style.display = "block";
        document.getElementById("pop").onmouseover = function() {
            this.style.display = "block";
        }
        document.getElementById("pop").onmouseout = function() {
            this.style.display = "none";
        }
    } else {
        var newchild = document.createElement("div");
        newchild.id = "pop";
        var w = getLeft(document.getElementById("fxt"));
        var h = getTop(document.getElementById("fxt")) + 32;
        newchild.style.cssText = "width:104px;height:60px;background:#fff;border:1px solid #ddd;box-shadow: 1px 2px 2px rgba(0,0,0,0.3);position:absolute;left:" + w + "px;top:" + h +"px";
        newchild.innerHTML = '<ul style="margin:0px 4px;padding:0px"><li style="list-style-type:none;width:100%;height:30px;line-height:30px"><a style="font-size:12px;"  href="' + rooturl_list + '/List' + url + 'fatie' + shtml + '">发表新帖</a></li><li style="list-style-type:none;width:100%;height:30px;line-height:30px"><a style="font-size:12px;"  href="' + rooturl_list + '/List' + url + 'vote' + shtml + '">发表投票</a></li></ul>';
        document.body.appendChild(newchild);
        document.getElementById("pop").style.display = "block";
        document.getElementById("pop").onmouseover = function() {
            this.style.display = "block";
        }
        document.getElementById("pop").onmouseout = function() {
            this.style.display = "none";
        }
    }
}
document.getElementById("fxt").onmouseout = function() {
    document.getElementById("pop").style.display = "none";
}