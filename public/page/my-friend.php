<div id="fiend_container">
	<?php
	require_once __DIR__ . '/components/header.php'
	?>

	<div id="main">
		<!-- start list inivte -->
		<div id="list_request">
			<div class="request-btn-group">
				<button class="tabBtn active boder-radius-left" onclick="openTabContent(event, `friend_request`)">Friend Request</button>
				<button class="tabBtn" onclick="openTabContent(event, `friend_request_sent`)">Having been sent</button>
				<button class="tabBtn boder-radius-right" onclick="openTabContent(event, `search_people`)">Adding friend</button>
			</div>

			<div id="friend_request" class="tabcontent"></div>

			<div id="friend_request_sent" class="tabcontent hidden"></div>

			<div id="search_people" class="tabcontent hidden">
				<input id="find_people" type="text" placeholder="Searching by user's name..." oninput="handleSearchPeople(event)">

				<div id="people_card"></div>
			</div>
		</div>
		<!-- end list inivte -->

		<!-- start list friend -->
		<div class="list_friend">
			<h2 id="title_list_friend">List Friend</h2>
			<div id="list_content">
				<div id="friend_card">
					<img id="friend_avt" src="../asset/logo.webp" alt="friend avatar" width="180px" height="180px">
					<p id="friend_name">Thai Phu</p>
					<button id="delete_friend" onclick="handleSendFriendRequest(this, `add_friend`)" class="request-btn">Delete Friend</button>
					<button id="add_friend" onclick="handleSendFriendRequest(this, `delete_friend`)" class="request-btn hidden">Add Friend</button>
				</div>
			</div>
		</div>
		<!-- start list friend -->
	</div>
</div>