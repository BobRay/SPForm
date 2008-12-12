var keysPressed = 0;
document.onkeypress = logKeys;
function logKeys() {
	keysPressed++;
	document.getElementById("keyCount").value = keysPressed;
}
