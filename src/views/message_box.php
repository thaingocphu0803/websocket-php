<html>

<head>
	<style>
		input,
		button {
			padding: 10px;
		}
	</style>
</head>

<body>
	<div id="message_box"></div>
	<input type="text" id="message"></input>
	<button type="button" onclick="sendMessage()">send</button>
	
	<script>

		const socket = new WebSocket('ws://localhost:9000');

		socket.onopen = function () {
			console.log('WebSocket đã mở.');
		};

		const sendMessage = () => {
			const message = document.getElementById("message").value;
			document.getElementById("message_box").innerHTML += `<p style="color:red"> Me: ${message}</p>`
			socket.send(message);
		}

		socket.onmessage = function (event) {
			document.getElementById("message_box").innerHTML += `<p> Player: ${event.data}</p>`
		};

		socket.onerror = function (error) {
			console.error('Đã xảy ra lỗi WebSocket:', error);
		};

		socket.onclose = function () {
			console.log('WebSocket đã đóng.');
		};

	</script>
</body>

</html>