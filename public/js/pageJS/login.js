const login = async () => {
	const input = {
		username : document.getElementById('username').value,
		password : document.getElementById('password').value,
	}

	const formData = {
		username: input.username,
		password: input.password
	}

	const response = await  fetch(`/${endpoint}/login`, {
		method: 'post',
		body: JSON.stringify(formData)
	})

	const data = await response.json();

	if(!data.isLogin){
		alert (data.message);
		return;
	};

	const message = {
		type: 'userConnect',
		userConnect: data.userId
	}

	socket.send(JSON.stringify(message))

	Navigate('/listchat');
	}

const toRegister = () => {
	Navigate('/register');
}



const submitLogin = (event) =>{
	if(event.key === 'Enter'){	
		login()
	}
}