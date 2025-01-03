<?php
require_once __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/Util.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{	
	private $util;

	public function __construct()
	{	
		$this->util = new Util();
	}

	public function checkAuth()
	{
		$jwt = $this->util->getCookie('auth');

		if(!empty($_SESSION)){

			$auth = [
				'fullname' => $_SESSION['fullname'],
				'username' => $_SESSION['username'],
				'avatar' => $_SESSION['avatar']
			];
			return (object) $auth;

		}elseif($jwt){
			$auth =  $this->retrieve_JWT($jwt);
			return $auth;		
		}
	}

	public function generate_JWT($payload = [])
	{
		$jwt = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');

		if($jwt){
			$this->util->setCookie('auth', $jwt);
		}
	}

	public function retrieve_JWT($jwt){
		$decoded = JWT::decode($jwt, new Key(JWT_SECRET_KEY, 'HS256'));
		return $decoded;
	}

}
