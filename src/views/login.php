<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>

<body>
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

	<a href="./register.php">Register</a>

	<script src="../../public/js/login.js" defer></script>
</body>

</html>