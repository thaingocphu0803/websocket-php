const login = async () => {
	const input = {
		username: document.getElementById("username"),
		password: document.getElementById("password"),
		remember: document.getElementById("remember"),
	};

	if (input.remember.checked) {
		input.remember.value = 1;
	} else {
		input.remember.value = 0;
	}

	if (!validateLogin(input)) return;

	const formData = {
		username: input.username.value,
		password: input.password.value,
		remember: input.remember.value,
	};

	try {
		const response = await fetch(`/${endpoint}/login`, {
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

		const message = {
			type: "userConnect",
			userConnect: data.data.username,
		};

		socket.send(JSON.stringify(message));

		showSuccess(data.message);
		clearError();
		document.getElementById("form_login").style.alignSelf = "start";

		setTimeout(() => {
			Navigate("/dashboard");
		}, 1000);
	} catch (err) {
		console.log(err);
	}
};

const toRegister = () => {
	Navigate("/register");
};

const submitLogin = (event) => {
	event.preventDefault();

	if (event.key === "Enter") {
		login();
	}
};

const validateLogin = (input) => {
	let message = null;

	const RegExp = {
		username: /^[a-zA-Z0-9._]{6,}$/,
		password:
			/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/,
	};

	clearInvalidStyle();

	if (!input.username.value) {
		message = "Please enter an username";
		handleInvalid(input.username);
		return setError(message);
	} else if (!input.password.value) {
		message = "Please enter a password name";
		handleInvalid(input.password);
		return setError(message);
	} else if (!RegExp.username.test(input.username.value)) {
		message = "Username is incorrect format";
		handleInvalid(input.username);
		return setError(message);
	} else if (!RegExp.password.test(input.password.value)) {
		message = "Password is incorrect format";
		handleInvalid(input.password);
		return setError(message);
	}

	return true;
};
