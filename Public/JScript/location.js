var getLeft = function(obj) {
		var offset = obj.offsetLeft;
		if (obj.offsetParent != null) offset += getLeft(obj.offsetParent);
		return offset;
	};
var getTop = function(obj) {
		var offset = obj.offsetTop;
		if (obj.offsetParent != null) offset += getTop(obj.offsetParent);
		return offset;
	};