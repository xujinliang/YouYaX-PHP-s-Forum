function Tip2(str, pos, callback, relation)
{
    if (relation == 'parent')
    {
        var bg = parent.document.createElement("div");
        bg.id = "bg";
        var w = parent.document.body.clientWidth + "px";
        var h = (parent.document.body.scrollHeight > parent.document.documentElement.scrollHeight ? parent.document.body.scrollHeight: parent.document.documentElement.scrollHeight) + "px";
        bg.style.cssText = "width:" + w + "; height:" + h + "; background:#333333;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;position:absolute;left:0;top:0;z-index:998";
        parent.document.body.appendChild(bg);
        var tip = parent.document.createElement("div");
        tip.id = "Tip";
        var w1 = (parent.document.body.clientWidth - 300) / 2 + "px";
        var h1 = (window.screen.availHeight - 180) / 2 + "px";
        tip.style.cssText = "width:300px; height:180px; background-color:#ffffff;overflow:hidden;position:absolute;z-index:999;left:" + w1 + ";top:" + h1;
        switch (pos)
        {
            case 1:
            tip.innerHTML = '<div align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img  id="im" onclick="jump(' + callback + ');" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
            '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") 0px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
            break;
            case 2:
            tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" onclick="jump(' + callback + ');" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
            '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -47px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
            break;
            case 3:
            tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" onclick="jump(' + callback + ');" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
            '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -94px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
            break;
            case 4:
            tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" onclick="jump(' + callback + ');" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
            '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -141px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
            break;
        }
        parent.document.body.appendChild(tip);
    }
}