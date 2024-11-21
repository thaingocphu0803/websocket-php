<?php

require_once __DIR__ . '/../database/DB.php';

class UserModel {
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function check_authen($username, $password = null){
		$stmt = $this->db->query('SELECT username, pssw FROM  users WHERE username = :username LIMIT 1',[
			':username' => $username
		]);

		$user = $this->db->fetch($stmt);

		if(!$user) return false;

		if($password && $user['pssw'] !== $password) return false;

		return $user;
	}

	public function register_account($username, $password){

		$check_user = $this->check_authen($username);
		
		if($check_user) return false;

		$stmt = $this->db->query('INSERT INTO users(username, pssw) VALUES (:username, :pssw)', [
			':username' => $username,
			':pssw' => $password
		]);

		return $stmt->rowCount() > 0;

	}

	public function get_list_user($username){
		$stmt = $this->db->query("SELECT username FROM users WHERE username != :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if(!$result) return false;

		return $result;
	}

}