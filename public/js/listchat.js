(async()=>{
	const response  = await fetch ('/list', {
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

})();


const toBoxchat = (partnerId) =>{
	location.href = `../../src/views/boxchat.php?partner=${partnerId}`;
}