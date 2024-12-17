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
// handle dropdown in home page
const handleDropdown = () =>{
	const dropdown ={
		btn: document.getElementById("dropdown_btn"),
		content: document.getElementById("dropdown_content")
	} 

	const icon = {
		up: document.getElementById("icon-up"),
		down: document.getElementById("icon-down")
	}

	if(dropdown.content.classList.contains('hidden')){
		if(icon.down.classList.contains('hidden')){
			icon.down.classList.remove('hidden');
			icon.up.classList.add('hidden');
		}
		dropdown.content.classList.remove('hidden');
	}else{
		icon.down.classList.add('hidden');
		icon.up.classList.remove('hidden');
		dropdown.content.classList.add('hidden');
	}
}