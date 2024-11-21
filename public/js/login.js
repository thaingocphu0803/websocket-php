document.getElementById('form').addEventListener('keydown', async(event) => {
	if(event.key === "Enter"){
		await submit();
	}
})

const submit = async () => {
	const input = {
		username : document.getElementById('username').value,
		password : document.getElementById('password').value,
	}

	const formData = {
		username: input.username,
		password: input.password
	}

	const response = await  fetch('/login', {
		method: 'post',
		body: JSON.stringify(formData)
	})

	const data = await response.json();

	if(!data.isLogin){
		alert (data.message);
		return;
	} ;

	location.href = `../../src/views/listchat.php`;
}