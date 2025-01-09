let debounceTime = null;

const returnToMyFriend = async() => {
	try{
		const response = await fetch(`/${endpoint}/get-count-friend-request`);
		const data = await response.json();

		if(!data.status) return;

		const numberRequest = document.getElementById('number_invite');
	
		numberRequest.textContent = data.data.count;
	
		if(parseInt(numberRequest.textContent) === 0){
			numberRequest.classList.add('hidden');
		}

		Navigate('/my-friend')
	}catch(err){
		console.log(err)
	}
}

const openTabContent = (event, tab) => {
	const tabContent = document.getElementsByClassName('tabcontent');
	const tabButton = document.getElementsByClassName('tabBtn');

	for(let i = 0 ; i < tabContent.length; i++){
		if(!tabContent[i].classList.contains('hidden')){
			tabContent[i].classList.add('hidden');
		}
	}

	for(let i = 0; i < tabButton.length; i++){
		if(tabButton[i].classList.contains('active')){
			tabButton[i].classList.remove('active');
		}
	}

	document.getElementById(`${tab}`).classList.remove('hidden');
	event.currentTarget.classList.add('active');

}

const handleFriendRequest = (reject = false) => {
	const groupRequestBtn = document.getElementsByClassName('group-request-btn')[0];
	const requestMessage = document.getElementById('request_message');
	const numberRequest = document.getElementById('number_invite');
	let message = null;

	numberRequest.textContent = parseInt(numberRequest.textContent || 0) -1;

	if(parseInt(numberRequest.textContent) === 0){
		numberRequest.classList.add('hidden');
	}

	if(!groupRequestBtn.classList.contains('hidden')){
		groupRequestBtn.classList.add('hidden');
	}

	if(reject){
		message = "This friend request has been rejected"
		requestMessage.textContent = message;
		return
	}

	message = "This friend request has been accepted"
	requestMessage.textContent = message;
	
}

const CancelFriendRequest = async(cancelBtn , id, receiverUsername) => {

	const cancelBtnRequest = document.getElementById(`cancel_btn_${receiverUsername}`)
	const SentBtnRequest = document.getElementById(`send_btn_${receiverUsername}`)


	const formData = {
		receiver: receiverUsername,
		stt: 'rejected'
	}

	const data = await fetchFriendRequest(formData);

	if(!data) return

	if(!cancelBtn.classList.contains('hidden')){
		cancelBtn.classList.add('hidden');
	}

	document.getElementById(id).textContent = "Your friend request has been canceled";

	if(SentBtnRequest.classList.contains('hidden')){
		SentBtnRequest.classList.remove('hidden');
		cancelBtnRequest.classList.add('hidden');
	}


}

const handleSendFriendRequest = async (sendFriendRequestBtn, id, peopleUsername) => {

	const from = document.getElementById("username").textContent;

	const formData = {
		receiver: peopleUsername,
		stt: 'pending'
	}

	const data = await fetchFriendRequest(formData);

	if(!data) return

	const message = {
		type: 'sendFriendRequest',
		from,
		to: peopleUsername
	}

	socket.send(JSON.stringify(message));
	
	if(!sendFriendRequestBtn.classList.contains('hidden')){
		sendFriendRequestBtn.classList.add('hidden')
	}

	document.getElementById(id).classList.remove('hidden');
	listSendAdd();
}

const handleCancelFriendRequest = async(sendFriendRequestBtn, id, peopleUsername) => {
	const formData = {
		receiver: peopleUsername,
		stt: 'rejected'
	}

	const data = await fetchFriendRequest(formData);

	if(!data) return

	if(!sendFriendRequestBtn.classList.contains('hidden')){
		sendFriendRequestBtn.classList.add('hidden')
	}

	document.getElementById(id).classList.remove('hidden');
}

const handleSearchPeople = async(event) =>{
	let inputSearch = event.target.value;

	clearTimeout(debounceTime);

	debounceTime = setTimeout(async()=> {
		const listPeople = await fetchSearchAPI(inputSearch);

		if(!listPeople) return;

		renderPeopleCard(listPeople);

	},500)

	

}

