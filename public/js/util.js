const showSuccess = (message) => {
	const element = {
		alertModel: document.getElementById("alert_modal"),
		iconDanger: document.getElementById("icon_danger"),
		message: document.getElementById("alert_message"),
	};
	element.message.textContent = message;
	element.alertModel.classList.remove("hidden");
	element.alertModel.classList.add("success");
	if (!element.iconDanger.classList.contains("hidden")) {
		element.iconDanger.classList.add("hidden");
	}
};

const showDanger = (message) => {
	const element = {
		alertModel: document.getElementById("alert_modal"),
		iconSuccess: document.getElementById("icon_success"),
		message: document.getElementById("alert_message"),
	};
	element.message.textContent = message;
	element.alertModel.classList.add("danger");
	element.alertModel.classList.remove("hidden");
	if (!element.iconSuccess.classList.contains("hidden")) {
		element.iconSuccess.classList.add("hidden");
	}
};

const setError = (message) => {
	const error = document.getElementsByClassName("error")[0];

	error.textContent = message;
	error.style.display = "block";

	return false;
};

const clearError = () => {
	const error = document.getElementsByClassName("error")[0];
	error.textContent = '';
	error.style.display = "none";

}

const handleInvalid = (input) => {
	input.classList.add("input-invalid");
};

const clearInvalidStyle = () => {
	const invalidInput = document.getElementsByClassName("input-invalid");

	Array.from(invalidInput).forEach((element) => {
		element.classList.remove("input-invalid");
	});
};
