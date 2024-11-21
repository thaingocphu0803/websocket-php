<?php
	session_start();
	
	$user = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>List Chat</title>
</head>
<body>
	<p>hello <?= $user ?></p>

	<div id="list_chat">

	</div>

	<script src="../../public/js/listchat.js" defer></script>
</body>
</html>