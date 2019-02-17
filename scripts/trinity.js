function UpdateUI(elementid) {
	element = document.getElementById(elementid);
	listitems = document.getElementsByClassName("listitem");
	for (i = 0; i < listitems.length; i++) {
		listitems[i].style.display = "none";
	};
	element.style.display = "block";
};