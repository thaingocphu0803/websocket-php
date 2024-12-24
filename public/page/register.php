<div id="form-container">

	<?php
	require_once __DIR__ . "/components/alert.php";
	?>

	<div class="align-flex-end">
		<?php include_once __DIR__ . "/components/logo.php" ?>
	</div>

	<form id='form_register' onkeyup="submitRegister(event)">

		<h1>Register</h1>

		<div id="full_name">
			<input
				id="firstname"
				name="username"
				type="text"
				placeholder="First name"
				title="Must be character.">
			<input
				id="lastname"
				name="username"
				type="text"
				placeholder="Last name"
				title="Must be character.">
		</div>


		<div class="from-input">
			<label for="username">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
					<path fill="#464447" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
				</svg>
			</label>
			<input
				id="username"
				name="username"
				type="text"
				placeholder="Create an username"
				title="Must be at least 6 characters">
		</div>

		<div class="from-input">
			<label for="password">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
					<path fill="#464447" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
				</svg>
			</label>
			<input
				id="password"
				name="password"
				type="password"
				placeholder="Create a password"
				title="Must be at least 8 character and include one uppercase letter, one lowercase letter, one number, one special character.">
		</div>

		<div class="from-input">
			<label for="confirm_password">
				<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
					<path fill="#464447" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
				</svg>
			</label>
			<input
				id="confirm_password"
				name="confirm_password"
				type="password"
				placeholder="Confirm a password">
		</div>

		<span class="error"></span>

		<button class="form-btn" type="button" onclick="register()">Register</button>

		<div class="next-page" onclick="toLogin()">
			<span>Return To Login</span>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="24" width="24">
				<path fill="#464447" d="M125.7 160l50.3 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L48 224c-17.7 0-32-14.3-32-32L16 64c0-17.7 14.3-32 32-32s32 14.3 32 32l0 51.2L97.6 97.6c87.5-87.5 229.3-87.5 316.8 0s87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3s-163.8-62.5-226.3 0L125.7 160z" />
			</svg>
		</div>


	</form>
</div>