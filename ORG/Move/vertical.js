function Move_vertical(id, h)
 {
    var o = document.getElementById(id);
    o.style.overflow = "hidden";
    var lies = o.getElementsByTagName("li");
    if(lies.length>0){
	    window.setInterval(function() {
	        scrollup(o, h, 0);
	    },
	    3000);
		}
}
function scrollup(o, d, c)
 {
    if (d == c)
    {
        var t = getFirstChild(o.firstChild).cloneNode(true);
        o.removeChild(getFirstChild(o.firstChild));
        o.appendChild(t);
        t.style.marginTop = "0px";

    }
    else
    {
        c += 2;
        getFirstChild(o.firstChild).style.marginTop = -c + "px";
        window.setTimeout(function() {
            scrollup(o, d, c)
        },
        20);

    }

}
function getFirstChild(node)
 {
    while (node.nodeType != 1)
    {
        node = node.nextSibling;

    }
    return node;

}