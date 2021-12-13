function Tree(data, el) {
    this.app=function(par,tag){return par.appendChild(document.createElement(tag))};
    this.create(document.getElementById(el),data)
};
Tree.prototype = {
    create: function (par,group){
        var host=this, length = group.length;
        for (var i = 0; i < length; i++) {
            var dl =this.app(par,'DL'), dt = this.app(dl,'DT'), dd = this.app(dl,'DD');
            var tmp=typeof(group[i]['url'])=="undefined"?"javascript:void(0)":group[i]['url'];
            dt.innerHTML='<a title="'+group[i]['t']+'" href='+tmp+'>'+group[i]['t']+'</a>';
            if (!group[i]['s'])continue;
            dt.group=group[i]['s'];
            dt.className+=" node-close";
            dt.onclick=function (e){
            	e = e || window.event;
   				var obj = e.target || e.srcElement;
				if(obj.tagName.toLowerCase() != "a"){
                var dd= this.nextSibling;
                if (!dd.hasChildNodes()){
                     host.create(dd,this.group);
                     this.className='node-open'
                 }else{
                    var set=dd.style.display=='none'?['','node-open']:['none','node-close'];
                     dd.style.display=set[0];
                     this.className=set[1]
                 }
               }
            }
        }
    }
};
var et=new Tree(data,'treediv');

var xmlhttp;
if (window.ActiveXObject) {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
} else {
    xmlhttp = new XMLHttpRequest()
}
  serverpage = rooturl + "/index.php/Folder" + url + "judge" + shtml;
    xmlhttp.open("GET", serverpage);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	 if(xmlhttp.responseText=='open'){
              var dts=document.getElementById("treediv").getElementsByTagName("dt");
			for(var i=0;i<dts.length;i++){
			if(document.all) {dts[i].click();}
			else {
			  	var e = document.createEvent("MouseEvents");
			  	e.initEvent("click", false, false);
			  	dts[i].dispatchEvent(e);
			  }
		    }
		 }
		  document.getElementById("treediv").style.display="block";
		  var w = (Math.max(document.body.clientWidth,document.documentElement.clientWidth)-960)/2 - 10;
			var wo = document.getElementById("treediv").offsetWidth;
			document.getElementById("treediv").style.width = Math.min(w,wo) + "px";
			document.getElementById("treediv").style.left = "-"+ (Math.min(w,wo)+10) + "px";

		   if(document.all){
               document.getElementById("treediv").style.filter = "0";
             }else{
               document.getElementById("treediv").style.opacity = "0";
             }
		   for (var i = 0; i <= 50; i++) {
		        (function() {
		            var mt = i;
		            setTimeout(function() {
		            	if(document.all){
		                document.getElementById("treediv").style.filter = "alpha(opacity=" + (2 * mt) + ")";
		              }else{
		                document.getElementById("treediv").style.opacity = mt / 50;
		              }
		            },
		            (mt + 1) * 10);
		        })();
		    }
      }
    }
  xmlhttp.send(null);