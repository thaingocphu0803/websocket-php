<?php

require_once __DIR__ . '/../database/DB.php';

class UserModel {
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function check_authen($username, $password = null){
		$stmt = $this->db->query('SELECT username, pssw, fullname FROM  users WHERE username = :username LIMIT 1',[
			':username' => $username
		]);

		$user = $this->db->fetch($stmt);

		if(!isset($user)) return false;
		
		if(isset($password) && !password_verify($password, $user['pssw'])) return false;

		return $user;
	}

	public function register_account($username, $password, $fullname){

		try{
			
			$check_user = $this->check_authen($username);

			$hash_password = password_hash($password, PASSWORD_BCRYPT);
			
			if($check_user) return false;
	
			$stmt = $this->db->query('INSERT INTO users(username, pssw, fullname) VALUES (:username, :pssw, :fullname)', [
				':username' => $username,
				':pssw' => $hash_password,
				':fullname' => $fullname
			]);
	
			return $stmt->rowCount() > 0;
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function get_list_user($username){
		$stmt = $this->db->query("SELECT users.username as username, users.fullname as fullname, user_connection.is_online as isOnline  FROM users JOIN user_connection ON users.username = user_connection.username WHERE users.username != :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if(!$result) return false;

		return $result;
	}

}