

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



const renderList = (data) =>{

	const list = document.getElementById('list_chat');
	list.innerHTML = "";

	data.forEach(item => {
		list.innerHTML += `
			<div id="${item.username}" class="inbox-card" onclick="showInboxBox('${item.fullname}', '${item.isOnline}', '${item.username}')">
				<img id="avt" src="../asset/logo.png" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${item.fullname}</span>
					<span id="notify">10</span>
				</div>
				<div class="message-card">
					<span id="status_l" >${item.isOnline == 0 ? '' : 'Online'}</span>
				</div>
			</div>
		`
	});
}

