var wrapper = document.getElementById("wrapper");
var banner = document.getElementById("banner");
var logoWrapper = document.getElementById("logowrapper");
var titleWrapper = document.getElementById("titlewrapper");
var accountWrapper = document.getElementById("accountwrapper");
var accountDropdown = document.getElementById("accountdropdown");
var dropdownContent = document.getElementsByClassName("dropdowncontent");
var main = document.getElementsByTagName("main")[0];
var antiShadow = document.getElementById("antishadow");
var shadow = document.getElementById("shadow");
var nav = document.getElementById("testnav");
var navsections = document.getElementsByClassName("navsection");

var activeNavSection = -1;

var accountDropdownActive = false;

var stylesheet = document.getElementById("stylesheet");
var pageWidth = window.innerWidth;
var pageHeight = window.innerHeight;

window.addEventListener("hashchange", updateUI);

$(document).ready(function(){
    var placeHolder = ["Search a language", "Search a location", "Search a company", "Search a name", "Search a skill"];
    var n=0;
    var loopLength=placeHolder.length;
    var searchbaritem = document.getElementById('searchbaritem');

    setInterval(function(){
       if(n<loopLength){
          var newPlaceholder = placeHolder[n];
          n++;
          $(searchbaritem).attr('placeholder',newPlaceholder);
       } else {
          $(searchbaritem).attr('placeholder',placeHolder[0]);
          n=0;
       }
    }, 3000);
});

function updateUI() {

	pageWidth = window.innerWidth;

	pageHeight = window.innerHeight;

	if (pageWidth > 640) {

        main.scrollTop = 0;

		let titleWidth = pageWidth - logoWrapper.offsetWidth - 110;
		let mainHeight = pageHeight - banner.offsetHeight;
		let mainWidth = pageWidth - 100;
		titleWrapper.style.width = titleWidth + "px";
		main.style.height = mainHeight + "px";
		main.style.width = mainWidth + "px";

		updateNavHeight();

		if (activeNavSection != -1) {
			updateDropdownHeight();
		}

	} else {

		stylesheet.href = "styles/mobile.css";

	}

	wrapper.style.display = "block";

};

function getRandomColor() {

	let runes = "0123456789ABCDEF";
	let color = "#";
	for (i = 0; i < 6; i++) {
		color += runes[Math.floor(Math.random() * 16)]
	}

	return color

};

function setBackgroundColor() {
	let color = getRandomColor();
    wrapper.style.backgroundColor = color;
};

function toggleDropdown(section) {
	
	if (section != -1) {
		
		if (dropdownContent[section].style.display == "block") {
			dropdownContent[section].style.display = "none";
			antiShadow.style.display = "none";
			activeNavSection = -1;
			navsections[section].style.backgroundColor = "#eee";
		} else {
			for (i = 0; i < dropdownContent.length; i++) {
				dropdownContent[i].style.display = "none";
				navsections[i].style.backgroundColor = "#eee";
			}
			dropdownContent[section].style.display = "block";
			antiShadow.style.display = "block";
			navsections[section].style.backgroundColor = "gold";
			activeNavSection = section;
			updateDropdownHeight();
		}
		
	} else {
		
		if (accountDropdown.style.display == "block") {
			accountDropdown.style.display = "none";
			accountWrapper.style.backgroundColor = "#fff";
			accountDropdownActive = false;
		} else {
			accountDropdown.style.display = "block";
			accountWrapper.style.backgroundColor = "gold";
			accountDropdownActive = true;
		}
		
	}

};

function updateDropdownHeight() {
    let mainHeight = main.offsetHeight;
    for (i = 0; i < dropdownContent.length; i++) {
		dropdownContent[i].style.height = mainHeight + "px";
    }
    shadow.style.height = mainHeight + "px";
};

function updateNavHeight() {
	let mainHeight = main.offsetHeight;
	let navHeight = mainHeight;
	nav.style.height = navHeight + "px";
};

function updateNav(section, hover) {
	if (activeNavSection == -1 || activeNavSection != section) {
		if (section != -2) {
            if (hover) {
                navsections[section].style.backgroundColor = "lavender";
            } else {
                navsections[section].style.backgroundColor = "#eee";
            }
		} else if (!accountDropdownActive) {
            if (hover) {
                accountWrapper.style.backgroundColor = "lavender";
            } else {
                accountWrapper.style.backgroundColor = "#fff";
            }
		}
	}
};

function showWageOptions() {
	let checkbox = document.getElementById("freelancer");
	let wageoptions = document.getElementById("wageoptions");
	if (checkbox.checked) {
		wageoptions.style.display = "block";
	} else {
		wageoptions.style.display = "none";
	}
};

function showSocialInput(site) {
	let checkbox = document.getElementById(site);
	let linkedininput = document.getElementById("linkedininput");
	let facebookinput = document.getElementById("facebookinput");
	let twitterinput = document.getElementById("twitterinput");
	let submitinput = document.getElementById("submitinput");
	if (site == "linkedin") {
		if (checkbox.checked == true) {
			linkedininput.style.display = "block";
			submitinput.style.display = "block";
		} else {
			linkedininput.style.display = "none";
			if (facebookinput.style.display == "none" && twitterinput.style.display == "none") {
				submitinput.style.display = "none";
			}
		};
	} else if (site == "facebook") {
		if (checkbox.checked == true) {
			facebookinput.style.display = "block";
			submitinput.style.display = "block";
		} else {
			facebookinput.style.display = "none";
			if (linkedininput.style.display == "none" && twitterinput.style.display == "none") {
				submitinput.style.display = "none";
			}
		};
	} else if (site == "twitter") {
		if (checkbox.checked == true) {
			twitterinput.style.display = "block";
			submitinput.style.display = "block";
		} else {
			twitterinput.style.display = "none";
			if (facebookinput.style.display == "none" && linkedininput.style.display == "none") {
				submitinput.style.display = "none";
			}
		};
	};
};

function incompleteMessage() {
	alert("This feature is unavailable in the beta release. Please check back later or contact support at support@thelotus.network if you have any questions.");
};
