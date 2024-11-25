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

const openSocket =  () => {
	window.socket = new WebSocket(`ws://localhost:9000`);

	socket.onopen =  () => {
		console.log('WebSocket đã mở.');
	};
}
