<?php
require_once __DIR__ . '/../../config.php';

class Util {
	public function sendData($status, $message = null, $data = []){

		$api = [
			'status' => $status,
			'message' => $message,
			'data' => $data
		];

		echo json_encode($api);
		exit;
	}

	public function setCookie($name, $value)
	{
		setcookie($name, $value, [
			"expires" => time() + 3600*24,
			"path" => "/",
			"domain" => DOMAIN_NAME,
			"secure" => false,
			"httponly" => true,
			"samesite" => "Strict"
		]);
	}
	public function getCookie($name)
	{
		if (isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		}

		return null;
	}
	//clear cookie
	public function clearCookie($name)
	{
		setcookie($name, "", [
			"expires" => time() - 3600,
			"path" => "/",
			"domain" => DOMAIN_NAME,
			"secure" => false,
			"httponly" => true,
			"samesite" => "Strict"
		]);
	}
}