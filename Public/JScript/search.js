var urls = window.location.href;
var url_array = urls.split("=");
var page = url_array.pop();
if (page != undefined){
  var uclass = document.getElementsByTagName("a");
  for (var n in uclass){
	  	if((uclass[n].className=='fy'+page) && (uclass[n].className != undefined)){
	      uclass[n].style.background = "#1c7bc5";
	      uclass[n].style.color = "#ffffff";
	    }
	}
}