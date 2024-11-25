const getPartnerId = (partnerId) => {
	return partnerId;
};
const sendMessage = () => {
	const message = document.getElementById("message").value;
	document.getElementById(
		"message_box"
	).innerHTML += `<p style="color:red"> Me: ${message}</p>`;

	socket.send(message);
};

socket.onmessage = (event) => {
	console.log(event);
	document.getElementById(
		"message_box"
	).innerHTML += `<p> Player: ${event.data}</p>`;
};

socket.onerror = (error) => {
	console.error("Đã xảy ra lỗi WebSocket:", error);
};

socket.onclose = () => {
	console.log("WebSocket đã đóng.");
};
