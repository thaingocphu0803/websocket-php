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
			<img class="image-upload" src="${event.target.result}" alt="" width="100px" height="100px">
			<span class="delete-container-image" onclick="deleteUploadImage('${arrayItem.lastModified}')">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16px" height="16px">
					<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
				</svg> 
			</span>
		</div>
	 `;
}

// delete preview upload image
const deleteUploadImage = (id) => {
	const imageUploadContainer = document.getElementById(id);
	if (imageUploadContainer) {
		imageUploadContainer.remove();
	}

	const inputFiles = document.getElementById('inbox_image');
	const images = Array.from(inputFiles.files);
	const updatedImages = images.filter(image => image.lastModified !== parseInt(id));
	const dataTransfer = new DataTransfer();

	updatedImages.forEach(updatedImage => dataTransfer.items.add(updatedImage));
	inputFiles.files = dataTransfer.files;
};

const clearPreviewImage = () => {
	const previewImage = document.getElementById("previewImage");
	previewImage.innerHTML = "";
}