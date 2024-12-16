<?php 
	require_once __DIR__ . "/components/alert.php"; 
?>


<div id="form_login" onkeyup="submitLogin(event)">
	<h1>User Login</h1>
	<div class="from-input">
		<label for="username">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
				<path fill="#464447" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
			</svg>
		</label>
		<input id="username" name="username" type="text" placeholder="Enter your username">
	</div>

	<div class="from-input">
		<label for="password">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
				<path fill="#464447" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
			</svg>
		</label>
		<input id="password" name="password" type="password" placeholder="Enter your password">
	</div>

	<div class="check-box">
		<input type="checkbox" id="remember" name="remember">
		<label for="remember">Remember me</label>
	</div>

	<span class="error"></span>

	<button class="form-btn" type="button" onclick="login()">Login</button>

	<div class="next-page" onclick="toRegister()">
		<span>Create Your Account</span>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="24" width="24">
			<path fill="#464447" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
		</svg>
	</div>


</div>