var x1 = 0,
y1 = 0,
x2 = 0,
y2 = 0;
 (function() {
    function MoveDiv()
    {
        this.move = function(dom, json) {
            if (((json.y2 - json.y1) / (json.x2 - json.x1) > 0) && (json.y2 - json.y1) > 0 && (json.x2 - json.x1) > 0)
            {
                this.freemoveRightDown(dom, json);
            }
            if (((json.y2 - json.y1) / (json.x2 - json.x1) < 0) && (json.y2 - json.y1) < 0 && (json.x2 - json.x1) > 0)
            {
                this.freemoveRightTop(dom, json);
            }
            if (((json.y2 - json.y1) / (json.x2 - json.x1) > 0) && (json.y2 - json.y1) < 0 && (json.x2 - json.x1) < 0)
            {
                this.freemoveLeftTop(dom, json);
            }
            if (((json.y2 - json.y1) / (json.x2 - json.x1) < 0) && (json.y2 - json.y1) > 0 && (json.x2 - json.x1) < 0)
            {
                this.freemoveleftDown(dom, json);
            }
            if (json.y2 - json.y1 == 0 && json.x2 - json.x1 > 0)
            {
                this.freemoveHright(dom, json);
            }
            if (json.y2 - json.y1 == 0 && json.x2 - json.x1 < 0)
            {
                this.freemoveHleft(dom, json);
            }
            if (json.y2 - json.y1 > 0 && json.x2 - json.x1 == 0)
            {
                this.freemoveVleft(dom, json);
            }
            if (json.y2 - json.y1 < 0 && json.x2 - json.x1 == 0)
            {
                this.freemoveVright(dom, json);
            }
        }
    }
    MoveDiv.prototype = {
        freemoveVright: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) - (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._otop < _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        freemoveVleft: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) + (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._otop > _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        freemoveHleft: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) - (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft < _this._o.x2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        freemoveHright: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) + (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft > _this._o.x2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        //右下情况 有效.
        freemoveRightDown: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            this.rotation = Math.atan((this._o.y2 - this._o.y1) / (this._o.x2 - this._o.x1)) * 180 / Math.PI;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) + Math.sin(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) + Math.cos(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft > _this._o.x2 || _this._otop > _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        //左上情况 有效.
        freemoveLeftTop: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            this.rotation = Math.atan((this._o.y2 - this._o.y1) / (this._o.x2 - this._o.x1)) * 180 / Math.PI;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) - Math.sin(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) - Math.cos(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft < _this._o.x2 || _this._otop < _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        //右上情况 有效.
        freemoveRightTop: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            this.rotation = Math.atan((this._o.y2 - this._o.y1) / (this._o.x2 - this._o.x1)) * 180 / Math.PI;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) + Math.sin(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) + Math.cos(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft > _this._o.x2 || _this._otop < _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        },
        //左下情况 有效.
        freemoveleftDown: function(dom, json) {
            this._dom = dom;
            this._o = json;
            this._oleft = this._o.x1;
            this._otop = this._o.y1;
            this.speed = 4;
            this.rotation = Math.atan((this._o.y2 - this._o.y1) / (this._o.x2 - this._o.x1)) * 180 / Math.PI;
            var _this = this;
            var int = setInterval(
            function() {
                _this._oleft = parseFloat(_this._oleft) - Math.sin(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.left = _this._oleft + "px";
                _this._otop = parseFloat(_this._otop) - Math.cos(Math.PI / 2 - _this.rotation * Math.PI / 180) * (_this.speed);
                _this._dom.style.top = _this._otop + "px";
                if (_this._oleft < _this._o.x2 || _this._otop > _this._o.y2)
                {
                    int = window.clearInterval(int);
                }
            },
            5);
        }
    }
    var document = window.document;
    var Drag = function(callback, activeDom, dragDom) {
        this.url = callback;
        this.mousedownHandle = this.getMousedownHandle();
        this.mousemoveHandle = this.getMousemoveHandle();
        this.mouseupHandle = this.getMouseupHandle();
        this.bind(activeDom, dragDom);
    }
    Drag.prototype = {
        bind: function(activeDom, dragDom) {
            if (!activeDom) return;
            dragDom = dragDom || activeDom;
            activeDom.style.cursor = 'move';
            this.activeDom = activeDom;
            this.dragDom = dragDom;
            return this;
        },
        start: function() {
            this.listenEvent(this.activeDom, 'mousedown', this.mousedownHandle);
        },
        getMousedownHandle: function() {
            _this = this;
            return function(e) {
                e = e || window.event;
                var srcObj = e.srcElement || e.target;
                if (srcObj.tagName.toLowerCase() != "img")
                {
                _this.dx = e.clientX - _this.dragDom.offsetLeft;
                _this.dy = e.clientY - _this.dragDom.offsetTop;
                x1 = _this.dragDom.offsetLeft;
                y1 = _this.dragDom.offsetTop;
                _this.listenEvent(document, 'mousemove', _this.mousemoveHandle);
                _this.listenEvent(document, 'mouseup', _this.mouseupHandle);
                _this.agency = _this.agency || _this.dragDom.cloneNode(false);
                _this.agency.style.background = 'none';
                _this.agency.style.border = '1px dashed #ccc';
                _this.agency.style.left = e.clientX - _this.dx + 'px';
                _this.agency.style.top = e.clientY - _this.dy + 'px';
                _this.agency.style.zIndex = "999999";
                document.body.appendChild(_this.agency);
                _this.preventDefault(e);
              }else{
                    document.getElementById("bg").parentNode.removeChild(document.getElementById("bg"));
                    document.getElementById("Tip").parentNode.removeChild(document.getElementById("Tip"));
                    //document.body.removeChild(_this.agency);
                    if (_this.url != undefined && _this.url != '')
                    {
                        eval(_this.url)();
                    }
                }
            }
        },
        getMousemoveHandle: function() {
            _this = this;
            return function(e) {
                e = e || window.event;
                _this.setPosition(e.clientX - _this.dx, e.clientY - _this.dy);
                _this.preventDefault(e);
            }
        },
        getMouseupHandle: function() {
            _this = this;
            return function(e) {
                e = e || window.event;
                //   _this.dragDom.style.left = _this.agency.offsetLeft+'px';
                //   _this.dragDom.style.top = _this.agency.offsetTop+'px';
                x2 = _this.agency.offsetLeft;
                y2 = _this.agency.offsetTop;
                var movediv = new MoveDiv();
                movediv.move(_this.dragDom, {
                    x1: x1,
                    y1: y1,
                    x2: x2,
                    y2: y2
                });
                _this.removeEventListen(document, 'mousemove', _this.mousemoveHandle);
                _this.removeEventListen(document, 'mouseup', _this.mouseupHandle);
                document.body.removeChild(_this.agency);

            }
        },
        setPosition: function(x, y) {
            _this.agency.style.left = x + 'px';
            _this.agency.style.top = y + 'px';
        },
        listenEvent: function(dom, evtType, callback) {
            if (window.addEventListener) {
                dom.addEventListener(evtType, callback, false);
            } else {
                dom.attachEvent('on'.concat(evtType), callback);
            }
        },
        removeEventListen: function(dom, evtType, callback) {
            if (window.removeEventListener) {
                dom.removeEventListener(evtType, callback, false);
            } else {
                dom.detachEvent('on'.concat(evtType), callback);
            }
        },
        preventDefault: function(e) {
            //非IE
            if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
            } else {
                //IE
                e.cancelBubble = true;
                e.returnValue = false;
            }
        }
    }
    window.Drag = Drag;
    //局部对象换成全局对象
})();
function jump(cal)
 {
    parent.document.getElementById('bg').parentNode.removeChild(parent.document.getElementById('bg'));
    parent.document.getElementById('Tip').parentNode.removeChild(parent.document.getElementById('Tip'));
   /* if (cal == 1) {
        //	cal="function(){window.location.href='http://www.youyax.com'}";
        eval("(function(){window.location.href='" + rooturl + "'})();");
    }*/
}
function Tip(str, pos, callback)
 {
    var bg = document.createElement("div");
    bg.id = "bg";
    var w = document.body.clientWidth + "px";
    var h = (document.body.scrollHeight > document.documentElement.scrollHeight ? document.body.scrollHeight: document.documentElement.scrollHeight) + "px";
    bg.style.cssText = "width:" + w + "; height:" + h + "; background:#333333;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;position:absolute;left:0;top:0;z-index:998";
    document.body.appendChild(bg);
    var tip = document.createElement("div");
    tip.id = "Tip";
    var w1 = (window.screen.availWidth - 300) / 2 + "px";
    var h1 = (window.screen.availHeight - 180) / 2 + "px";
    if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0"){ 
    	tip.style.cssText = "width:300px; height:180px; background-color:#ffffff;overflow:hidden;position:absolute;z-index:999;left:" + eval(document.documentElement.scrollLeft+(window.screen.availWidth - 300) / 2) + "px;top:" + eval(document.documentElement.scrollTop+(window.screen.availHeight - 180) / 2)+"px";
    }else{
    	tip.style.cssText = "width:300px; height:180px; background-color:#ffffff;overflow:hidden;position:fixed;z-index:999;left:" + w1 + ";top:" + h1;
    }
    switch (pos)
    {
        case 1:
        tip.innerHTML = '<div align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img  id="im" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
        '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") 0px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
        break;
        case 2:
        tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
        '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -47px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
        break;
        case 3:
        tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
        '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -94px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
        break;
        case 4:
        tip.innerHTML = '<div  align="left" id="TipTop" style="height:30px;line-height:30px;background-color:#f7f7fa;"><span style="float:left;margin-left:4px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>友情提示</b></span><img id="im" style="float:right;margin-top:8px;margin-right:4px;cursor:pointer" src="' + rooturl + '/Public/images/close.png"></div>' + 
        '<div style="padding-left:20px;padding-top:48px;"><div style=\'float:left;width:47px;height:46px;background:url("' + rooturl + '/Public/images/pic.jpg") -141px 0px no-repeat \'></div><div id="TipMsg" style="height:46px;font-weight:bold;font-size:16px;float:left;margin-left:2px;"><table width="100%" height="46" border="0"><tr><td>' + str + '</td></tr></table></div></div>';
        break;
    }
    document.body.appendChild(tip);
    var drag = new Drag(callback);
    drag.bind(document.getElementById('TipTop'), document.getElementById('Tip'));
    drag.start();
}