<?php

class ValidateHepler {
	public function clearInput($input){
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	public function validateUsername($input){
		$regExp ="/^[a-zA-Z0-9._]{6,}$/";
	}
	public function validatePassword($input){
		$regExp ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/";

	}
	public function validateFullname($input){
		$regExp ="/^[A-Za-z]+$/";
	}
}