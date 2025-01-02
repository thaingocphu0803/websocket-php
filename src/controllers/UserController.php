<?php

require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../helpers/Util.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/UserConnectionModel.php';
require_once __DIR__ . '/../models/MessageModel.php';


class UserController
{

	private $validation;
	private $util;
	private $auth;
	private $roomModel;
	private $userModel;
	private $messageModel;

	public function __construct()
	{
		session_start();
		$this->roomModel = new RoomModel();
		$this->userModel = new UserModel();
		$this->messageModel = new MessageModel();
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
				
				$payload= [
					'fullname' => $user['fullname'],
					'username' => $user['username']
				]; 

				$this->auth->generate_JWT($payload);
			}

			$_SESSION['username'] = $user['username'];
			$_SESSION['fullname'] = $user['fullname'];
			$_SESSION['pssw'] = $user['pssw'];

			$this->util->sendData(true, 'Login successfully', ['username' => $user['username']] );
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

			foreach ($result as &$partner){
				$number_unread = $this->messageModel->get_number_unread($username, $partner['partner_username']);

				$partner['number_unread'] = $number_unread;

			}
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

		$room = $this->roomModel->check_room_status($auth->username);

		if(!empty($room)){
			$partner  = $this->roomModel->get_status_partner($room['chat_with']);

			$data = [
				'username' => $auth->username,
				'partnerFullName' => $partner['fullname'],
				'parterIsOnline' => $partner['isOnline'],
				'partnerUserName' => $room['chat_with'],
				'roomStatus' => $room['stt']

			];

			$this->util->sendData(true, '', $data);

		}


		$this->util->sendData(true, '', ['username' => $auth->username]);

	}

	public function change_fullname(){
		$username  = isset($_SESSION['username']) ? $_SESSION['username'] : null;
		
		$input = json_decode(file_get_contents('php://input'), true);

		$fullname = $this->validation->clearInput($input['fullname']);

		$this->validation->validateAuthen('fullname', $fullname);

		$result = $this->userModel->update_fullname($username, $fullname);
		
		if(!$result) {
			$this->util->sendData(false, 'Failed to Update your full name');

		}
		$_SESSION['fullname'] = $fullname;

		$this->util->sendData(true, 'Updated your full name successfully');


	}

	public function change_password(){

		$input = json_decode(file_get_contents('php://input'), true);

		$username  = isset($_SESSION['username']) ? $_SESSION['username'] : null;

		$current_pssw = $this->validation->clearInput($input['current_pssw']);

		$new_pssw = $this->validation->clearInput($input['new_pssw']);
		
		$this->validation->ValidatePassword('current_password', $current_pssw);
		$this->validation->ValidatePassword('new_password', $new_pssw);

		$result = $this->userModel->update_pasword($username, $new_pssw);

		if(!$result) {
			$this->util->sendData(false, 'Failed to Update your password');

		}
		
		$_SESSION['pssw'] = $new_pssw;

		$this->util->sendData(true, 'Updated your password successfully');
	}


	public function logout()
	{
		session_unset();
		session_destroy();
		$this->util->clearCookie('auth');

		$this->util->sendData(true, 'Logout successfully');

	}
}
