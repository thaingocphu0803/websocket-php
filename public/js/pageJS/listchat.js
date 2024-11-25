const listApi= async()=>{
	const response  = await fetch (`/${endpoint}/list`, {
		method:'post'
	})

	const data = await response.json();

	const list = document.getElementById('list_chat');

	data.list.forEach(user => {
		list.innerHTML += `
			<div id=${user.username}" onclick="toBoxchat('${user.username}')">
				<span style="border: 1px solid black;">${user.username}</span>
			</div>
		`
	});

};

const toBoxchat = (partnerId) =>{	
	Navigate(`/boxchat/${partnerId}`);
}

