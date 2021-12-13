var state=0;
var prefun=function(){
	if(state==1){return;}
	state=1;
	var liset=document.getElementById("banner_ul").getElementsByTagName("li");
	for(var i=0;i<liset.length;i++){
	if(i<1){
		liset[i].style.opacity=1;
		liset[i].style.filter="alpha(opacity=100)";
		liset[i].style.MozOpacity=1;
	}else{
		liset[i].style.opacity=0;
		liset[i].style.filter="alpha(opacity=0)";
		liset[i].style.MozOpacity=0;
	}
}
var ele=liset[liset.length-1].cloneNode(true);
	for(var i=1;i<=100;i++)
	{
		(function(){
			var t=i;
			setTimeout(function(){
				liset[0].style.opacity=(100-t)/100;
				liset[0].style.filter="alpha(opacity=100-"+t+")";
				liset[0].style.MozOpacity=(100-t)/100;
				if(t==100)
				{
					ele.style.opacity='0';
					ele.style.filter="alpha(opacity=0)";
					ele.style.MozOpacity='0';
					document.getElementById("banner_ul").removeChild(liset[liset.length-1]);
					document.getElementById("banner_ul").insertBefore(ele,liset[0]);
					liset[0].style.marginLeft="0px";
								for(var _i=0;_i<=100;_i++)
								{
									(function(){
										var _ii=_i;
										setTimeout(function(){
											if(_ii==100){state=0;}
											ele.style.opacity=_ii/100;
											ele.style.filter="alpha(opacity="+_ii+")";
											ele.style.MozOpacity=_ii/100;
										},(_ii+1)*10)
									})()
								}
				}
		},(t+1)*10);
					})()
	}
}
var nextfun=function(){
	if(state==1){return;}
	state=1;
	var liset=document.getElementById("banner_ul").getElementsByTagName("li");
	for(var i=0;i<liset.length;i++){
	if(i<1){
		liset[i].style.opacity=1;
		liset[i].style.filter="alpha(opacity=100)";
		liset[i].style.MozOpacity=1;
	}else{
		liset[i].style.opacity=0;
		liset[i].style.filter="alpha(opacity=0)";
		liset[i].style.MozOpacity=0;
	}
}
var ele=liset[0].cloneNode(true);
	for(var i=1;i<=100;i++)
	{
		(function(){
			var t=i;
			setTimeout(function(){
				liset[0].style.opacity=(100-t)/100;
				liset[0].style.filter="alpha(opacity=100-"+t+")";
				liset[0].style.MozOpacity=(100-t)/100;
				if(t==100)
				{
					document.getElementById("banner_ul").removeChild(liset[0]);
					document.getElementById("banner_ul").appendChild(ele);
					liset[0].style.opacity='0';
								liset[0].style.filter="alpha(opacity=0)";
								liset[0].style.MozOpacity='0';
								for(var _i=0;_i<=100;_i++)
								{
									(function(){
										var _ii=_i;
										setTimeout(function(){
											if(_ii==100){state=0;}
											liset[0].style.opacity=_ii/100;
											liset[0].style.filter="alpha(opacity="+_ii+")";
											liset[0].style.MozOpacity=_ii/100;
										},(_ii+1)*10)
									})()
								}
				}
		},(t+1)*10);
					})()
	}
}
document.getElementById("prev").onclick=prefun;
document.getElementById("next").onclick=nextfun;
setInterval(nextfun,"6000");