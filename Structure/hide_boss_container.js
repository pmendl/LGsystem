function hide_boss_container(element)
{
	var auncle = element.parentNode.nextSibling;
	if (auncle != undefined) {
		if (auncle.hasAttribute("style")) {
			auncle.removeAttribute("style");
			set_svg(element, true); 
		} else {
			auncle.setAttribute("style","display: none");
			set_svg(element, false);
		}
	}
};

function set_svg(element, up)
{
	var polygon = element.firstElementChild.lastElementChild;
	if (polygon == undefined) {
	alert("undefined");
	return;
	}
//	alert("set_svg $this");
	if(up) {
		polygon.setAttribute("points","5,60 65,60 35,20");
	} else {
		polygon.setAttribute("points",points="5,20 65,20 35,60"); 
	}
};
