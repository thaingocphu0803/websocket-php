<div id="inbox_img"></div>
<div id="inbox" class="hidden">
	<div class="inbox-header">
		<img id="avt" src="../asset/logo.png" alt="user's avatar" width="50px" height="50px">
		<span id="fullname_b"></span>
		<span id="partner_username" class="hidden"></span>
		<span id="status_b"></span>
		<span id="close" onclick="closeInboxBox()">
			<svg fill="#BFB7C7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px" height="30px">
				<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
			</svg>
		</span>

	</div>

	<div class="inbox-body" id="inbox_box"></div>

	<div class="inbox-button">
		<textarea type="text" id="input_message" placeholder="Chatting..."></textarea>
		<button type="button" id="send_button" onclick="sendMessage()">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px" height="30px">
				<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm11.3-395.3l112 112c4.6 4.6 5.9 11.5 3.5 17.4s-8.3 9.9-14.8 9.9l-64 0 0 96c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32l0-96-64 0c-6.5 0-12.3-3.9-14.8-9.9s-1.1-12.9 3.5-17.4l112-112c6.2-6.2 16.4-6.2 22.6 0z" />
			</svg> </button>

	</div>
</div>