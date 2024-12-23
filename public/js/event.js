const logout = async () => {
	const sender = document.getElementById("username").textContent;

	const message = {
		type: "userDisconnect",
		userDisconect: sender,
	};

	socket.send(JSON.stringify(message));

	try {
		const response = await fetch(`/${endpoint}/logout`, {
			method: "post",
		});
		const data = await response.json();
		if (data.status) {
			Navigate("/login");
			return;
		}
	} catch (err) {
		console.log(err);
	}
};

// handle dropdown in home page
const handleDropdown = () => {
	const dropdown = {
		btn: document.getElementById("dropdown_btn"),
		content: document.getElementById("dropdown_content"),
	};

	const icon = {
		up: document.getElementById("icon-up"),
		down: document.getElementById("icon-down"),
	};

	if (dropdown.content.classList.contains("hidden")) {
		if (icon.down.classList.contains("hidden")) {
			icon.down.classList.remove("hidden");
			icon.up.classList.add("hidden");
		}
		dropdown.content.classList.remove("hidden");
	} else {
		icon.down.classList.add("hidden");
		icon.up.classList.remove("hidden");
		dropdown.content.classList.add("hidden");
	}
};

const unescapeHTML = (str) => {
	const doc = new DOMParser().parseFromString(str, "text/html");

	return doc.documentElement.textContent || doc.body.textContent;
};

const escapeHTML = (str) => {
	return str
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#39;");
};

const clearInbox = () => {
	document.getElementById("inbox_box").innerHTML = "";
};

socket.onerror = (error) => {
	console.error("Socket Error:", error);
};

//socket disconect
socket.onclose = () => {
	const message = {
		type: "userDisconnect",
	};

	socket.send(JSON.stringify(message));
};
