const renderBoxChat = () => {
	return `
		<button type="button" onclick="logout()">logout</butto>
		<div id="message_box"></div>
		<input type="text" id="message"></input>
		<button type="button" onclick="sendMessage()">send</button>
	`
}

const logout = async () => {
	const response = await fetch(`/${endpoint}/logout`, {
		method: 'post'
	});
	const data = await response.json();
	if(data && !data.isLogin){
		Navigate('/login');
		return
	}
}

const getPartnerId = () => {
	const urlParams = new URLSearchParams(window.location.search);
	const partner = urlParams.get('partner');
	return partner
}

socket.onopen =  () => {
	console.log('WebSocket đã mở.');
};

const sendMessage = () => {
	const message = document.getElementById("message").value;
	document.getElementById("message_box").innerHTML += `<p style="color:red"> Me: ${message}</p>`
	socket.send(message);
}

socket.onmessage = (event) => {
	console.log(event);
	document.getElementById("message_box").innerHTML += `<p> Player: ${event.data}</p>`
};

socket.onerror = (error) => {
	console.error('Đã xảy ra lỗi WebSocket:', error);
};

socket.onclose = () =>{
	console.log('WebSocket đã đóng.');
};