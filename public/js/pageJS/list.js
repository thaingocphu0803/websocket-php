

const listApi= async()=>{	
	const response  = await fetch (`/${endpoint}/list`, {
		method:'post'
	})

	const data = await response.json();

	const list = document.getElementById('list_chat');

	// const search = document.getElementById('search').ariaValueMax.toLowerCase();

	data.data.list.forEach(item => {
		list.innerHTML += `
			<div id="${item.username}" class="inbox-card" onclick="showInboxBox('${item.fullname}', '${item.isOnline}')">
				<img id="avt" src="../asset/logo.png" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${item.fullname}</span>
					<span id="status_l" class="${item.isOnline == 0 ? 'hidden' : ''}">Online</span>
				</div>
				<div class="message-card">
					<span id="new_message">Hello my name is Phu</span>
					<span id="send_time">20/12/2024</span>
				</div>
			</div>
		`
	});

};
