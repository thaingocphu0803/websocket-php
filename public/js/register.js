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

	const response = await  fetch('/register', {
		method: 'post',
		body: JSON.stringify(formData)
	})

	const data = await response.json();

	if(!data.isRegister){
		alert (data.message);
		return;
	} ;

	alert (data.message);

	location.href = `../../src/views/login.php`;
}