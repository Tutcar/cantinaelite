window.onload = e => {
	"use strict";
	const login = document.querySelector(".login");

	document.getElementById("log").onclick = e => {
		login.style.transform = "translateY(-100%)";
	};
	document.getElementById("reg").onclick = e => {
		login.style.transform = "translateY(0)";
	};

};
