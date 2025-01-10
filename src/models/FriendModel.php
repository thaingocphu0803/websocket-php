<?php

require_once __DIR__ . '/../database/DB.php';

class FriendModel
{

	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function search_people($username, $key)
	{
		$stmt = $this->db->query(
			"SELECT u.username, u.fullname, a.avatar, fr.stt 
								FROM users u
								
								LEFT JOIN user_avatar a 
								ON u.username = a.username
								
								LEFT JOIN friend_request fr 
								ON (fr.receiver = u.username OR fr.sender = u.username)
								AND (fr.receiver = :username OR fr.sender = :username)
								AND fr.stt != 'accepted'
								
								LEFT JOIN friends f 
								ON ( u.username = f.user1 OR u.username = f.user2) 
								AND (f.user1 = :username OR f.user2 = :username)
								
								WHERE u.username != :username 
								AND u.fullname LIKE :q 
								AND (f.stt IS NULL OR f.stt != 'A')",
			[
				':username' => $username,
				':q' => "%$key%"
			]
		);

		$result = $this->db->fetch_all($stmt);

		if (!$result) return false;

		return $result;
	}

	public function handle_friend_request($sender, $receiver, $stt)
	{
		$stmt1 = $this->db->query("SELECT sender, receiver, stt FROM friend_request WHERE sender = :sender AND receiver = :receiver LIMIT 1", [
			':sender' => $sender,
			':receiver' => $receiver
		]);

		$friend_request = $this->db->fetch($stmt1);

		if (!$friend_request) {

			$stmt2 = $this->db->query("INSERT INTO friend_request (sender, receiver, stt, created_at) VALUES(:sender, :receiver, :stt, CURRENT_TIMESTAMP)", [
				':sender' => $sender,
				':receiver' => $receiver,
				':stt' => $stt
			]);
		} else {

			$stmt2 = $this->db->query("UPDATE friend_request SET stt = :stt , created_at = CURRENT_TIMESTAMP WHERE (sender = :sender AND receiver = :receiver)", [
				':sender' => $sender,
				':receiver' => $receiver,
				':stt' => $stt
			]);
		}

		if ($stt === 'accepted' && $stmt2->rowCount() > 0) {

			return $this->handle_friend_connect($sender, $receiver, 'A');
		}

		return $stmt2->rowCount() > 0;
	}


	public function handle_friend_connect($sender, $receiver, $stt)
	{
		$stmt1 = $this->db->query(
			"SELECT 1 FROM friends WHERE LEAST(:sender, :receiver) = user1 
		AND GREATEST(:sender, :receiver) = user2",
			[
				':sender' => $sender,
				':receiver' => $receiver,
			]
		);

		$check_friend_connect = $this->db->fetch($stmt1);

		if (!$check_friend_connect) {
			$stmt2 = $this->db->query("INSERT INTO friends (user1, user2, stt) 
			VALUES(LEAST(:sender, :receiver),
			GREATEST(:sender, :receiver), :stt)", [
				':sender' => $sender,
				':receiver' => $receiver,
				':stt' => $stt
			]);
		} else {
			$stmt2 = $this->db->query("UPDATE friends SET stt = :stt WHERE LEAST(:sender, :receiver) = user1 
		AND GREATEST(:sender, :receiver) = user2", [
				':sender' => $sender,
				':receiver' => $receiver,
				':stt' => $stt
			]);
		}

		return $stmt2->rowCount() > 0;
	}

	public function get_list_send_add($username)
	{
		$stmt = $this->db->query("SELECT u.username, u.fullname, a.avatar FROM users u
								LEFT JOIN user_avatar a ON u.username = a.username
								JOIN friend_request fr ON ( fr.receiver = u.username AND fr.stt = 'pending')
								WHERE fr.sender = :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if (!$result) return false;

		return 	$result;
	}

	public function get_list_add_request($username)
	{
		$stmt = $this->db->query("SELECT u.username as senderId, u.fullname as senderFullname, a.avatar as senderAvt FROM users u
								LEFT JOIN user_avatar a ON u.username = a.username
								JOIN friend_request fr ON (fr.sender = u.username AND fr.stt = 'pending')
								WHERE fr.receiver = :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if (!$result) return false;

		return 	$result;
	}


	public function get_count_friend_request($username)
	{
		$stmt = $this->db->query("SELECT COUNT(stt) as number_request FROM friend_request WHERE receiver = :username AND stt = 'pending' ", [
			':username' => $username
		]);

		$result = $this->db->fetch($stmt);

		if (!$result) return false;

		return 	$result;
	}
}
