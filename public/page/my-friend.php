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
				<button class="tabBtn boder-radius-right" onclick="openTabContent(event, `search_people`)">Search For People</button>
			</div>

			<div id="friend_request" class="tabcontent">
				<div id="" class="user-request-card">
					<img id="avt" src=" ../asset/logo.webp" alt="user's avatar" width="50px" height="50px">
					<div id="title">
						<span id="fullname_l">Phu</span>
					</div>
					<div class="request-card">
						<span id="request_message"></span>
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
				</div>
			</div>

			<div id="friend_request_sent" class="tabcontent hidden">
				<div id="" class="user-request-card">
					<img id="avt" src=" ../asset/logo.webp" alt="user's avatar" width="50px" height="50px">
					<div id="title">
						<span id="fullname_l">Phu</span>
					</div>
					<div class="request-card">
						<span id="cancel_message">ssss</span>
						<button class="request-btn" title="Click to cancel friend request" onclick="CancelFriendRequest(this)">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
								<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM472 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
							</svg>
						</button>
					</div>
				</div>
			</div>

			<div id="search_people" class="tabcontent hidden">
				<input id="find_people" type="text" placeholder="Search for people....">

				<div id="" class="user-request-card">
					<img id="avt" src=" ../asset/logo.webp" alt="user's avatar" width="50px" height="50px">
					<div id="title">
						<span id="fullname_l">Phu</span>
					</div>
					<div class="request-card">
						<span></span>
						<button class="request-btn" title="Click to send friend request" id="click_send_btn" onclick="handleSendFriendRequest(this)">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
								<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
							</svg>
						</button>
						<button class="request-btn hidden" id="cancel_send_btn" title="Click to cancel friend request" onclick="handleCancelFriendRequest(this)">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px" height="16px">
								<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM472 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- end list inivte -->

		<!-- start list friend -->
		<div id="list_friend">list friend</div>
		<!-- start list friend -->
	</div>
</div>