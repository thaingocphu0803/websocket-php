<?php

require_once __DIR__ . '/../database/DB.php';

class RoomModel{
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function set_room_status($data){
		$check = $this->check_room_status( $data['user_open']);
		[$user1, $user2] = explode('_', $data['room']);

		$chat_with = ($user1 === $data['user_open']) ? $user2 : $user1;
		
		if(!$check){
			$stmt = $this->db->query("INSERT INTO rooms(room, user_open, chat_with) VALUE(:room, :user_open, :chat_with)", [
				':room' => $data['room'],
				':user_open' => $data['user_open'],
				':chat_with' => $chat_with
			]);

		}else{

			$stmt = $this->db->query("UPDATE rooms SET stt = :stt, room = :room, chat_with = :chat_with, updated_at = CURRENT_TIMESTAMP WHERE user_open = :user_open", [
				':room' => $data['room'],
				':stt' =>  $data['status'],
				':user_open' => $data['user_open'],
				':chat_with' => $chat_with
			]);
		}

		return $stmt->rowCount() > 0;
	}

	public function check_room_status($user_open){
		$stmt = $this->db->query("SELECT chat_with, stt FROM rooms WHERE user_open = :user_open LIMIT 1", [
			':user_open' => $user_open
		]);

		$result = $this->db->fetch($stmt);

		if(empty($result)) return false;

		return $result;
	}

	public function get_status_partner($partner){
		$stmt = $this->db->query("SELECT users.fullname as fullname, user_connection.is_online as isOnline FROM users
									JOIN user_connection ON users.username = user_connection.username 
									WHERE users.username = :username LIMIT 1", 
								
								[':username' => $partner]);

		$result = $this->db->fetch($stmt);
		

		if(empty($result)) return false;

		return $result;
	}
}