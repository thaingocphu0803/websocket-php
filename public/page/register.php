<div id="register_page">
	<h1>Register</h1>

	<div id='form' onkeyup="submitRegister(event)">
		<label for="username">username</label>
		<input id="username" name="username" type="text">
	</div>

	<div>
		<label for="password">password</label>
		<input id="password" name="password" type="password">
	</div>

	<button type="button" onclick="register()">Login</button>

	<a onclick="toLogin()">Login</a>

</div>