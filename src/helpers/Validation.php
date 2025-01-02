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

	public function validateAuthen($option, $input, $password = null)
	{
		$regUsername = "/^[a-zA-Z0-9._]{6,}$/";
		$regPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";
		$regName = "/^[\p{L} ]+$/u";

		if ($option === 'firstname' || $option === 'lastname') {
			$subname = str_replace("n", " n", $option);
		} elseif ($option === 'confirm_password') {
			$subname = str_replace("_", " ", $option);
		}

		if (empty($input)) {
			if (!empty($subname)) {
				$this->sendOutputValidate(false, "Please enter your $subname", $option);
			} else {
				$this->sendOutputValidate(false, "Please enter your $option", $option);
			}
		}

		switch ($option) {
			case 'username':
				if (!preg_match($regUsername, $input)) {
					$this->sendOutputValidate(false, "The $option is incorrect format", $option);
				}
				break;
			case 'password':
				if (!preg_match($regPassword, $input)) {
					$this->sendOutputValidate(false, "The $option is incorrect format", $option);
				}
				break;
			case 'firstname':
			case 'lastname':
			case 'fullname':
				if (!preg_match($regName, $input)) {
					$this->sendOutputValidate(false, "The $subname is incorrect format", $option);
				}
				break;
			case 'confirm_password':
				if ($input !== $password) {
					$this->sendOutputValidate(false, "The $subname is not matched", $option);
				}
				break;
			default:
				break;
		}
	}

	public function ValidatePassword($option, $input)
	{


		$regPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";

		$pssw  = isset($_SESSION['pssw']) ? $_SESSION['pssw'] : null;


		$subname = str_replace("_", " ", $option);

		switch ($option) {
			case 'current_password':
				if(empty($input)){
					$this->sendOutputValidate(false, "Please enter your $subname", $option);
				}
				else if (!password_verify($input, $pssw)) {
					$this->sendOutputValidate(false, "The $subname is incorrect", $option);
				}
				break;
			case 'new_password':
				if(empty($input)){
					$this->sendOutputValidate(false, "Please enter your $subname", $option);
				}
				else if (!preg_match($regPassword, $input)) {
					$this->sendOutputValidate(false, "The $subname is incorrect format", $option);
				} else if (password_verify($input, $pssw)) {
					$this->sendOutputValidate(false, "The $subname must be diffirent the current password", $option);
				}
				break;
			default:
				break;
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
