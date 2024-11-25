<div id="form" onkeyup="submitLogin(event)">
	<h1>Login</h1>
	<div>
		<label for="username">username</label>
		<input id="username" name="username" type="text">
	</div>

	<div>
		<label for="password">password</label>
		<input id="password" name="password	" type="text">
	</div>

	<button type="button" onclick="login()">Login</button>

	<a onclick="toRegister()">Register</a>
</div>