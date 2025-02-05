

const listApi= async()=>{	
	try{
		const response  = await fetch (`/${endpoint}/list`, {
			method:'post'
		})
	
		const data = await response.json();
	
		
		if(data.data.length === 0) return;

		renderList (data.data.list);
	
	
		const search = document.getElementById('search') ?? null;

		if(!search) return;
		
		search.addEventListener('input', ()=>{
			const query = search.value.toLowerCase();
	
			const filterData =  data.data.list.filter((item)=>{
				return item.partner_fullname.toLowerCase().includes(query);
			})
	
			renderList (filterData);
		})
		
	}catch(err){
		console.log(err);
	}
};

const renderList = (data) =>{

	const list = document.getElementById('list_chat') ?? null;

	if(!list) return; 

	list.innerHTML = "";
	data.forEach(item => {
		list.innerHTML += `
			<div id="item_${item.partner_username}" class="inbox-card" onclick="showInboxBox('${item.partner_fullname}', '${item.isOnline}', '${item.partner_username}'); resetNotification(this)">
				<img class="avt" src="${item.partner_avt ? atob(item.partner_avt) : `../asset/logo.webp`}" alt="user's avatar" width="50px" height="50px">
				<div id="title">
					<span id="fullname_l">${item.partner_fullname}</span>
					<span id="noti_${item.partner_username}" class="notify ${item.number_unread === 0 ? "hidden": ""}">${item.number_unread}</span>
				</div>
				<div class="message-card">
					<span id="status_l" >${item.isOnline == 0 ? '' : 'Online'}</span>
				</div>
			</div>
		`
	});
}
