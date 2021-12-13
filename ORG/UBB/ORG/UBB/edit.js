//made by xujinliang
var global_web_editor_obj;
function web_editor(json) {
    this.json = json;
    this.txt = '';
    this.$ = function(o) {
        document.getElementById(o).bind = function(actions, fun) {
            if (document.all) {
                this.attachEvent("on" + actions, 
                function(event) {
                    fun.call(this)
                });
            }
            else {
                this.addEventListener(actions, fun);
            }
        };
        return document.getElementById(o);
    };
}
function activeFun(json) {
    var _this = this;
    _this.$("web_editor_con2").style.display = "block";
    _this.$("web_editor_family").bind("mouseover", 
    function() {
        _this.over();
    });
    _this.$("web_editor_family_select").bind("change", 
    function() {
        _this.onfont(_this.$("web_editor_family_select").value);
        _this.$("web_editor_family_select").value = '';
    });
    _this.$("web_editor_font").bind("mouseover", 
    function() {
        _this.over();
    });
    _this.$("web_editor_font_select").bind("change", 
    function() {
        _this.onfontsize(_this.$("web_editor_font_select").value);
        _this.$("web_editor_font_select").value = '';
    });
    _this.$("web_editor_bold").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_bold").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_bold").bind("click", 
    function() {
        _this.onbold();
    });
    _this.$("web_editor_tilt").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_tilt").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_tilt").bind("click", 
    function() {
        _this.ontilt();
    });
    _this.$("web_editor_under").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_under").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_under").bind("click", 
    function() {
        _this.onunder();
    });
    _this.$("web_editor_color").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_color").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.colordiv(event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_face").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_face").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.facediv(json, event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_img").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_img").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.onimg(json, event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_url").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_url").bind("click", 
    function(e) {
    		var event = e || window.event;
        _this.onurl(event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_music").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_music").bind("click", 
    function(e) {
    		var event = e || window.event;
        _this.onmusic(event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_flash").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_flash").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.onflash(event);
        global_web_editor_obj = _this;
    });
    _this.$("web_editor_code").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_code").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.codediv(json, event);
        global_web_editor_obj = _this;
    });
    
    _this.$("web_editor_con2").bind("blur", 
    function() {
        _this.onassign();
    });
    _this.$("web_editor_con2").bind("mousemove", 
    function() {
        _this.onassign();
    });
    _this.$("web_editor_about").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.onabout(event);
    });
     _this.$("web_editor_indent").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_indent").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_indent").bind("click", 
    function() {
        _this.onindent();
    });
     _this.$("web_editor_left").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_left").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_left").bind("click", 
    function() {
        _this.onalignleft();
    });
 _this.$("web_editor_center").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_center").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_center").bind("click", 
    function() {
        _this.onaligncenter();
    });
 _this.$("web_editor_right").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();
    });
    _this.$("web_editor_right").bind("mouseout", 
    function() {
        _this.out();
    });
    _this.$("web_editor_right").bind("click", 
    function() {
        _this.onalignright();
    });
    _this.$("web_preview").bind("click", 
    function() {
        _this.onpreview();
    });
}
web_editor.prototype = {
    over: function() {
        if (document.all) {
            if (document.selection && document.selection.createRange().parentElement().name == 'content_textarea')
            {
                this.txt = document.selection.createRange();
            }
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            this.txt = obj.value.substring(startPos, endPos);
        }
    },
    out: function() {
        this.txt = '';
    },
    focusin: function() {
        this.$("web_editor_con2").focus();
    },
    onbold: function() {
        if (document.all) {
            this.txt.text = '[b]' + this.txt.text + '[/b]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[b]' + this.txt + '[/b]') + obj.value.substring(endPos);
        }
    },
    ontilt: function() {
        if (document.all) {
            this.txt.text = '[i]' + this.txt.text + '[/i]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[i]' + this.txt + '[/i]') + obj.value.substring(endPos);
        }
    },
    onunder: function() {
        if (document.all) {
            this.txt.text = '[u]' + this.txt.text + '[/u]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[u]' + this.txt + '[/u]') + obj.value.substring(endPos);
        }
    },
    onfont: function(value) {
        if (document.all) {
            this.txt.text = "[face=" + value + "]" + this.txt.text + "[/face]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[face=" + value + "]" + this.txt + "[/face]") + obj.value.substring(endPos);
        }
    },
    onfontsize: function(value) {
        if (document.all) {
            this.txt.text = "[size=" + value + "]" + this.txt.text + "[/size]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[size=" + value + "]" + this.txt + "[/size]") + obj.value.substring(endPos);
        }
    },
    oncolor: function(value) {
        if (document.all) {
            this.txt.text = "[color=" + value + "]" + this.txt.text + "[/color]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[color=" + value + "]" + this.txt + "[/color]") + obj.value.substring(endPos);
        }
    },
    onimage: function(value) {
        if (document.all) {
            this.txt.text = "[img=" + this.json.host + "/ORG/UBB/image/face/" + value + ".gif][/img]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            obj.value = obj.value.substring(0, startPos) + "[img=" + this.json.host + "/ORG/UBB/image/face/" + value + ".gif][/img]" + obj.value.substring(startPos);
        }
        this.onassign();
    },
    onimg: function(json, event) {
        if (!document.getElementById("simg"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "simg");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "362px";
            mydiv.style.height = "150px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "100";
            mydiv.innerHTML = '<div id="imgwrapper">' + 
            '<div class="editortop" align="right" style="width:100%;height:20px;"><span onclick="var cdiv=document.getElementById(\'simg\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:13px;color:#000000;cursor:pointer"><img style="margin-top:2px;margin-right:4px;" border="0" src="'+rooturl+'/Public/images/close.gif"></span></div>' + 
            '<div style="width:100%;height:130px;padding:4px;">' + 
            '<label style="font-size:13px;margin-bottom: 20px;display: block;">上传图片(最大5MB，JPG、JPEG、GIF或PNG文件)</label>' + 
            '<form style="margin-bottom: 10px;" name="formlocalimg" action="' + json.host + '/ORG/UBB/UploadForEditor.class.php" method="post" enctype="multipart/form-data" target="file_frame">' + 
            '<input type="file" name="file" style="width:300px;height:24px;"><span style="text-align:center;margin-left:10px;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;" onclick="formlocalimg.submit()">上传</span><br>' + 
            '<iframe name="file_frame" style="display:none;"></iframe>' + 
            '</form>' + 
            '<label style="font-size:13px;margin-bottom:10px;display: block;">网络图片地址</label>' + 
            '<input type="text" id="onlineimg" placeholder="请输入正确的图片格式" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:300px;height:24px;"><span style="text-align:center;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;position:relative;left:10px;*top:-3px;" onclick="global_web_editor_obj.ononlineimg(document.getElementById(\'onlineimg\').value)">插入</span>' + 
            '</div>' + 
            '</div>';
            document.body.appendChild(mydiv);
        }
    },
    ononlineimg: function(value) {
        if (value != "" && value != null)
        {
            if (document.all) {
                this.txt.text = "[img=" + value + "][/img]";
            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[img=" + value + "][/img]" + obj.value.substring(startPos);
            }
        }
    },
    onurl:function(event){
    	if (!document.getElementById("ssurl"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "ssurl");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "362px";
            mydiv.style.height = "80px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "100";
            mydiv.innerHTML = '<div>' + 
            '<div class="editortop" align="right" style="width:100%;height:20px;"><span onclick="var cdiv=document.getElementById(\'ssurl\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:13px;color:#000000;cursor:pointer"><img style="margin-top:2px;margin-right:4px;" border="0" src="'+rooturl+'/Public/images/close.gif"></span></div>' + 
            '<div style="padding:3px"><label style="font-size:13px;margin-bottom:10px;display: block;">添加超链接</label>' + 
            '<input type="text" id="onlineurl" placeholder="请输入正确的超链接地址" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:300px;height:24px;">'+
            '<span style="text-align:center;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;position:relative;left:10px;*top:-3px;" onclick="global_web_editor_obj.onurldeal({url:document.getElementById(\'onlineurl\').value})">插入</span></div>' + 
            '</div>';
            document.body.appendChild(mydiv);
        }
    },
    onurldeal:function(jurl) {
        if (jurl.url != "" && jurl.url != null)
        {
            if (document.all) {
                this.txt.text = "[url=" + jurl.url + "]" + this.txt.text + "[/url]";
            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                var endPos = obj.selectionEnd;
                if (this.txt == "" && this.txt != null)
                this.txt = jurl.url;
                obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[url=" + jurl.url + "]" + this.txt + "[/url]") + obj.value.substring(endPos);
            }
        }
    },
    onmusic:function(event){
    	if (!document.getElementById("smusic"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "smusic");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "362px";
            mydiv.style.height = "80px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "100";
            mydiv.innerHTML = '<div>' + 
            '<div class="editortop" align="right" style="width:100%;height:20px;"><span onclick="var cdiv=document.getElementById(\'smusic\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:13px;color:#000000;cursor:pointer"><img style="margin-top:2px;margin-right:4px;" border="0" src="'+rooturl+'/Public/images/close.gif"></span></div>' + 
            '<div style="padding:3px"><label style="font-size:13px;margin-bottom:10px;display: block;">网络音频地址</label>' + 
            '<input type="text" id="onlinemusic" placeholder="请输入正确的MP3格式" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:300px;height:24px;">'+
            '<span style="text-align:center;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;position:relative;left:10px;*top:-3px;" onclick="global_web_editor_obj.onmusicdeal({url:document.getElementById(\'onlinemusic\').value})">插入</span></div>' + 
            '</div>';
            document.body.appendChild(mydiv);
        }
    },
    onmusicdeal:function(jmusic) {
        if (jmusic.url != "" && jmusic.url != null)
        {
            if (document.all) {
                this.txt.text = "[music=" + jmusic.url + "]" + this.txt.text + "[/music]";
            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[music=" + jmusic.url + "][/music]" + obj.value.substring(startPos);
            }
        }
    },
    onflashdeal:function(jflash){
        if (jflash.url != "" && jflash.url != null)
        {
            if (document.all) {
                this.txt.text = "[video=" + jflash.url + " width="+jflash.w+" height="+jflash.h+"]" + this.txt.text + "[/video]";
            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[video=" + jflash.url + " width="+jflash.w+" height="+jflash.h+"][/video]" + obj.value.substring(startPos);
            }
        }
    },
    onflash:function(event) {
    	if (!document.getElementById("sflash"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "sflash");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "362px";
            mydiv.style.height = "80px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "100";
            mydiv.innerHTML = '<div>' + 
            '<div class="editortop" align="right" style="width:100%;height:20px;"><span onclick="var cdiv=document.getElementById(\'sflash\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:13px;color:#000000;cursor:pointer"><img style="margin-top:2px;margin-right:4px;" border="0" src="'+rooturl+'/Public/images/close.gif"></span></div>' + 
            '<div style="padding:3px"><label style="font-size:13px;margin-bottom:10px;display: block;">网络视频地址</label>' + 
            '<input type="text" id="onlineflash" placeholder="请输入正确的视频地址" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:200px;height:24px;">'+
            '<input type="text" id="onlineflashwidth" placeholder="宽度" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:40px;height:24px;margin-left:10px;">'+
            '<input type="text" id="onlineflashheight" placeholder="高度" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:40px;height:24px;margin-left:10px;">'+
            '<span style="text-align:center;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;position:relative;left:6px;*top:-3px;" onclick="global_web_editor_obj.onflashdeal({url:document.getElementById(\'onlineflash\').value,w:document.getElementById(\'onlineflashwidth\').value,h:document.getElementById(\'onlineflashheight\').value})">插入</span></div>' + 
            '</div>';
            document.body.appendChild(mydiv);
        }
    },
    onassign: function() {
        this.$("content").value = this.$("web_editor_con2").value;
    },
    onindent: function() {
        if (document.all) {
            this.txt.text = '[indent]' + this.txt.text + '[/indent]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[indent]' + this.txt + '[/indent]') + obj.value.substring(endPos);
        }
    },
    onalignleft: function() {
        if (document.all) {
            this.txt.text = '[left]' + this.txt.text + '[/left]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[left]' + this.txt + '[/left]') + obj.value.substring(endPos);
        }
    },
    onaligncenter: function() {
        if (document.all) {
            this.txt.text = '[center]' + this.txt.text + '[/center]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[center]' + this.txt + '[/center]') + obj.value.substring(endPos);
        }
    },
    onalignright: function() {
        if (document.all) {
            this.txt.text = '[right]' + this.txt.text + '[/right]';
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[right]' + this.txt + '[/right]') + obj.value.substring(endPos);
        }
    },
    onabout: function(event) {
        if (!document.getElementById("sabout"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "sabout");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.display = "table";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "99";
            mydiv.innerHTML = "<table cellspacing=0 cellpadding=0 border=0>" + 
            "<tr >" + 
            "<td class=\"editortop\" height=16 valign=top style=\"text-align:right;\"><span onclick=\"var cdiv = document.getElementById('sabout');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:13px;color:#000000;cursor:pointer\"><img style=\"margin-top:2px;margin-right:4px;\" border=\"0\" src=\""+rooturl+"/Public/images/close.gif\"></span></td>" + 
            "</tr >" + 
            "<tr >" + 
            "<td style=\"font-size:12px;font-weight:bold;line-height:20px;padding: 4px;\" valign=top align=left>名称：web-editor<br>用途：JavaScript社区编辑器<br>作者：YouYaX<br>描述：一款自主开发设计的UBB前端编辑器</td>" + 
            "</tr></table>";
            document.body.appendChild(mydiv);
        }
    },
    colordiv: function(event) {
        if (!document.getElementById("scolor"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "scolor");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
			 mydiv.style.display = "table";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "99";
            mydiv.innerHTML = "<table cellspacing=0 cellpadding=0 border=0 style=\"border-collapse:separate;border-spacing:6px\">" + 
            "<tr >" + 
            "<td colspan=8 style=\"text-align:right;\"><span onclick=\"var cdiv = document.getElementById('scolor');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:13px;color:#000000;cursor:pointer\"><img style=\"margin-top:2px;margin-right:4px;\" border=\"0\" src=\""+rooturl+"/Public/images/close.gif\"></span></td>" + 
            "</tr >" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#000000\" onclick=\"global_web_editor_obj.oncolor('#000000')\"></td>" + 
            "<td height=10 width=20  style=\"background:#333333\" onclick=\"global_web_editor_obj.oncolor('#333333')\"></td>" + 
            "<td height=10 width=20 style=\"background:#666666\" onclick=\"global_web_editor_obj.oncolor('#666666')\"></td>" + 
            "<td height=10 width=20  style=\"background:#999999\" onclick=\"global_web_editor_obj.oncolor('#999999')\"></td>" + 
            "<td height=10 width=20 style=\"background:#aaaaaa\" onclick=\"global_web_editor_obj.oncolor('#aaaaaa')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cccccc\" onclick=\"global_web_editor_obj.oncolor('#cccccc')\"></td>" + 
            "<td height=10 width=20 style=\"background:#f0f0f0\" onclick=\"global_web_editor_obj.oncolor('#f0f0f0')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffffff\" onclick=\"global_web_editor_obj.oncolor('#ffffff')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20  style=\"background:#000131\" onclick=\"global_web_editor_obj.oncolor('#000131')\"></td>" + 
            "<td height=10 width=20 style=\"background:#020064\" onclick=\"global_web_editor_obj.oncolor('#020064')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00019f\" onclick=\"global_web_editor_obj.oncolor('#00019f')\"></td>" + 
            "<td height=10 width=20 style=\"background:#0100c8\" onclick=\"global_web_editor_obj.oncolor('#0100c8')\"></td>" + 
            "<td height=10 width=20 style=\"background:#0002fc\" onclick=\"global_web_editor_obj.oncolor('#0002fc')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3134fa\" onclick=\"global_web_editor_obj.oncolor('#3134fa')\"></td>" + 
            "<td height=10 width=20 style=\"background:#9a99ff\" onclick=\"global_web_editor_obj.oncolor('#9a99ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cccdfb\" onclick=\"global_web_editor_obj.oncolor('#cccdfb')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#003500\" onclick=\"global_web_editor_obj.oncolor('#003500')\"></td>" + 
            "<td height=10 width=20 style=\"background:#006509\" onclick=\"global_web_editor_obj.oncolor('#006509')\"></td>" + 
            "<td height=10 width=20 style=\"background:#009d00\" onclick=\"global_web_editor_obj.oncolor('#009d00')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00cd07\" onclick=\"global_web_editor_obj.oncolor('#00cd07')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00ff00\" onclick=\"global_web_editor_obj.oncolor('#00ff00')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3cf93e\" onclick=\"global_web_editor_obj.oncolor('#3cf93e')\"></td>" + 
            "<td height=10 width=20 style=\"background:#96fa98\" onclick=\"global_web_editor_obj.oncolor('#96fa98')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cdffce\" onclick=\"global_web_editor_obj.oncolor('#cdffce')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#360000\" onclick=\"global_web_editor_obj.oncolor('#360000')\"></td>" + 
            "<td height=10 width=20 style=\"background:#680003\" onclick=\"global_web_editor_obj.oncolor('#680003')\"></td>" + 
            "<td height=10 width=20 style=\"background:#940100\" onclick=\"global_web_editor_obj.oncolor('#940100')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cc0002\" onclick=\"global_web_editor_obj.oncolor('#cc0002')\"></td>" + 
            "<td height=10 width=20 style=\"background:#f8000b\" onclick=\"global_web_editor_obj.oncolor('#f8000b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fa3b28\" onclick=\"global_web_editor_obj.oncolor('#fa3b28')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff9895\" onclick=\"global_web_editor_obj.oncolor('#ff9895')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffcbd1\" onclick=\"global_web_editor_obj.oncolor('#ffcbd1')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#363000\" onclick=\"global_web_editor_obj.oncolor('#363000')\"></td>" + 
            "<td height=10 width=20 style=\"background:#6e6102\" onclick=\"global_web_editor_obj.oncolor('#6e6102')\"></td>" + 
            "<td height=10 width=20 style=\"background:#a99200\" onclick=\"global_web_editor_obj.oncolor('#a99200')\"></td>" + 
            "<td height=10 width=20 style=\"background:#c2d200\" onclick=\"global_web_editor_obj.oncolor('#c2d200')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fff80a\" onclick=\"global_web_editor_obj.oncolor('#fff80a')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffff2b\" onclick=\"global_web_editor_obj.oncolor('#ffff2b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fff89b\" onclick=\"global_web_editor_obj.oncolor('#fff89b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fffcc2\" onclick=\"global_web_editor_obj.oncolor('#fffcc2')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#003335\" onclick=\"global_web_editor_obj.oncolor('#003335')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00666c\" onclick=\"global_web_editor_obj.oncolor('#00666c')\"></td>" + 
            "<td height=10 width=20 style=\"background:#009f9d\" onclick=\"global_web_editor_obj.oncolor('#009f9d')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00cecf\" onclick=\"global_web_editor_obj.oncolor('#00cecf')\"></td>" + 
            "<td height=10 width=20 style=\"background:#05feff\" onclick=\"global_web_editor_obj.oncolor('#05feff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3afefd\" onclick=\"global_web_editor_obj.oncolor('#3afefd')\"></td>" + 
            "<td height=10 width=20 style=\"background:#9affff\" onclick=\"global_web_editor_obj.oncolor('#9affff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ceffff\" onclick=\"global_web_editor_obj.oncolor('#ceffff')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#310034\" onclick=\"global_web_editor_obj.oncolor('#310034')\"></td>" + 
            "<td height=10 width=20 style=\"background:#620360\" onclick=\"global_web_editor_obj.oncolor('#620360')\"></td>" + 
            "<td height=10 width=20 style=\"background:#90039f\" onclick=\"global_web_editor_obj.oncolor('#90039f')\"></td>" + 
            "<td height=10 width=20 style=\"background:#db00ce\" onclick=\"global_web_editor_obj.oncolor('#db00ce')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff00fe\" onclick=\"global_web_editor_obj.oncolor('#ff00fe')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff30ff\" onclick=\"global_web_editor_obj.oncolor('#ff30ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff97ff\" onclick=\"global_web_editor_obj.oncolor('#ff97ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffccff\" onclick=\"global_web_editor_obj.oncolor('#ffccff')\"></td>" + 
            "</tr></table>";
            document.body.appendChild(mydiv);
        }
    },
    oncode: function(value) {
        if (document.all) {
            this.txt.text = "[code=" + value + "]" + this.txt.text + "[/code]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[code=" + value + "]" + this.txt + "[/code]") + obj.value.substring(endPos);
        }
    },
    codediv: function(json, event) {
    	if (!document.getElementById("scode"))
        {
            var mydiv3 = document.createElement("div");
            mydiv3.setAttribute("id", "scode");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv3.style.position = "absolute";
            mydiv3.style.left = w;
            mydiv3.style.top = h;
            mydiv3.style.width = "200px";
            mydiv3.style.height = "100px";
            mydiv3.style.border = "1px solid #e6e6e6";
            mydiv3.style.backgroundColor = "#ffffff";
            mydiv3.style.zIndex = "100";
            mydiv3.innerHTML = '<div style="width:200px;">' + 
            '<div class="editortop" align="right" style="width:100%;height:20px;"><span onclick="var cdiv=document.getElementById(\'scode\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:13px;color:#000000;cursor:pointer"><img style="margin-top:2px;margin-right:4px;" border="0" src="'+rooturl+'/Public/images/close.gif"></span></div>' + 
            '<div style="width:100%;height:100px;padding:6px;">' + 
            '<label style="font-size:14px;margin-bottom: 20px;display: block;">选择你要显示高亮的代码类型</label>' +  
            '<select id="codesel" style="width:100px;"><option value="">请选择类型</option>' +  
            '<option value="applescript">AppleScript</option>' +  
            '<option value="as3">ActionScript3</option>' +  
            '<option value="bash">bash / Shell</option>' +  
            '<option value="cf">Coldfusion</option>' +  
            '<option value="cpp">C++</option>' +  
            '<option value="c#">C#</option>' +  
            '<option value="css">Css</option>' +  
            '<option value="delphi">Delphi</option>' +  
            '<option value="diff">Diff</option>' +  
            '<option value="erlang">Erlang</option>' +  
            '<option value="groovy">Groovy</option>' +  
            '<option value="html">HTML / XML</option>' +  
            '<option value="java">Java</option>' +  
            '<option value="javafx">Javafx</option>' +  
            '<option value="js">JavaScript</option>' + 
            '<option value="perl">Perl</option>' +  
            '<option value="php">PHP</option>' + 
            '<option value="plain">Plain Text</option>' +  
            '<option value="powershell">PowerShell</option>' +  
            '<option value="python">Python</option>' +  
            '<option value="ruby">Ruby</option>' +  
            '<option value="sass">Sass</option>' +  
            '<option value="scala">Scala</option>' +  
            '<option value="sql">SQL</option>' +  
            '<option value="vb">VB</option>' +  
            '</select><span style="text-align:center;margin-left:10px;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;*position:relative;*top:-3px;" onclick="global_web_editor_obj.oncode(document.getElementById(\'codesel\').value)">确定</span>' + 
            '</div>' + 
            '</div>';
            document.body.appendChild(mydiv3);
        }
    },
    facediv: function(json, event) {
        if (!document.getElementById("sface"))
        {
            var mydiv2 = document.createElement("div");
            mydiv2.setAttribute("id", "sface");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv2.style.position = "absolute";
            mydiv2.style.left = w;
            mydiv2.style.top = h;
            mydiv2.style.width = "400px";
            mydiv2.style.height = "224px";
            mydiv2.style.border = "1px solid #e6e6e6";
            mydiv2.style.backgroundColor = "#ffffff";
            mydiv2.style.zIndex = "100";
            mydiv2.innerHTML = "<table width=400 height=210 border=0 cellspacing=0 cellpadding=0>" + 
            "<tr>" + 
            "<td class=\"editortop\" colspan=8 style=\"text-align:right;\"><span onclick=\"var cdiv = document.getElementById('sface');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:13px;color:#000000;cursor:pointer\"><img style=\"margin-top:2px;margin-right:4px;\" border=\"0\" src=\""+rooturl+"/Public/images/close.gif\"></span></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img onclick=\"global_web_editor_obj.onimage('00')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/00.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('01')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/01.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('02')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/02.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('03')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/03.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('04')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/04.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('05')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/05.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('06')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/06.gif'></td>" + 
            "<td><img   onclick=\"global_web_editor_obj.onimage('07')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/07.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img onclick=\"global_web_editor_obj.onimage('08')\"  width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/08.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('09')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/09.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('10')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/10.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('11')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/11.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('12')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/12.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('13')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/13.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('14')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/14.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('15')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/15.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('16')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/16.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('17')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/17.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('18')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/18.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('19')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/19.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('20')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/20.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('21')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/21.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('22')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/22.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('23')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/23.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('24')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/24.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('25')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/25.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('26')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/26.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('27')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/27.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('28')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/28.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('29')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/29.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('30')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/30.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('31')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/31.gif'></td>" + 
            "</tr>" + 
            "</table>";
            document.body.appendChild(mydiv2);
        }
    },
    onpreview: function() {
    	var xmlhttp;
		if (window.ActiveXObject){
		    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
		    xmlhttp = new XMLHttpRequest();
		}
		xmlhttp.open("POST", rooturl + "/index.php/List" + url + "preview" + shtml, true);
	    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    xmlhttp.send("data="+encodeURIComponent(this.$("web_editor_con2").value));
	    xmlhttp.onreadystatechange = function(){
	        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
	          if(!document.getElementById("preview_div")){
	        	var bheight = Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)+"px";
			    var bwidth = document.body.clientWidth + "px";
			    var bg = document.createElement("div");
			    bg.setAttribute("id","mbg");
			    bg.style.cssText = "position:absolute;left:0;top:0;width:"+bwidth+";height:"+bheight+";background:#333333;z-index:10;filter:alpha(opacity=90);-moz-opacity:0.9;opacity:0.9;";
			    document.body.appendChild(bg);
			    
	           var mydivpreview = document.createElement("div");
	           mydivpreview.setAttribute("id", "preview_div");
	           if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0"){ 
	           	mydivpreview.style.cssText = "position:absolute;left:" + eval(document.documentElement.scrollLeft+(window.screen.availWidth - 798) / 2) + "px;top:" + eval(document.documentElement.scrollTop+(window.screen.availHeight - 400) / 2) + "px;width:798px;height:400px;background-color:#f5f5f5;line-height: 26px;color:#333;border:5px solid #eee;box-shadow: 0 0 100px rgba(81, 203, 238, 1);border-radius:5px;background-clip:padding-box;z-index:9;display:block;overflow:hidden;padding-left:4px;padding-right:4px;z-index:11;font-size:14px;";
	            }else{
	           	mydivpreview.style.cssText = "position:fixed;top:50%;left:50%;margin-top:-200px;margin-left:-399px;width:798px;height:400px;background-color:#f5f5f5;line-height: 26px;color:#333;border:5px solid #eee;box-shadow: 0 0 100px rgba(81, 203, 238, 1);border-radius:5px;background-clip:padding-box;z-index:9;display:block;overflow-y:auto;padding-left:4px;padding-right:4px;z-index:11;font-size:14px;";
	           }
	           mydivpreview.innerHTML= xmlhttp.responseText;
	           document.body.appendChild(mydivpreview);
	           
	           document.getElementById('mbg').onclick=function(){
	           	var delObj = document.getElementById('preview_div');delObj.parentNode.removeChild(delObj);
	           	var delObj = document.getElementById('mbg');delObj.parentNode.removeChild(delObj);
	          		}
	           	}
	        }
	    }
    },
    create: function(json) {
        this.$(json.id).style.width = json.w + "px";
        this.$(json.id).innerHTML = '<div style="width:' + json.w + 'px;background:#f0f0ee;overflow:hidden;">' + 
        '<div  id="web_editor_title" style="display:table;width:100%;background-color: #fafafa;' + 
'background-image: -moz-linear-gradient(top, #ffffff, #f2f2f2);' + 
'background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#f2f2f2));' + 
'background-image: -webkit-linear-gradient(top, #ffffff, #f2f2f2);' + 
'background-image: -o-linear-gradient(top, #ffffff, #f2f2f2);' + 
'background-image: linear-gradient(to bottom, #ffffff, #f2f2f2);">' + 
        '<span id="web_editor_family">' + 
        '<select id="web_editor_family_select">' + 
        '<option value="">字体</option>' + 
        '<option value="宋体">宋体</option>' + 
        '<option value="黑体">黑体</option>' + 
        '<option value="隶书">隶书</option>' + 
        '<option value="楷体">楷体</option>' + 
        '<option value="华文新魏">华文新魏</option>' + 
        '<option value="Arial">Arial</option>' + 
        '<option value="Verdana">Verdana</option>' + 
        '<option value="Tahoma">Tahoma</option>' + 
        '</select>' + 
        '</span>' + 
        '<span id="web_editor_font">' + 
        '<select id="web_editor_font_select">' + 
        '<option value="">大小</option>' + 
        '<option value="12px">12</option>' + 
        '<option value="13px">13</option>' + 
        '<option value="14px">14</option>' + 
        '<option value="15px">15</option>' + 
        '<option value="16px">16</option>' + 
        '<option value="18px">18</option>' + 
        '<option value="24px">24</option>' + 
        '</select>' + 
        '</span>' + 
        '<span title="加粗" id="web_editor_bold" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat:no-repeat;background-position:8px 5px"></span>' + 
        '<span title="倾斜" id="web_editor_tilt" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-18px 5px"></span>' + 
        '<span title="下划线" id="web_editor_under" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-44px 5px"></span>' + 
        '<span title="颜色" id="web_editor_color" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-67px 5px"></span>' + 
        '<span title="首行缩进" id="web_editor_indent" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-370px 6px"></span>' + 
        '<span title="左对齐" id="web_editor_left" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-296px 6px"></span>' + 
        '<span title="居中" id="web_editor_center" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-323px 6px"></span>' + 
        '<span title="右对齐" id="web_editor_right" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-348px 6px"></span>' + 
        '<span title="超链接" id="web_editor_url" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-92px 6px"></span>' + 
        '<span title="表情" id="web_editor_face" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-116px 7px"></span>' + 
        '<span title="图片" id="web_editor_img" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-145px 6px"></span>' + 
        '<span title="音乐" id="web_editor_music" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-172px 6px"></span>' + 
        '<span title="视频" id="web_editor_flash" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-200px 6px"></span>' + 
        '<span title="代码" id="web_editor_code" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-247px 6px"></span>' +
        '<span title="预览" id="web_preview" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-270px 6px"></span>' + 
        '<span title="关于" id="web_editor_about" style="background-image:url(' + json.host + '/ORG/UBB/image/bg.gif);background-repeat: no-repeat;background-position:-224px 6px"></span>' + 
        '</div>' + 
        '<textarea id="web_editor_con2"  name="content_textarea" style="resize:vertical;height:' + json.h + 'px;"></textarea>' + 
        '<input type="hidden" name="content" id="content">' + 
        '</div>';
        activeFun.call(this, json);
    }
}
function web_editor_init(ID, W, H, HOST)
 {
    var json = {
        id: ID,
        w: W,
        h: H,
        host: HOST
    };
    var web_edit = new web_editor(json);
    web_edit.create(json);
}