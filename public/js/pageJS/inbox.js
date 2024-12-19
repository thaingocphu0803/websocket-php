let currentOnline = null;

const sendMessage = () => {
	const from = document.getElementById("username").textContent;
	const text = document.getElementById("input_message").value.trim();
	const to = document.getElementById("partner_username").textContent;
	let sendComponent = document.getElementById("inbox_box")
	let sendDate = getSendDate();
	
	const room = [from, to].sort().join("_");

	if(!text) return;

	const message  = {
		type: 'sendMessage',
		room,
		from,
		to,
		date: sendDate,
		message: text
	}

	socket.send(JSON.stringify(message));
	document.getElementById("input_message").value =""


	sendComponent.innerHTML += `
		<div class="message-component right">
			<span id="time_send" class="datetime right">${sendDate}</span>
			<span id="message_send" class="left">${text}</span>
		</div>
	`
};

socket.onmessage = (event) => {

	const objMessage = JSON.parse(event.data);

	if(objMessage.type === 'sendMessage'){
		const from = document.getElementById("username").textContent;
		const to = document.getElementById("partner_username").textContent;
		let receiveComponent = document.getElementById("inbox_box");
		currentRoom = [from, to].sort().join('_');
		
		if(objMessage.room === currentRoom){
			receiveComponent.innerHTML += `
			<div class="message-component left">
				<span id="time_receive" class="datetime right">${objMessage.date}</span>
				<span id="message_receive" class="left">${objMessage.message}</span>
			</div>
		`;
		}
	}else if(objMessage.type === "userConnect" && objMessage.isOnline === 1){
		const userStatus = getUserStatus(objMessage.username);
		if(!userStatus) return;
		userStatus.textContent = "Online";
		currentOnline = objMessage.isOnline;

	}else if(objMessage.type === "userDisconnect" && objMessage.isOnline === 0){
		const userStatus = getUserStatus(objMessage.username);
		if(!userStatus) return;
		userStatus.textContent = "";
		currentOnline = objMessage.isOnline;
	}

};

const getUserStatus = (element) => {
	const userCard = document.getElementById(`${element}`);
	if(!userCard) return;
	const userStatus = userCard.querySelector('#status_l');

	if(userStatus) return userStatus;

}

socket.onerror = (error) => {
	console.error("Socket Error:", error);
};

const getSendDate = () =>{
	const now = new Date();

	// format time to string
	const localTime = now.toLocaleString('en-US', {
		year: 'numeric',    
		month: '2-digit',    
		day: '2-digit',      
		hour: '2-digit',     
		minute: '2-digit', 
		second: '2-digit',
		hour12:true
	})

	return localTime;
}

