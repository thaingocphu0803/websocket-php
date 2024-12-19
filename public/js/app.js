"use strict";

const endpoint = "endpoint.php";
const pathname = location.pathname.toLowerCase();

//using to get to todo detail on edit.js
let todoId = null;
let todoStatus = null;
let receiver = null;
//generate socket connection

const socket = new WebSocket(`ws://localhost:9000`);

document.addEventListener("DOMContentLoaded", async () => {
	const response = await fetch(`/${endpoint}/check-login`, {
		method: "post",
	});
	const data = await response.json();

	if (!data.status) {
		Navigate("/login");
		return;
	}else{
		socket.onopen = () => {
			if (data.data.username) {		
				const message = {
					type: "userConnect",
					userConnect: data.data.username,
				};
		
				socket.send(JSON.stringify(message));
			}
		};
	
		Navigate('/dashboard');
	}

});

// listen event when user back or forward
window.addEventListener("popstate", function (event) {
	Navigate(event.state.path);
});

// config navigate
const Navigate = async (pathname) => {
	/*
	  param 1: path
	  param 2: id   
	*/
	window.history.pushState({ path: pathname }, "", pathname);

	const param = pathname.split("/");

	const path = param[1] ? param[1] : "login";

	receiver = param[2] ? param[2] : null;

	const response = await fetch(`/page/${path}.php`);

	const app = document.getElementById("app");

	switch (path) {
		case "login":
			app.innerHTML = await response.text();
			break;
		case "register":
			app.innerHTML = await response.text();
			break;
		case "dashboard":
			app.innerHTML = await response.text();
			listApi();
			break;
		default:
			break;
	}
};
