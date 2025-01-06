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

	numberRequest.textContent = parseInt(numberRequest.textContent) -1;

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

const CancelFriendRequest = (cancelBtn) => {

	if(!cancelBtn.classList.contains('hidden')){
		cancelBtn.classList.add('hidden');
	}

	document.getElementById('cancel_message').textContent = "Your friend request has been canceled";

}

const handleSendFriendRequest = (sendFriendRequestBtn) => {
	if(!sendFriendRequestBtn.classList.contains('hidden')){
		sendFriendRequestBtn.classList.add('hidden')
	}

	document.getElementById('cancel_send_btn').classList.remove('hidden');
}

const handleCancelFriendRequest = (sendFriendRequestBtn) => {
	if(!sendFriendRequestBtn.classList.contains('hidden')){
		sendFriendRequestBtn.classList.add('hidden')
	}

	document.getElementById('click_send_btn').classList.remove('hidden');
}