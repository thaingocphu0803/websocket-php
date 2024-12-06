

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

const toBoxchat = (receiver) =>{	
	const sender = document.getElementById("sender").textContent;
	currentRoom = [sender, receiver].sort().join('_');

	Navigate(`/boxchat/${receiver}`);
}

