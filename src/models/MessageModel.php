<?php

require_once __DIR__ . '/../database/DB.php';

class MessageModel {
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function saveMessage($MessageData){
		$stmt = $this->db->query('INSERT INTO messages (room, sender, mssg, create_at) VALUES (:room, :sender, :mssg, :create_at)', [
			':room' => $MessageData['room'],
			':sender' => $MessageData['sender'],
			':mssg' => $MessageData['mssg'],
			':create_at' => $MessageData['create_at'],
		]);

		return $stmt->rowCount() > 0;
	}

	public function get_list_message($room){
		$stmt = $this->db->query('SELECT room, mssg, sender, create_at FROM messages WHERE room = :room ORDER BY create_at',[
			':room' => $room
		]);

		$result = $this->db->fetch_all($stmt);

		if(empty($result)) return false;

		return $result;
	}
}