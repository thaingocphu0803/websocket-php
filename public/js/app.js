"use strict";

const endpoint = "endpoint.php";
const pathname = location.pathname.toLowerCase();
let partner = {};

//generate socket connection

const socket = new WebSocket(`ws://localhost:9000`);

document.addEventListener("DOMContentLoaded", async () => {
	try {
		const response = await fetch(`/${endpoint}/check-login`, {
			method: "post",
		});
		const data = await response.json();

		if (!data.status) {
			Navigate("/login");
			return;
		} else {
			socket.onopen = () => {
				if (data.data.username) {
					const message = {
						type: "userConnect",
						userConnect: data.data.username,
					};

					socket.send(JSON.stringify(message));
				}
			};

			if(data.data.roomStatus === 'A'){ 
				partner.FullName = data.data.partnerFullName;
				partner.isOnline = data.data.parterIsOnline;
				partner.Username = data.data.partnerUserName;
			}

			Navigate("/dashboard");

		}
	} catch (err) {
		console.log(err);
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


	try {
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

				if(partner && Object.keys(partner).length > 0){
					showInboxBox(partner.FullName, partner.isOnline, partner.Username);

					//handle upload image
					document.getElementById('inbox_image').addEventListener('change', (event)=> {
						handleUploadImages(event);
					})
				}
				break;
			default:
				break;
		}
	} catch (err) {
		console.log(err);
	}
};
