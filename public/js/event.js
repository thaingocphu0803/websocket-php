const logout = async () => {
	const response = await fetch(`/${endpoint}/logout`, {
		method: 'post'
	});
	const data = await response.json();
	if(data && !data.isLogin){

		message = {
			type: 'userDisconnect',
		}

		socket.send(JSON.stringify(message));

		Navigate('/login');
		return
	}
}