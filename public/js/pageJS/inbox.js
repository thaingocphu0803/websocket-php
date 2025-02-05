const sendMessage = async () => {
	const from = document.getElementById("username").textContent;
	const text = document.getElementById("input_message").value.trim();
	const to = document.getElementById("partner_username").textContent;
	const room = [from, to].sort().join("_");

	const inputFiles = document.getElementById("inbox_image");
	const imageArray = inputFiles.files;

	const formData = new FormData();
	formData.append("room", room);

	if (!text && imageArray.length === 0) return;

	if (imageArray.length > 0) {
		for (let i = 0; i < imageArray.length; i++) {
			formData.append(`images[]`, imageArray[i]);
		}
	}

	clearPreviewImage();
	// clear input message after send
	document.getElementById("input_message").value = "";

	const listImage =
		imageArray.length > 0 ? await handleMessageImage(formData) : [];

	let sendDate = getSendDate();

	//handle image to send
	const message = {
		type: "sendMessage",
		room,
		from,
		to,
		date: sendDate,
		message: text,
		listImage,
	};

	socket.send(JSON.stringify(message));

	renderMessage("right", sendDate, text, listImage);

	// clear input file after sen
	inputFiles.value = "";
};

socket.onmessage = (event) => {
	const objMessage = JSON.parse(event.data);

	const numberRequest = document.getElementById("number_invite");

	if (objMessage.type === "unRead") {
		const notification = document
			.getElementById(`noti_${objMessage.sender}`);

		notification.textContent = parseInt(notification.textContent || 0) + 1;

		if (notification.classList.contains("hidden")) {
			notification.classList.remove("hidden");
			playNotification();
		}
	} else if (objMessage.type === "sendMessage") {
		const from = document.getElementById("username").textContent;
		const to = document.getElementById("partner_username").textContent;
		currentRoom = [from, to].sort().join("_");

		if (objMessage.room === currentRoom) {
			renderMessage(
				"left",
				objMessage.date,
				objMessage.message,
				objMessage.listImage
			);
			playNotification();
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
	} else if (objMessage.type === "sendFriendRequest") {
		numberRequest.textContent =
			parseInt(numberRequest.textContent || 0) + 1;

		if (numberRequest.classList.contains("hidden")) {
			numberRequest.classList.remove("hidden");
		}

		renderRequestCard(objMessage);
	} else if (objMessage.type === "cancelFriendRequest") {
		const requestCard = document.getElementById(
			`request_${objMessage.senderId}`
		);
		requestCard && requestCard.remove();
		numberRequest.textContent =
			parseInt(numberRequest.textContent || 0) - 1;
		if (parseInt(numberRequest.textContent) === 0) {
			numberRequest.classList.add("hidden");
		}
	} else if (objMessage.type === "deleteFriend") {
		const friendCard =
			document.getElementById(`friend_${objMessage.senderId}`) ?? null;
		const itemPartner =
			document.getElementById(`item_${objMessage.senderId}`) ?? null;

		if (friendCard) {
			friendCard.remove();
		}

		if (itemPartner) {
			itemPartner.remove();
		}
	} else if (objMessage.type === "accepted") {
		listFriend();
		listApi();
	} else if (objMessage.type === "rejected") {
		const sentRequestCard =
			document.getElementById(`send_request_${objMessage.senderId}`) ??
			null;
		const sentRequestBtn =
			document.getElementById(`send_btn_${objMessage.senderId}`) ?? null;
		const addFriendMessage =
			document.getElementById(
				`addfriend_message_${objMessage.senderId}`
			) ?? null;

		if (sentRequestCard) {
			sentRequestCard.remove();
		}

		if (sentRequestBtn || addFriendMessage) {
			if (
				sentRequestBtn.classList.contains("hidden") &&
				!addFriendMessage.classList.contains("hidden")
			) {
				addFriendMessage.classList.add("hidden");
				sentRequestBtn.classList.remove("hidden");
			}
		}
	}
};

const getUserStatus = (element) => {
	const userCard = document.getElementById(`${element}`);
	if (!userCard) return;
	const userStatus = userCard.querySelector("#status_l");

	if (userStatus) return userStatus;
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

const renderMessage = (position, date, message = null, image = []) => {
	let iboxComponent = document.getElementById("inbox_box");

	if (message) {
		iboxComponent.innerHTML += `
			<div class="message-component ${position}">
				<span id="time_send" class="datetime right">${date}</span>
				<span id="message_send" class="left">${message}</span>
			</div>
		`;
	}
	if (image.length > 0) {
		for (let i = 0; i < image.length; i++)
			iboxComponent.innerHTML += `
			<img class="image-${position} thumnail" src="${atob(
				image[i]
			)}" alt="message image" width="150px" height="130px"  onclick="handleViewImage(event)">
		`;
	}

	scollToBottom();
};

//handle to show inbox box

const showInboxBox = async (partnerFullName, isOnline, partnerUserName) => {
	const from = document.getElementById("username").textContent;

	const room = [from, partnerUserName].sort().join("_");
	currentRoom = room;

	window.history.replaceState({}, "", `/dashboard#${partnerUserName}`);

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

	scollToBottom();
};

// handle to show image if close inbox box

const closeInboxBox = async () => {
	const from = document.getElementById("username").textContent;

	window.history.replaceState({}, "", `/dashboard`);

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
			body: JSON.stringify({ room, from }),
		});

		const data = await response.json();

		clearInbox();

		if (!data.status) return;

		data.data.listMessage.forEach((message) => {
			let img_url = message.img_urls ? message.img_urls.split(",") : [];

			if (message.sender === from) {
				renderMessage(
					"right",
					message.create_at,
					message.mssg,
					img_url
				);
			} else {
				renderMessage("left", message.create_at, message.mssg, img_url);
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

		if (data.status) return status;
	} catch (err) {
		console.log(err);
	}
};

const scollToBottom = () => {
	const inboxBox = document.getElementById("inbox_box");
	inboxBox.scrollTop = inboxBox.scrollHeight;
};

// reset number of notification to 0
const resetNotification = (element) => {
	const Notification = element.querySelector(".notify");

	if (!Notification) return;

	Notification.textContent = 0;

	if (!Notification.classList.contains("hidden")) {
		Notification.classList.add("hidden");
	}
};

const handleMessageImage = async (formData) => {
	try {
		const response = await fetch(`/${endpoint}/upload-message-images`, {
			method: "post",
			body: formData,
		});

		const data = await response.json();

		if (!data) return;

		return data.data.listImage;
	} catch (err) {
		console.log(err);
	}
};
