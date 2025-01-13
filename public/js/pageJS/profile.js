const returnToDashboard = () => {
	const confirmModal = document.getElementById("confirm_modal");
	document.getElementById("confirm_message").textContent =
		"Return to dashboard without saving?";

	if (confirmModal.classList.contains("hidden")) {
		confirmModal.classList.remove("hidden");
	}

	document.getElementById("yes").addEventListener("click", () => {
		Navigate(`/dashboard`);
	});
};

const openEditFullName = (editButton) => {
	const fullNameProfile = document.getElementById("fullname_profile");
	const saveFullName = document.getElementById("save_fullname");
	const cancelFullName = document.getElementById("cancel_fullname");

	fullNameProfile.disabled = false;
	fullNameProfile.value = "";
	fullNameProfile.focus();
	if (!editButton.classList.contains("hidden")) {
		editButton.classList.add("hidden");
	}

	if (
		saveFullName.classList.contains("hidden") &&
		cancelFullName.classList.contains("hidden")
	) {
		saveFullName.classList.remove("hidden");
		cancelFullName.classList.remove("hidden");
	}
};

const handleSaveFullName = async (saveFullName) => {
	const editButton = document.getElementById("update_fullname_btn");
	const cancelFullName = document.getElementById("cancel_fullname");
	const fullNameInput = document.getElementById("fullname_profile");

	const fullNameProfile = fullNameInput.value
		? fullNameInput.value.trim()
		: fullNameInput.placeholder.trim();

	if(!validateFullNameInput(fullNameProfile)) return;

	const data = await changeFullName(fullNameProfile);

	if (data.status) {
		showSuccess(data.message);
		fullNameInput.placeholder = fullNameProfile;
		document.getElementById("fullname").textContent = fullNameProfile;

		if (
			!saveFullName.classList.contains("hidden") &&
			!cancelFullName.classList.contains("hidden")
		) {
			saveFullName.classList.add("hidden");
			cancelFullName.classList.add("hidden");
		}

		if (editButton.classList.contains("hidden")) {
			editButton.classList.remove("hidden");
		}

		if (fullNameInput.disabled === false) fullNameInput.disabled = true;
	} else {
		clearInvalidStyle();
		setError(data.message);
	}
};

const validateFullNameInput = (fullNameProfile) => {
	const RegFullName = /^[\p{L} ]+$/u;
	const errorMessage = "Full name is incorrect format.";

	if (!RegFullName.test(fullNameProfile)) {
		return setError(errorMessage);
	}

	return true;
};

const changeFullName = async (fullNameProfile) => {
	const response = await fetch(`/${endpoint}/change-fullname`, {
		method: "post",
		body: JSON.stringify({ fullname: fullNameProfile }),
	});

	const data = await response.json();

	return data;
};

const handleCancelFullName = (cancelFullName) => {
	const editButton = document.getElementById("update_fullname_btn");
	const saveFullName = document.getElementById("save_fullname");
	const fullNameInput = document.getElementById("fullname_profile");

	fullNameInput.value = fullNameInput.placeholder.trim();

	if (
		!saveFullName.classList.contains("hidden") &&
		!cancelFullName.classList.contains("hidden")
	) {
		saveFullName.classList.add("hidden");
		cancelFullName.classList.add("hidden");
	}

	if (editButton.classList.contains("hidden")) {
		editButton.classList.remove("hidden");
	}

	if (fullNameInput.disabled === false) fullNameInput.disabled = true;
};

const handleChangePassword = async () => {
	const password = {
		current: document.getElementById("current_password"),
		new: document.getElementById("new_password"),
		confirmNew: document.getElementById("confirm_new_password"),
	};

	if (!validateChangePassword(password)) return;

	const formData = {
		current_pssw: password.current.value.trim(),
		new_pssw: password.new.value.trim(),
	};

	const data = await changePassWord(formData);

	if (data.status) {
		clearInvalidStyle();

		clearChangePasswordError();

		clearInput(password.current);
		clearInput(password.new);
		clearInput(password.confirmNew);

		showSuccess(data.message);
	} else {
		const invalidInput =
			document.getElementById(`${data.property}`) ?? null;
		clearInvalidStyle();
		handleInvalid(invalidInput);
		setErrorChangePassword(data.message);
	}
};

const validateChangePassword = (password) => {
	const regPassword =
		/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

	let message = null;

	clearInvalidStyle();

	if (!password.current.value) {
		message = "Please enter your current password";
		handleInvalid(password.current);
		return setErrorChangePassword(message);
	} else if (!password.new.value) {
		message = "Please enter the new password";
		handleInvalid(password.new);
		return setErrorChangePassword(message);
	} else if (!password.confirmNew.value) {
		message = "please enter the confirm new password";
		handleInvalid(password.confirmNew);
		return setErrorChangePassword(message);
	} else if (!regPassword.test(password.new.value)) {
		message = "New Password is incorrect format";
		handleInvalid(password.new);
		return setErrorChangePassword(message);
	} else if (password.new.value === password.current.value) {
		message = "The new password must be diffirent the current password";
		handleInvalid(password.new);
		return setErrorChangePassword(message);
	} else if (password.new.value !== password.confirmNew.value) {
		message = "The confirm new password is incorrect";
		handleInvalid(password.confirmNew);
		return setErrorChangePassword(message);
	}

	return true;
};

const setErrorChangePassword = (message) => {
	const error = document.getElementById("change_pass_error");

	error.textContent = message;
	error.style.display = "block";

	return false;
};

const clearChangePasswordError = () => {
	const error = document.getElementById("change_pass_error");
	error.textContent = "";
	error.style.display = "none";
};

const changePassWord = async (formData) => {
	try {
		const response = await fetch(`/${endpoint}/change-password`, {
			method: "post",
			body: JSON.stringify(formData),
		});

		const data = await response.json();

		return data;
	} catch (err) {
		console.log(err);
	}
};

const handleUploadAvatar = async () => {
	const formData = new FormData();
	const imageAvatar = document.getElementById("user_avt").files[0];

	formData.append("avatar", imageAvatar);

	const response = await fetch(`/${endpoint}/change-avatar`, {
		method: "post",
		body: formData,
	});

	const data = await response.json();

	if(data.status){

		document.getElementById('my_avatar').src = atob(data.data.avatarUrl);
		document.getElementById('header_avt').src = atob(data.data.avatarUrl);
		
		showSuccess(data.message);
	}else{
		showDanger(data.message);
	}
};
