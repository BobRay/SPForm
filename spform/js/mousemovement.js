var myInterval = window.setInterval(timedMousePos,250);
var xPos = -1;
var yPos = -1;
var firstX = -1;
var firstY = -1;
var intervals = 0;
function getMousePos(p) {
	if (!p) var p = window.event;
	if (p.pageX || p.pageY) {
		xPos = p.pageX;
		yPos = p.pageY;
	}	else if (p.clientX || p.clientY) {
		xPos = p.clientX + document.body.scrollLeft	+ document.documentElement.scrollLeft;
		yPos = p.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}
}

function timedMousePos() {
	document.onmousemove = getMousePos;
	if (xPos >= 0 && yPos >= 0) {
		var newX = xPos;
		var newY = yPos;
		intervals++;
	}
	if (intervals == 1) {
	  firstX = xPos;
  	firstY = yPos;
	} else if (intervals == 2) {
  	clearInterval(myInterval);
  	calcDistance(firstX,firstY,newX,newY);
  }
}
function calcDistance(aX,aY,bX,bY) {
	var mouseTraveled = Math.round(Math.sqrt(Math.pow(aX-bX,2)+Math.pow(aY-bY,2)));
	try	{
		document.getElementById("mouseTravel").value = mouseTraveled;
	}
	catch(excpt) { }
}
function dummy() {}