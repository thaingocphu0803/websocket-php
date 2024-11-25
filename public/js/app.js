"use strict";

const endpoint = "endpoint.php";
const pathname = location.pathname.toLowerCase();

//using to get to todo detail on edit.js
let todoId = null;
let todoStatus = null;

document.addEventListener("DOMContentLoaded", async () => {
	
	const response = await fetch(`/${endpoint}/check-login`, {
		method: 'post'
	});
	const data = await response.json();
	if(data && !data.isLogin){
		Navigate('/login');
		return
	}
	Navigate(pathname);
	openSocket();
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
	
	const path = param[1] ? param[1] : 'login';

	const id = param[2] ? param[2] : null;

	const response = await fetch(`/page/${path}.php`);

	const app = document.getElementById('app');


	switch(path){
		case 'login':
			app.innerHTML = await response.text();
			break;
		case 'register':
			app.innerHTML = await response.text();
			break;
		case 'listchat':
			app.innerHTML = await response.text();
			listApi();
			break;
		case 'boxchat':
			app.innerHTML = await response.text();
			getPartnerId(id);
		default:
			break;
	}
};