const register = async () => {
	const input = {
		username : document.getElementById('username').value,
		password : document.getElementById('password').value,
	}

	const formData = {
		username: input.username,
		password: input.password
	}

	const response = await  fetch(`/${endpoint}/register`, {
		method: 'post',
		body: JSON.stringify(formData)
	})

	const data = await response.json();

	if(!data.isRegister){
		alert (data.message);
		return;
	} ;

	alert (data.message);

	Navigate('/login');
}

const submitRegister = (event) =>{
	if(event.key === 'Enter'){
		register()
	}
}

const toLogin =  () =>{
	Navigate('/login');
}