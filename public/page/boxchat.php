<div id="box_chat_page">

	<?php require_once __DIR__. '/header.php' ?>
	
	<button type="button" onclick="logout()">logout</button>
	<div id="message_box"></div>
	<input type="text" id="message"></input>
	<button type="button" onclick="sendMessage()">send</button>
</div>