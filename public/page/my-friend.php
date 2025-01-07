<div id="fiend_container">
	<?php
	require_once __DIR__ . '/components/header.php'
	?>

	<div id="main">
		<!-- start list inivte -->
		<div id="list_request">
			<div class="request-btn-group">
				<button class="tabBtn active boder-radius-left" onclick="openTabContent(event, `friend_request`)">Friend Request</button>
				<button class="tabBtn" onclick="openTabContent(event, `friend_request_sent`)">Friend Request Send</button>
				<button class="tabBtn boder-radius-right" onclick="openTabContent(event, `search_people`)">Adding friend</button>
			</div>

			<div id="friend_request" class="tabcontent">
				<div id="" class="user-request-card">
					<img id="avt" src=" ../asset/logo.webp" alt="user's avatar" width="50px" height="50px">
					<div id="title">
						<span id="fullname_l">Phu</span>
						<div class="group-request-btn">
							<button class="request-btn" title="Click to accept friend request" onclick="handleFriendRequest()">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16px" height="16px">
									<path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
								</svg>
							</button>
							<button class="request-btn" title="Click to reject friend request" onclick="handleFriendRequest(true)">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  width="16px" height="16px">
									<path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
								</svg>
							</button>
						</div>
					</div>

					<span id="request_message"></span>
				</div>
			</div>

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