"use strict";

const app = document.getElementById("app");
const endpoint = "endpoint.php";
const pathname = location.pathname.toLowerCase();

const socket = new WebSocket(`ws://localhost:9000`);



console.log('hello',pathname);

//using to get to todo detail on edit.js
let todoId = null;
let todoStatus = null;

document.addEventListener("DOMContentLoaded", async () => {
	const response = await fetchAPI(`/${endpoint}/check-authen-api`, 'post');

	console.log("hello", response.data.isLogin);

	if(!response.data.isLogin){
		Navigate('/login');
		return
	}

	Navigate(pathname);
});

// listen event when user back or forward
window.addEventListener("popstate", function (event) {
	Navigate(event.state.path);
});

// config navigate
const Navigate = (pathname) => {

	/*
	  param 1: path
	  param 2: id   
	*/
	window.history.pushState({ path: pathname }, "", pathname);

	const param = pathname.split("/");


		switch (param[1]) {
			case "":
			case "login":
				app.innerHTML = renderLogin();

				document.getElementById('form').addEventListener('keydown', async(event) => {
					if(event.key === "Enter"){
						await submit();
					}
				})

				break;
			case "register":
				app.innerHTML = renderRegister();
				document.getElementById('form').addEventListener('keydown', async(event) => {
					if(event.key === "Enter"){
						await submit();
					}
				})
				break;
			case "list":
				app.innerHTML = renderList();
				listApi();
				break;
			case "box-chat":
				app.innerHTML = renderBoxChat();
				break;
			default:
				window.history.pushState({}, "404", "not-found");
				app.innerHTML = renderNotFound();
				break;
		}
};
