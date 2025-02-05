"use strict";

const endpoint = "endpoint.php";
const pathname = location.pathname.toLowerCase();

let currentOnline = null;
let currentRoom = null;
let partner = {};
let cacheObj = {};

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

			if (data.data.roomStatus === "A") {
				partner.FullName = data.data.partnerFullName;
				partner.isOnline = data.data.parterIsOnline;
				partner.Username = data.data.partnerUserName;
			}

			Navigate(pathname != "/login" ? pathname : "/dashboard");
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

	window.history.pushState({ path: pathname }, "", `${pathname}`);

	const param = pathname.split("/");

	const path = param[1] ? param[1] : "login";

	let template = null;

	try {

		const response = await fetch(`/${endpoint}/handle-template`, {
			method: "post",
			headers: cacheObj[path]
				? { "If-Modified-Since": cacheObj[path].lastModified }
				: {},
			body: JSON.stringify({ template: path }),
		});

		if (response.status === 304) {
			template = cacheObj[path].template;
		} else if (response.ok) {
			template = await response.text();

			cacheObj[path] = {
				lastModified: response.headers.get("Last-Modified"),
				template,
			};
		}

		const app = document.getElementById("app");

		switch (path) {
			case "login":
				app.innerHTML = template;
				break;
			case "register":
				app.innerHTML = template;
				break;
			case "dashboard":
				app.innerHTML = template;
				listApi();
				fetchCountRequestAPI();
				if (!window.sessionStorage.getItem("playSound"))
					showConfirmPlaySound();

				if (partner && Object.keys(partner).length > 0) {
					showInboxBox(
						partner.FullName,
						partner.isOnline,
						partner.Username
					);
				}
				break;
			case "my-profile":
				app.innerHTML = template;
				fetchCountRequestAPI();
				break;
			case "my-friend":
				app.innerHTML = template;
				listSendAdd();
				listAddRequest();
				fetchCountRequestAPI();
				listFriend();
			default:
				break;
		}
	} catch (err) {
		console.log(err);
	}
};
