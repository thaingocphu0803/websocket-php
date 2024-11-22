<?php

require_once __DIR__ . '/../database/DB.php';

class UserConnectionModel {
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function get_user_connection($username){
		$stmt = $this->db->query("SELECT connection_id, is_online FROM user_connection WHERE username = :username LIMIT 1", [
			':username' => $username
		]);

		$result = $this->db->fetch($stmt);

		if($result){
			return $result;
		}

		return false;
	}

	public function save_user_connection($username, $connection_id, $is_online){
		$user = $this->get_user_connection($username);

		if(!$user){
			$stmt =  $this->db->query("INSERT INTO user_connection (username, is_online, connection_id) VALUES(:username, :is_online, :connection_id)", [
				':username' => $username,
				':is_online' => $is_online,
				':connection_id' => $connection_id
			]);

			 return $stmt->rowCount() > 0;
		}else{
			$stmt =  $this->db->query("UPDATE user_connection SET is_online = :is_online, connection_id = :connection_id WHERE username =:username", [
				':username' => $username,
				':is_online' => $is_online,
				':connection_id' => $connection_id
			]);

			 return $stmt->rowCount() > 0;
		}
	}
}