
const renderLogin = () => {
	return `
		<h1>Login</h1>

		<div id="form">
			<div>
				<label for="username">username</label>
				<input id="username" name="username" type="text">
			</div>

			<div>
				<label for="password">password</label>
				<input id="password" name="password	" type="text">
			</div>

			<button type="button" onclick="submit()">Login</button>
		</div>

		<a href="#" onclick="toRegister()">Register</a>
	`
}

const submit = async () => {
	const input = {
		username : document.getElementById('username').value,
		password : document.getElementById('password').value,
	}

	const formData = {
		username: input.username,
		password: input.password
	}

	const response = await  fetch(`/public/${endpoint}/login`, {
		method: 'post',
		body: JSON.stringify(formData)
	})

	const data = await response.json();

	if(!data.isLogin){
		alert (data.message);
		return;
	};

	Navigate('/list')
}

const toRegister = () => {
	Navigate('/register');
}