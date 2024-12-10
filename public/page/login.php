<div id="form" onkeyup="submitLogin(event)">
	<h1>LOGIN</h1>
	<div class="from-input">
		<label for="username">USERNAME</label>
		<input id="username" name="username" type="text">
	</div>

	<div class="from-input">
		<label for="password">PASSWORD</label>
		<input id="password" name="password" type="password">
	</div>

	<button class="form-btn" type="button" onclick="login()">Login</button>

	<a onclick="toRegister()">Create your account</a>
</div>