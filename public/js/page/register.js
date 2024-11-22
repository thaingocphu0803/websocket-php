const renderRegister = () => {
	return `
		<h1>Register</h1>

	<div>

		<div id='form'>
			<label for="username">username</label>
			<input id="username" name="username" type="text">
		</div>

		<div>
			<label for="password">password</label>
			<input id="password" name="password" type="password">
		</div>

		<button type="button" onclick="register()">Login</button>

	</div>

	<a href="#" onclick="toLogin()">Register</a>

	<script src="../../public/js/register.js" defer></script>
	`
}

const register = async () => {
	const input = {
		username : document.getElementById('username').value,
		password : document.getElementById('password').value,
	}

	const formData = {
		username: input.username,
		password: input.password
	}

	const response = await  fetch(`/public/${endpoint}/register`, {
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

const toLogin =  () =>{
	Navigate('/login');
} 