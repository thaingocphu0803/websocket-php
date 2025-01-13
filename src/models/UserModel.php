<?php

require_once __DIR__ . '/../database/DB.php';

class UserModel
{
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function check_authen($username, $password = null)
	{
		$stmt = $this->db->query('SELECT u.username, u.pssw, u.fullname, a.avatar FROM  users u
								LEFT JOIN user_avatar a ON u.username = a.username
								WHERE u.username = :username LIMIT 1', [
			':username' => $username
		]);

		$user = $this->db->fetch($stmt);

		if (empty($user)) return false;

		if (isset($password) && !password_verify($password, $user['pssw'])) return false;

		return $user;
	}

	public function register_account($username, $password, $fullname)
	{

		try {

			$check_user = $this->check_authen($username);

			$hash_password = password_hash($password, PASSWORD_BCRYPT);

			if ($check_user) return false;

			$stmt = $this->db->query('INSERT INTO users(username, pssw, fullname) VALUES (:username, :pssw, :fullname)', [
				':username' => $username,
				':pssw' => $hash_password,
				':fullname' => $fullname
			]);

			return $stmt->rowCount() > 0;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function get_list_user($username)
	{
			$stmt = $this->db->query("SELECT u.username as partner_username, u.fullname as partner_fullname, c.is_online as isOnline, a.avatar as partner_avt
									FROM users u
									LEFT JOIN user_avatar a ON u.username = a.username
									JOIN user_connection c ON u.username = c.username
									JOIN friends f 	ON (f.user1 = u.username OR f.user2 = u.username)
													AND (f.user1 =:username OR f.user2 =:username)
									WHERE u.username != :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if (!$result) return false;

		return $result;
	}


	public function update_fullname($username, $fullname)
	{
		$stmt = $this->db->query('UPDATE users SET fullname = :fullname WHERE username = :username', [
			':username' => $username,
			':fullname' => $fullname
		]);

		return $stmt->rowCount() > 0;
	}

	public function update_pasword($username, $hash_password)
	{

		$stmt = $this->db->query('UPDATE users SET pssw = :pssw WHERE username = :username', [
			':username' => $username,
			':pssw' => $hash_password
		]);

		return $stmt->rowCount() > 0;
	}

	public function update_avatar($username, $avatar)
	{

		$stmt1 = $this->db->query('SELECT username FROM user_avatar WHERE username = :username LIMIT 1', [
			':username' => $username,
		]);

		$user = $this->db->fetch($stmt1);

		if (!$user) {
			$stmt2 = $this->db->query('INSERT INTO user_avatar (username, avatar) VALUES(:username, :avatar)', [
				':username' => $username,
				':avatar' => $avatar
			]);

			return $stmt2->rowCount() > 0;
		} else {

			$stmt2 = $this->db->query('UPDATE user_avatar SET avatar = :avatar WHERE username = :username', [
				':username' => $user['username'],
				':avatar' => $avatar
			]);

			return $stmt2->rowCount() > 0;
		}
	}
}
