const register = async () => {
	const input = {
		username: document.getElementById("username"),
		password: document.getElementById("password"),
		confirmPass: document.getElementById("confirm_password"),
		fistname: document.getElementById("firstname"),
		lastname: document.getElementById("lastname"),
	};

	const firstName = handleName(input.fistname);
	const lastName = handleName(input.lastname);

	if (!validateRegister(input)) return;

	const formData = {
		username: input.username.value,
		password: input.password.value,
		firstname: firstName,
		lastname: lastName,
		confirm_password: input.confirmPass.value,
	};

	try {
		const response = await fetch(`/${endpoint}/register`, {
			method: "post",
			body: JSON.stringify(formData),
		});

		const data = await response.json();

		if (!data.status) {
			const invalidInput =
				document.getElementById(`${data.property}`) ?? null;

			clearInvalidStyle();
			setError(data.message);

			if (invalidInput) {
				handleInvalid(invalidInput);
			}
			return;
		}

		showSuccess(data.message);
		clearError();

		setTimeout(() => {
			Navigate("/login");
		}, 1000);
	} catch (err) {
		console.log(err);
	}
};

const submitRegister = (event) => {
	event.preventDefault();

	if (event.key === "Enter") {
		register();
	}
};

const toLogin = () => {
	Navigate("/login");
};

const validateRegister = (input) => {
	let message = null;

	const RegExp = {
		fistname: /^[\p{L} ]+$/u,
		lastname: /^[\p{L} ]+$/u,
		username: /^[a-zA-Z0-9._]{6,}$/,
		password:
			/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/,
	};

	clearInvalidStyle();

	if (!input.fistname.value) {
		message = "Please enter your first name";
		handleInvalid(input.fistname);
		return setError(message);
	} else if (!input.lastname.value) {
		message = "Please enter your last name";
		handleInvalid(input.lastname);
		return setError(message);
	} else if (!input.username.value) {
		message = "Please enter an username";
		handleInvalid(input.username);
		return setError(message);
	} else if (!input.password.value) {
		message = "Please enter a password name";
		handleInvalid(input.password);
		return setError(message);
	} else if (!input.confirmPass.value) {
		message = "Please enter password again";
		handleInvalid(input.confirmPass);
		return setError(message);
	} else if (!RegExp.fistname.test(input.fistname.value)) {
		message = "The first name is incorrect format";
		handleInvalid(input.fistname);
		return setError(message);
	} else if (!RegExp.lastname.test(input.lastname.value)) {
		message = "The last name is incorrect format";
		handleInvalid(input.lastname);
		return setError(message);
	} else if (!RegExp.username.test(input.username.value)) {
		message = "The username is incorrect format";
		handleInvalid(input.username);
		return setError(message);
	} else if (!RegExp.password.test(input.password.value)) {
		message = "The password is incorrect format";
		handleInvalid(input.password);
		return setError(message);
	} else if (input.password.value !== input.confirmPass.value) {
		message = "The confirm password is not matched";
		handleInvalid(input.confirmPass);
		return setError(message);
	}

	return true;
};

const handleName = (input) => {
	const uppercaseName =
		input.value.charAt(0).toUpperCase() + input.value.slice(1);
	input.value = uppercaseName;

	return uppercaseName;
};
