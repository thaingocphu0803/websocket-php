<div id="container">
	<?php
	//confirm form
	include_once __DIR__ . '/components/confirm.php';
	
	//header 
	require_once __DIR__ . '/components/header.php';
	?>

	<!-- start-main -->
	<div id="main">
		<!-- start-list-chat -->
		<?php
		require_once __DIR__ . '/components/list.php';
		?>
		<!-- end-list-chat -->

		<!-- start-inbox -->
		<?php
		require_once __DIR__ . '/components/inbox.php';
		?>
		<!-- end-inbox -->
	</div>

	<!-- end-main -->

</div>