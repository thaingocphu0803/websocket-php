<?php
require_once __DIR__ . '/../../../src/helpers/Auth.php';
session_start();

$auth = new Auth();

$username = $auth->checkAuth();

?>
<div class="dropdown">
	<img src="../../asset/logo.png" alt="user's avatar" id="avt">
</div>
<div id="sender"><?= $username ?></div>
<button type="button" onclick="logout()">logout</button>