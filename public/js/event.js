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

//handle to show inbox box

const showInboxBox = (fullname, isOnline) =>{
	const inbox = {
		image: document.getElementById('inbox_img'),
		box: document.getElementById('inbox'),
		fullname: document.getElementById('fullname_b'),
		status: document.getElementById('status_b')
	}


	if(inbox.box.classList.contains('hidden')){
		inbox.box.classList.remove('hidden');
		inbox.image.classList.add('hidden');
	}

	inbox.fullname.textContent = fullname;


	if(isOnline == '1'){
		inbox.status.textContent = 'Online';
	}else{
		inbox.status.textContent = '';

	}
}

// handle to show image if close inbox box

const closeInboxBox = () => {
	const inbox = {
		image: document.getElementById('inbox_img'),
		box: document.getElementById('inbox')
	}

	if(inbox.image.classList.contains('hidden')){
		inbox.image.classList.remove('hidden');
		inbox.box.classList.add('hidden');
	}
}