const sendMessage = () => {
	const sender = document.getElementById("sender").textContent;
	const text = document.getElementById("message").value;
	const message = {
		type: 'sendMessage',
		from: sender,
		to: receiver,
		message: text
	}
	socket.send(JSON.stringify(message));

	document.getElementById(
		"message_box"
	).innerHTML += `<p style="color:red"> Me: ${text}</p>`;

};

socket.onmessage = (event) => {

	
	const objMessage = JSON.parse(event.data);
	keyRoom = [objMessage.sender, objMessage.receiver].sort().join('_')

	if(keyRoom !== currentRoom) return;

	document.getElementById(
		"message_box"
	).innerHTML += `<p> ${objMessage.sender}: ${objMessage.message}</p>`;
};

socket.onerror = (error) => {
	console.error("Đã xảy ra lỗi WebSocket:", error);
};