const fetchSearchAPI = async(formData) => {
		try{
			const response = await fetch(`/${endpoint}/search-people`,{
				method: 'post',
				body: JSON.stringify({key: formData})
			});
			const data = await response.json();
			
			if(!data.status) return false;

			return data.data.listPeople
		}catch(err){
			console.log(err);
		}
}

const fetchFriendRequest = async(formData) => {
	const response = await fetch(`/${endpoint}/handle-friend-request`,{
		method: 'post',
		body: JSON.stringify(formData)
	});

	const data = await response.json();

	if(!data.status) return false;

	return data;

}

const listSendAdd = async() => {
	try{
		const response = await fetch(`/${endpoint}/list-send-add`);

		const data = await response.json();

		if(!data.status) return

		renderReceiverRequest(data.data.listReceiverRequest)
	}catch(err){
		console.log(err);
	}
}


const listAddRequest = async() => {
	try{
		const response = await fetch(`/${endpoint}/list-add-request`);

		const data = await response.json();

		if(!data.status) return

		const listAddRequest  = data.data.listAddRequest;

		listAddRequest.forEach(sender => {
			renderRequestCard(sender);
		})
	}catch(err){
		console.log(err);
	}
}

socket.onmessage = (event) => {
	const objMessage = JSON.parse(event.data);

	if(objMessage.type === "sendFriendRequest"){
		const numberRequest = document.getElementById('number_invite');	
		numberRequest.textContent = parseInt(numberRequest.textContent || 0) + 1;

		if(numberRequest.classList.contains('hidden')){
			numberRequest.classList.remove('hidden');
		}
	
		renderRequestCard(objMessage)
	}
}


const renderReceiverRequest = (listReceiver) => {
	const listContent = document.getElementById('friend_request_sent');

	listContent.innerHTML = "";

	listReceiver.forEach( (receiver, index) => {
		listContent.innerHTML += `
			<div id="" class="user-request-card">
				<img class="avt" src=" ${receiver.avatar ? atob(receiver.avatar) : '../asset/logo.webp'}" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${receiver.fullname}</span>
					<button class="request-btn" title="Click to cancel friend request" onclick="CancelFriendRequest(this, 'cancel_message_${index}', '${receiver.username}')">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
							<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM472 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
						</svg>
					</button>
				</div>

				<span id="cancel_message_${index}"></span>
			</div>
	`
	});

}

const renderPeopleCard = (listPeople) => {
	const listContent = document.getElementById('people_card');

	listContent.innerHTML = "";

	listPeople.forEach( (people) => {
		listContent.innerHTML += `
			<div id="${people.username}" class="user-request-card">
				<img class="avt" src=" ${people.avatar ? atob(people.avatar) : '../asset/logo.webp'}" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${people.fullname}</span>

					<button class="request-btn ${people.stt === 'pending' ? 'hidden' : ''}" title="Click to add friend" id="send_btn_${people.username}" onclick="handleSendFriendRequest(this,  'cancel_btn_${people.username}', '${people.username}')">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
							<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
						</svg>
					</button>
						
					<button class="request-btn ${people.stt === 'pending' ? '' : 'hidden'}" id="cancel_btn_${people.username}" title="Click to cancel friend request" onclick="handleCancelFriendRequest(this, 'send_btn_${people.username}', '${people.username}')">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
							<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM472 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
						</svg>
					</button>
				</div>
			</div>
	`
	});

}

const renderRequestCard = (senderInfor) => {

	const listRequestAdd = document.getElementById('friend_request');
	
	listRequestAdd.innerHTML += `				
		<div id="${senderInfor.senderId}" class="user-request-card">
			<img class="avt" src=" ${senderInfor.senderAvt ? atob(senderInfor.senderAvt) : '../asset/logo.webp'}" alt="user's avatar" width="50px" height="50px">
			<div id="title">
				<span id="fullname_l">${senderInfor.senderFullname}</span>
				<div class="group-request-btn">
				
					<button class="request-btn" title="Click to accept friend request" onclick="handleFriendRequest()">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16px" height="16px">
							<path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
						</svg>
					</button>
				
					<button class="request-btn" title="Click to reject friend request" onclick="handleFriendRequest(true)">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  width="16px" height="16px">
							<path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
						</svg>
					</button>
				</div>
			</div>
			<span id="request_message"></span>
		</div>
	`
}