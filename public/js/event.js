const logout = async () => {
	const sender = document.getElementById('sender').textContent;

	const response = await fetch(`/${endpoint}/logout`, {
		method: 'post'
	});
	const data = await response.json();
	if(data && !data.isLogin){

		const message = {
			type: 'userDisconnect',
			userDisconect: sender
		}

		socket.send(JSON.stringify(message));

		Navigate('/login');
		return
	}
}

//socket disconect
socket.onclose = () => {
	const message = {
		type: 'userDisconnect',
	}

	socket.send(JSON.stringify(message));
};