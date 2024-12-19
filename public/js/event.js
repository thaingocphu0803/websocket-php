const logout = async () => {
	const sender = document.getElementById('username').textContent;

	const message = {
		type: 'userDisconnect',
		userDisconect: sender
	}

	socket.send(JSON.stringify(message));

	const response = await fetch(`/${endpoint}/logout`, {
		method: 'post'
	});
	const data = await response.json();
	if(data.status){
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

const showInboxBox = async (fullname, isOnline, username) =>{
	await getMessage();

	const inbox = {
		image: document.getElementById('inbox_img'),
		box: document.getElementById('inbox'),
		fullname: document.getElementById('fullname_b'),
		username: document.getElementById('partner_username'),
		status: document.getElementById('status_b')
	}


	if(inbox.box.classList.contains('hidden')){
		inbox.box.classList.remove('hidden');
		inbox.image.classList.add('hidden');
	}

	inbox.fullname.textContent = fullname;
	inbox.username.textContent = username;



	if(isOnline == '1' || currentOnline == '1'){
		inbox.status.textContent = 'Online';
	}else{
		inbox.status.textContent = '';

	}
}
// call api to get message
const getMessage = async () =>{

	const from = document.getElementById("username").textContent;
	console.log(from);
	const to = document.getElementById("partner_username").textContent;
	console.log(to);

	const room = [from, to].sort().join("_");

	const response = await fetch(`/${endpoint}/get-message`,{
		method: 'post',
		body: JSON.stringify({room})
	})
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

const unescapeHTML = (str) => {
	const doc = new DOMParser().parseFromString(str, 'text/html');

	return doc.documentElement.textContent || doc.body.textContent;
}

const escapeHTML = (str) => {
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
};