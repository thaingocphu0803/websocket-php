<?php 
	session_start();

	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}
?>

<div id="sender"><?= $username?></div>
