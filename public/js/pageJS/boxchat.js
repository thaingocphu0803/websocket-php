
const sendMessage = () => {
	const text = document.getElementById("message").value;
	const message = {
		type: 'sendMessage',
		to: userId,
		message: text
	}
	socket.send(JSON.stringify(message));

	document.getElementById(
		"message_box"
	).innerHTML += `<p style="color:red"> Me: ${text}</p>`;

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
