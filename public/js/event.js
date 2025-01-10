const logout = async () => {
	setUserOffline();
	try {
		const response = await fetch(`/${endpoint}/logout`, {
			method: "post",
		});
		const data = await response.json();
		if (data.status) {
			Navigate("/login");
			return;
		}
	} catch (err) {
		console.log(err);
	}
};

// handle dropdown in home page
const handleDropdown = () => {
	const dropdown = {
		btn: document.getElementById("dropdown_btn"),
		content: document.getElementById("dropdown_content"),
	};

	const icon = {
		up: document.getElementById("icon-up"),
		down: document.getElementById("icon-down"),
	};

	if (dropdown.content.classList.contains("hidden")) {
		if (icon.down.classList.contains("hidden")) {
			icon.down.classList.remove("hidden");
			icon.up.classList.add("hidden");
		}
		dropdown.content.classList.remove("hidden");
	} else {
		icon.down.classList.add("hidden");
		icon.up.classList.remove("hidden");
		dropdown.content.classList.add("hidden");
	}
};

const unescapeHTML = (str) => {
	const doc = new DOMParser().parseFromString(str, "text/html");

	return doc.documentElement.textContent || doc.body.textContent;
};

const escapeHTML = (str) => {
	return str
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#39;");
};

const clearInbox = () => {
	document.getElementById("inbox_box").innerHTML = "";
};

socket.onerror = (error) => {
	console.error("Socket Error:", error);
};

//socket disconect
socket.onclose = () => {
	console.log("socket disconected");
};

// change user states when log out
const setUserOffline = () => {
	const sender = document.getElementById("username").textContent;

	const message = {
		type: "userDisconnect",
		userDisconect: sender,
	};

	socket.send(JSON.stringify(message));
};

//handle preview Upload images
const handleUploadImages = (event) => {
	const images = event.target.files;


	if (images.length < 0) return;

	const imagesArray = Array.from(images);

	handleImagesReader(imagesArray);
};

const handleImagesReader =  (array) => {
	clearPreviewImage();
	array.forEach((image) => {
		const reader = new FileReader();
		reader.onload = (event) => {
			renderPreviewImage(event, image);
		};
		reader.readAsDataURL(image);
	});
}

const renderPreviewImage = (event, arrayItem) => {
	const previewImage = document.getElementById("previewImage");
	previewImage.innerHTML += `
		<div id="${arrayItem.lastModified}" class="upload-image-container">
			<img class="image-upload" src="${event.target.result}" alt="" width="150px" height="150px">
			<span class="delete-btn" onclick="deleteUploadImage('${arrayItem.lastModified}')">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16px" height="16px">
					<path fill="#E00925"  d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
				</svg> 
			</span>
		</div>
	 `;
}



// delete preview upload image
const deleteUploadImage = (id) => {
	const imageUploadContainer = document.getElementById(id);

		imageUploadContainer && imageUploadContainer.remove();

	const inputFiles = document.getElementById('inbox_image');
	const images = Array.from(inputFiles.files);
	const updatedImages = images.filter(image => image.lastModified !== parseInt(id || 0));
	const dataTransfer = new DataTransfer();

	updatedImages.forEach(updatedImage => dataTransfer.items.add(updatedImage));
	inputFiles.files = dataTransfer.files;
};

const clearPreviewImage = () => {
	const previewImage = document.getElementById("previewImage");
	previewImage.innerHTML = "";
}

const playNotification = () => {
	
	if(window.localStorage.getItem('playSound') === true){
		const audio = document.getElementById("notify_sound");
		audio.play();	
	}
}

// handle confirm turn on notification sound
const closeConfirm = () => {
	const confirmModal = document.getElementById('confirm_modal');

	if(!confirmModal.classList.contains('hidden')){
		confirmModal.classList.add('hidden');
	}
}

const showConfirmPlaySound = () => {

	setTimeout(()=> {
		const confirmModal = document.getElementById('confirm_modal');
	 	document.getElementById('confirm_message').textContent = "Would you like to turn on notification sounds?"

		if(confirmModal.classList.contains('hidden')){
			confirmModal.classList.remove('hidden');
		}
	
		document.getElementById('yes').addEventListener('click', ()=> {
			window.localStorage.setItem('playSound', true)
		})
	}, 1000)

}

