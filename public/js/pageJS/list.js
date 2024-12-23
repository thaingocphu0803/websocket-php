

const listApi= async()=>{	
	const response  = await fetch (`/${endpoint}/list`, {
		method:'post'
	})

	const data = await response.json();


	renderList (data.data.list);


	const search = document.getElementById('search');
	
	search.addEventListener('input', ()=>{
		const query = search.value.toLowerCase();

		const filterData =  data.data.list.filter((item)=>{
			return item.fullname.toLowerCase().includes(query);
		})

		renderList (filterData);
	})
};

socket.onmessage = (event) =>{

} 



const renderList = (data) =>{

	const list = document.getElementById('list_chat');
	list.innerHTML = "";

	data.forEach(item => {
		list.innerHTML += `
			<div id="${item.partner_username}" class="inbox-card" onclick="showInboxBox('${item.partner_fullname}', '${item.isOnline}', '${item.partner_username}'); resetNotification(this)">
				<img id="avt" src="../asset/logo.png" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${item.partner_fullname}</span>
					<span class="notify ${item.number_unread === 0 ? "hidden": ""}">${item.number_unread}</span>
				</div>
				<div class="message-card">
					<span id="status_l" >${item.isOnline == 0 ? '' : 'Online'}</span>
				</div>
			</div>
		`
	});
}

