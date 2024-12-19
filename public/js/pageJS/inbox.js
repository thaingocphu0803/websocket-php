let currentOnline = null;

const sendMessage = () => {
  const from = document.getElementById("username").textContent;
  const text = document.getElementById("input_message").value.trim();
  const to = document.getElementById("partner_username").textContent;
  let sendComponent = document.getElementById("inbox_box");
  let sendDate = getSendDate();

  const room = [from, to].sort().join("_");

  if (!text) return;

  const message = {
    type: "sendMessage",
    room,
    from,
    to,
    date: sendDate,
    message: text,
  };

  socket.send(JSON.stringify(message));
  document.getElementById("input_message").value = "";

  sendComponent.innerHTML += `
		<div class="message-component right">
			<span id="time_send" class="datetime right">${sendDate}</span>
			<span id="message_send" class="left">${text}</span>
		</div>
	`;
};

socket.onmessage = (event) => {
  const objMessage = JSON.parse(event.data);

  if (objMessage.type === "sendMessage") {
    const from = document.getElementById("username").textContent;
    const to = document.getElementById("partner_username").textContent;
    let receiveComponent = document.getElementById("inbox_box");
    currentRoom = [from, to].sort().join("_");

    if (objMessage.room === currentRoom) {
      receiveComponent.innerHTML += `
			<div class="message-component left">
				<span id="time_receive" class="datetime right">${objMessage.date}</span>
				<span id="message_receive" class="left">${objMessage.message}</span>
			</div>
		`;
    }
  } else if (objMessage.type === "userConnect" && objMessage.isOnline === 1) {
    const userStatus = getUserStatus(objMessage.username);
    if (!userStatus) return;
    userStatus.textContent = "Online";
    currentOnline = objMessage.isOnline;
  } else if (
    objMessage.type === "userDisconnect" &&
    objMessage.isOnline === 0
  ) {
    const userStatus = getUserStatus(objMessage.username);
    if (!userStatus) return;
    userStatus.textContent = "";
    currentOnline = objMessage.isOnline;
  }
};

const getUserStatus = (element) => {
  const userCard = document.getElementById(`${element}`);
  if (!userCard) return;
  const userStatus = userCard.querySelector("#status_l");

  if (userStatus) return userStatus;
};

socket.onerror = (error) => {
  console.error("Socket Error:", error);
};

const getSendDate = () => {
  const date = new Date();

  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  const hours = String(date.getHours()).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");
  const seconds = String(date.getSeconds()).padStart(2, "0");

  const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

  return formattedDate;
};
