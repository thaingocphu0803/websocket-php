<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/ValidateHelper.php';

class UserController {

	private $userModel;
	private $ValidateHelper;

	public function __construct()
	{
		session_start();

		$this->userModel = new UserModel();
		$this->ValidateHelper = new ValidateHepler();
	}

	public function login(){
		$input = json_decode(file_get_contents('php://input'), true);

		$username = $input['username'];
		$password = $input['password'];

		$user = $this->userModel->check_authen($username, $password);

		if($user){
			
			$_SESSION['username'] = $user['username'];
			
			echo json_encode([
				'message' => 'loggin successfull',
				'isLogin' => true,
				'userId' => $user['username']
			]);
		}else{
			echo json_encode([
				'message' => 'loggin fail',
				'isLogin' => false,
			]);
		}
	}


	public function register(){
		$input = json_decode(file_get_contents('php://input'), true);

		$username = $this->ValidateHelper->clearInput($input['username']);
		$password =  $this->ValidateHelper->clearInput($input['password']);
		$fullname =  $this->ValidateHelper->clearInput($input['fullname']);

		$result = $this->userModel->register_account($username, $password, $fullname);

		if($result){			
			echo json_encode([
				'message' => 'register successfull',
				'status' => true,
			]);
		}else{
			echo json_encode([
				'message' => 'User already exist',
				'status' => false,
			]);
		}
	}

	public function list(){
		$username  = $_SESSION['username'];


		$result = $this->userModel->get_list_user($username);

		if($result){
			echo json_encode([
				'message' => 'get list successfull',
				'list' => $result
			]);
		}else{
			echo json_encode([
				'message' => 'get list fail',
				'list' => null
			]);
		}
	}

	public function check_login(){
		if(!isset($_SESSION['username'])){

			echo json_encode([
				'message' => 'user is logged out',
				'isLogin' => false,
			]);

			exit;
		}

		echo json_encode([
			'message' => 'user is logged in',
			'isLogin' => true,
			'userId' => $_SESSION['username']
		]);
	}


	public function logout(){

		session_unset();
		session_destroy();

		echo json_encode([
			'message' => 'user is logged out',
			'isLogin' => false,
		]);
	}
}