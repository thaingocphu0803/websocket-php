<?php

class Validation
{
	public function clearInput($input)
	{
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	public function validateAuthen( $option, $input, $password = null)
	{
		$regUsername = "/^[a-zA-Z0-9._]{6,}$/";
		$regPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";
		$regName = "/^[\p{L}]+$/u";

		if ($option === 'firstname' || $option === 'lastname') {
			$subname = str_replace("n", " n", $option);
		} elseif ($option === 'confirm_password') {
			$subname = str_replace("_", " ", $option);
		}

		if (empty($input)) {
			if(!empty($subname)){
				$this->sendOutputValidate(false, "Please enter your $subname", $option);

			}else{
				$this->sendOutputValidate(false, "Please enter your $option", $option);
			}
		}

		switch ($option) {
			case 'username':
				if (!preg_match($regUsername, $input)) {
					$this->sendOutputValidate(false, "$option is incorrect format", $option);
				}
				break;
			case 'password':
				if (!preg_match($regPassword, $input)) {
					$this->sendOutputValidate(false, "$option is incorrect format", $option);
				}
				break;
			case 'firstname':
			case 'lastname':
				if (!preg_match($regName, $input)) {
					$this->sendOutputValidate(false, "$subname is incorrect format", $option);
				}
				break;
			case 'confirm_password':
				if($input !== $password){
					$this->sendOutputValidate(false, "$subname is not matched", $option);
				}
		}
	}

	public function validatePassword($input)
	{
		$regExp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";
		if (empty($input)) {
			$this->sendOutputValidate(false, 'Please enter your password', 'password');
		} else if (!preg_match($regExp, $input)) {
			$this->sendOutputValidate(false, 'Password is incorrect format', 'password');
		}
	}

	public function validateName($input, $option)
	{
		$regExp = "/^[A-Za-z]+$/";

		$subName = str_replace("n", " n", $option);
		// var_dump(empty($input));
		if (empty($input)) {
			$this->sendOutputValidate(false, "Please enter your $subName", $option);
		} else if (!preg_match($regExp, $input)) {
			$this->sendOutputValidate(false, "$subName is incorrect format", $option);
		}
	}

	public function sendOutputValidate(bool $status, $message = null, $property)
	{

		$api = [
			'status' => $status,
			'message' => $message,
			'property' => $property
		];

		echo json_encode($api);
		exit;
	}
}
