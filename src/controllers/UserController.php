<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../helpers/Util.php';
require_once __DIR__ . '/../helpers/Auth.php';



class UserController
{

	private $userModel;
	private $validation;
	private $util;
	private $auth;

	public function __construct()
	{
		session_start();

		$this->userModel = new UserModel();
		$this->validation = new Validation();
		$this->util = new Util();
		$this->auth = new Auth();
	}

	public function login()
	{
		$input = json_decode(file_get_contents('php://input'), true);

		$username = $this->validation->clearInput($input['username']);
		$password = $this->validation->clearInput($input['password']);
		$remember = (int) $this->validation->clearInput($input['remember']);

		$this->validation->validateAuthen('username', $username);
		$this->validation->validateAuthen('password', $password);


		$user = $this->userModel->check_authen($username, $password);

		if ($user) {

			if ($remember === 1) {
				$this->auth->generate_JWT(['fullname' => $user['fullname']]);
			}

			$_SESSION['username'] = $user['username'];
			$_SESSION['fullname'] = $user['fullname'];


			$this->util->sendData(true, 'Login successfully');
		} else {
			$this->util->sendData(false, 'Username or password is invalid');
		}
	}


	public function register()
	{
		$input = json_decode(file_get_contents('php://input'), true);

		$username = $this->validation->clearInput($input['username']);
		$password =  $this->validation->clearInput($input['password']);
		$firstname =  $this->validation->clearInput($input['firstname']);
		$lastname =  $this->validation->clearInput($input['lastname']);
		$confirm_password = $this->validation->clearInput($input['confirm_password']);

		$this->validation->validateAuthen('firstname', $firstname);
		$this->validation->validateAuthen('lastname', $lastname);
		$this->validation->validateAuthen('username', $username);
		$this->validation->validateAuthen('password', $password);
		$this->validation->validateAuthen('confirm_password', $confirm_password, $password);

		$fullname = "$firstname $lastname";

		$result = $this->userModel->register_account($username, $password, $fullname);

		if ($result) {
			$this->util->sendData(true, 'Register successfully');
		} else {
			$this->util->sendData(false, 'User already exist');
		}
	}

	public function list()
	{
		$username  = $_SESSION['username'];


		$result = $this->userModel->get_list_user($username);

		if ($result) {
			$this->util->sendData(true, 'get list successfully', ['list' => $result]);
		} else {
			$this->util->sendData(true, 'get list failed');
		}
	}

	public function check_login()
	{
		$auth = $this->auth->checkAuth();
		
		if(!$auth){
			$this->util->sendData(false);
		}

		$this->util->sendData(true, '', ['username' => $_SESSION['username']]);

	}


	public function logout()
	{
		session_unset();
		session_destroy();
		$this->util->clearCookie('auth');

		echo json_encode([
			'message' => 'user is logged out',
			'isLogin' => false,
		]);
	}
}
