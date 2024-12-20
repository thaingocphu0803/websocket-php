let currentOnline = null;
let currentRoom = null;

const sendMessage = () => {
	const from = document.getElementById("username").textContent;
	const text = document.getElementById("input_message").value.trim();
	const to = document.getElementById("partner_username").textContent;
	let sendDate = getSendDate();

	const room = [from, to].sort().join("_");

	if (!text) return;

	const message = {
		type: "sendMessage",
		room,
		from,
		to,
		date: sendDate,
		message: text,
	};

	socket.send(JSON.stringify(message));
	document.getElementById("input_message").value = "";

	renderMessage(sendDate, text, "right");
};

socket.onmessage = (event) => {
	const objMessage = JSON.parse(event.data);

	if (objMessage.type === "sendMessage") {
		const from = document.getElementById("username").textContent;
		const to = document.getElementById("partner_username").textContent;
		currentRoom = [from, to].sort().join("_");

		if (objMessage.room === currentRoom) {
			renderMessage(objMessage.date, objMessage.message, "left");
		}
	} else if (objMessage.type === "userConnect" && objMessage.isOnline === 1) {
		const userStatus = getUserStatus(objMessage.username);
		if (!userStatus) return;
		userStatus.textContent = "Online";
		currentOnline = objMessage.isOnline;
	} else if (
		objMessage.type === "userDisconnect" &&
		objMessage.isOnline === 0
	) {
		const userStatus = getUserStatus(objMessage.username);
		if (!userStatus) return;
		userStatus.textContent = "";
		currentOnline = objMessage.isOnline;
	}
};

const getUserStatus = (element) => {
	const userCard = document.getElementById(`${element}`);
	if (!userCard) return;
	const userStatus = userCard.querySelector("#status_l");

	if (userStatus) return userStatus;
};

socket.onerror = (error) => {
	console.error("Socket Error:", error);
};

const getSendDate = () => {
	const date = new Date();

	const year = date.getFullYear();
	const month = String(date.getMonth() + 1).padStart(2, "0");
	const day = String(date.getDate()).padStart(2, "0");
	const hours = String(date.getHours()).padStart(2, "0");
	const minutes = String(date.getMinutes()).padStart(2, "0");
	const seconds = String(date.getSeconds()).padStart(2, "0");

	const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

	return formattedDate;
};

const renderMessage = (date, message, position) => {
	let iboxComponent = document.getElementById("inbox_box");

	iboxComponent.innerHTML += `
		<div class="message-component ${position}">
			<span id="time_send" class="datetime right">${date}</span>
			<span id="message_send" class="left">${message}</span>
		</div>
	`;

	iboxComponent.scrollTop = iboxComponent.scrollHeight;
};

//handle to show inbox box

const showInboxBox = async (partnerFullName, isOnline, partnerUserName) => {

	console.log(partnerFullName, isOnline, partnerUserName);

	const from = document.getElementById("username").textContent;

	const room = [from, partnerUserName].sort().join("_");
	currentRoom = room;

	const status = await setRoomStatus(room, "A", from);
	if (!status) return;

	await renderListMessage(room, from);

	const inbox = {
		image: document.getElementById("inbox_img"),
		box: document.getElementById("inbox"),
		fullname: document.getElementById("fullname_b"),
		username: document.getElementById("partner_username"),
		status: document.getElementById("status_b"),
	};

	if (inbox.box.classList.contains("hidden")) {
		inbox.box.classList.remove("hidden");
		inbox.image.classList.add("hidden");
	}

	inbox.fullname.textContent = partnerFullName;
	inbox.username.textContent = partnerUserName;

	if (isOnline == "1" || currentOnline == "1") {
		inbox.status.textContent = "Online";
	} else {
		inbox.status.textContent = "";
	}
};

// handle to show image if close inbox box

const closeInboxBox = async () => {
	const from = document.getElementById("username").textContent;

	const status = await setRoomStatus(currentRoom, "X", from);
	if (!status) return;

	const inbox = {
		image: document.getElementById("inbox_img"),
		box: document.getElementById("inbox"),
	};

	if (inbox.image.classList.contains("hidden")) {
		inbox.image.classList.remove("hidden");
		inbox.box.classList.add("hidden");
	}
};

// call api to get message
const renderListMessage = async (room, from) => {
	try {
		const response = await fetch(`/${endpoint}/get-message`, {
			method: "post",
			body: JSON.stringify({ room }),
		});

		const data = await response.json();

		clearInbox();

		if (!data.status) return;

		data.data.listMessage.forEach((message) => {
			if (message.sender === from) {
				renderMessage(message.create_at, message.mssg, "right");
			} else {
				renderMessage(message.create_at, message.mssg, "left");
			}
		});
	} catch (err) {
		console.log(err);
	}
};

const setRoomStatus = async (room, status, user_open) => {
	const formData = {
		room,
		status,
		user_open,
	};
	try {
		const response = await fetch(`/${endpoint}/set-room-status`, {
			method: "post",
			body: JSON.stringify(formData),
		});

		const data = await response.json();

		console.log(data);

		if (data.status) return status;
	} catch (err) {
		console.log(err);
	}
};
