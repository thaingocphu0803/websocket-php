const showSuccess = (message) => {
	const element = {
		alertModel: document.getElementById("alert_modal"),
		iconSuccess: document.getElementById("icon_success"),
		iconDanger: document.getElementById("icon_danger"),
		message: document.getElementById("alert_message"),
	};
	element.message.textContent = message;
	element.alertModel.classList.remove("hidden");

	if(!element.alertModel.classList.contains('success')){
		element.alertModel.classList.add("success");
	}

	
	if(element.alertModel.classList.contains('danger')){
		element.alertModel.classList.remove("danger");
	}


	if (element.iconSuccess.classList.contains("hidden")) {
		element.iconSuccess.classList.remove("hidden");
	}

	if (!element.iconDanger.classList.contains("hidden")) {
		element.iconDanger.classList.add("hidden");
	}

	closeAlertmodal(element.alertModel);
};

const showDanger = (message) => {
	const element = {
		alertModel: document.getElementById("alert_modal"),
		iconSuccess: document.getElementById("icon_success"),
		iconDanger: document.getElementById("icon_danger"),
		message: document.getElementById("alert_message"),
	};
	element.message.textContent = message;
	element.alertModel.classList.remove("hidden");

	if(element.alertModel.classList.contains('success')){
		element.alertModel.classList.remove("success");
	}

	if(!element.alertModel.classList.contains('danger')){
		element.alertModel.classList.add("danger");
	}


	if (element.iconDanger.classList.contains("hidden")) {
		element.iconDanger.classList.remove("hidden");
	}

	if (!element.iconSuccess.classList.contains("hidden")) {
		element.iconSuccess.classList.add("hidden");
	}

	closeAlertmodal(element.alertModel);
};

const closeAlertmodal = (alertModel) => {
	setTimeout(() => {
		 if(!alertModel.classList.contains('hidden')){
			alertModel.classList.add('hidden');
		 }
	}, 2000)
}

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

const clearInput = (input) => {
	input.value = ''
}

const clearInvalidStyle = () => {
	const invalidInput = document.getElementsByClassName("input-invalid");

	Array.from(invalidInput).forEach((element) => {
		element.classList.remove("input-invalid");
	});
};
