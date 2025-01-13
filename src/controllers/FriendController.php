<?php

require_once __DIR__ . '/../models/FriendModel.php';
require_once __DIR__ . '/../helpers/Util.php';


class FriendController {

	private $friendModel;

	private $util;
	 
	public function __construct()
	{
		$this->friendModel = new FriendModel();
		$this->util =  new Util();
	}

	public function search_people(){
		$input = json_decode(file_get_contents('php://input'), true);
		$username =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->search_people($username, $input['key']);


		if(!$result) $this->util->sendData(false, 'Failed to search people');

		$this->util->sendData(true,'Searching people successfully', ['listPeople' => $result]);

	}

	public function handle_friend_request(){
		
		$input = json_decode(file_get_contents('php://input'), true);
		$sender =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->handle_friend_request($sender, $input['receiver'], $input['stt']);

		if(!$result) $this->util->sendData(false, 'Failed to handle friend request');

		$this->util->sendData(true,'handling friend request successfully');
	}

	public function handle_friend_response(){
		
		$input = json_decode(file_get_contents('php://input'), true);
		$receiver =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->handle_friend_request($input['sender'], $receiver, $input['stt']);

		if(!$result) $this->util->sendData(false, 'Failed to handle friend response');

		$this->util->sendData(true,'handling friend response successfully');
	}

	public function get_list_send_add(){
		$username =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->get_list_send_add($username);

		if(!$result) $this->util->sendData(false, 'Failed to get list send friend request');

		$this->util->sendData(true,'geting list send friend request successfully', ['listReceiverRequest' => $result]);

	}

	public function get_list_add_request(){
		$username =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->get_list_add_request($username);

		if(!$result) $this->util->sendData(false, 'Failed to get list add request');

		$this->util->sendData(true,'geting list add request successfully', ['listAddRequest' => $result]);

	}

	public function get_count_friend_request(){
		$username =  $_SESSION['username'] ?? null;

		$result =  $this->friendModel->get_count_friend_request($username);

		if(!$result) $this->util->sendData(false, 'Failed to get number friend request');

		$this->util->sendData(true,'geting number friend request successfully', ['count' => $result['number_request']]);

	}
}
