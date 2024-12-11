const register = async () => {
	const input = {
		username: document.getElementById("username"),
		password: document.getElementById("password"),
		confirmPass: document.getElementById("confirm_pass"),
		fistname: document.getElementById("first_name"),
		lastname: document.getElementById("last_name"),
	};

	const fistName = handleName(input.fistname);
	const lastName = handleName(input.lastname);

	//validate
	if(!validate(input)) return;

	const formData = {
		username: input.username.value,
		password: input.password.value,
		fullname: `${fistName} ${lastName}`,
	};

	console.log(formData);

	const response = await fetch(`/${endpoint}/register`, {
		method: "post",
		body: JSON.stringify(formData),
	});

	const data = await response.json();

	if (!data.status) {
		setError(data.message)
		return;
	}

	alert(data.message);

	Navigate("/login");
};

const submitRegister = (event) => {
	if (event.key === "Enter") {
		register();
	}
};

const toLogin = () => {
	Navigate("/login");
};

const validate = (input) => {
	let message = null;

	const RegExp = {
		fistname: /^[A-Za-z]+$/,
		lastname: /^[A-Za-z]+$/,
		username: /^[a-zA-Z0-9._]{6,}$/,
		password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/
	}

	clearInvalidStyle();

	if (!input.fistname.value) {
		message = "Please enter your first name";
		handleInvalid(input.fistname);
		return setError(message);
	} 
	else if (!input.lastname.value) {
		message = "Please enter your last name";
		handleInvalid(input.lastname);
		return setError(message);
	} 
	else if (!input.username.value) {
		message = "Please enter an username";
		handleInvalid(input.username);
		return setError(message);
	} 
	else if (!input.password.value) {
		message = "Please enter a password name";
		handleInvalid(input.password);
		return setError(message);
	} 
	else if (!input.confirmPass.value) {
		message = "Please enter password again";
		handleInvalid(input.confirmPass);
		return setError(message);
	}
	else if(!RegExp.fistname.test(input.fistname.value)){
		message ="First name is incorrect format"
		handleInvalid(input.fistname);
		return setError(message);
	} 
	else if(!RegExp.lastname.test(input.lastname.value)){
		message ="Last name is incorrect format"
		handleInvalid(input.lastname);
		return setError(message);
	} 
	else if(!RegExp.username.test(input.username.value)){
		message ="Username is incorrect format"
		handleInvalid(input.username);
		return setError(message);
	} 
	else if(!RegExp.password.test(input.password.value)){
		message ="Password is incorrect format"
		handleInvalid(input.password);
		return setError(message);
	} 
	else if (input.password.value !== input.confirmPass.value) {
		message = "An confirm password is not match";
		handleInvalid(input.confirmPass);
		return setError(message);
	}

	return true;

};

const setError = (message) => {
	const error = document.getElementsByClassName("error")[0];

	error.textContent = message;
	error.style.display = "block";

	return false;
};

const handleInvalid = (input) => {
	input.classList.add("input-invalid");
};

const clearInvalidStyle = () => {
	const invalidInput = document.getElementsByClassName("input-invalid");

	Array.from(invalidInput).forEach((element) => {
		element.classList.remove("input-invalid");
	});
};

const handleName = (input) => {
	const uppercaseName = input.value.charAt(0).toUpperCase() + input.value.slice(1);
	input.value = uppercaseName;

	return uppercaseName;

}
