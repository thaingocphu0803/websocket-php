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
			"SELECT u.username, u.fullname, a.avatar FROM users u
				LEFT JOIN user_avatar a ON u.username = a.username
				WHERE u.username != :username
				AND u.fullname LIKE :q
				AND NOT EXISTS (
								SELECT 1 FROM friend_request fr
								WHERE (fr.sender = u.username AND fr.receiver = :username)
								OR (fr.sender = :username AND fr.receiver = u.username)
							)
				AND NOT EXISTS (
								SELECT 1 FROM friends f
								WHERE (f.user1 = u.username AND f.user2 = :username)
								OR (f.user1 = :username AND f.user2 = u.username)
							)
			",
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
		switch ($stt) {
			case 'accepted':
				$result = $this->delete_friend_request($sender, $receiver);

				if ($result) {
					return $this->add_friend_connect($sender, $receiver);
				} else {
					return false;
				}
				break;
			case 'rejected':
				return $this->delete_friend_request($sender, $receiver);
				break;
			case 'pending':
				return $this->add_friend_request($sender, $receiver);
				break;
			default:
				return false;
				break;
		}
	}

	public function add_friend_request($sender, $receiver)
	{
		$stmt = $this->db->query("INSERT INTO friend_request (sender, receiver, created_at) VALUES(:sender, :receiver, CURRENT_TIMESTAMP)", [
			':sender' => $sender,
			':receiver' => $receiver,
		]);

		return $stmt->rowCount() > 0;
	}

	public function delete_friend_request($sender, $receiver)
	{
		$stmt = $this->db->query("DELETE FROM friend_request WHERE sender = :sender AND receiver = :receiver", [
			':sender' => $sender,
			':receiver' => $receiver,
		]);

		return $stmt->rowCount() > 0;
	}

	public function add_friend_connect($sender, $receiver)
	{

		$stmt = $this->db->query("INSERT INTO friends (user1, user2, created_at) 
			VALUES(LEAST(:sender, :receiver),
			GREATEST(:sender, :receiver), CURRENT_TIMESTAMP)", [
			':sender' => $sender,
			':receiver' => $receiver,
		]);

		return $stmt->rowCount() > 0;
	}


	public function delete_friend_connect($sender, $receiver)
	{

		$stmt = $this->db->query("DELETE FROM friends 
			WHERE (LEAST(:sender, :receiver) AND GREATEST(:sender, :receiver)", [
			':sender' => $sender,
			':receiver' => $receiver,
		]);

		return $stmt->rowCount() > 0;
	}


	public function get_list_send_add($username)
	{
		$stmt = $this->db->query("SELECT u.username, u.fullname, a.avatar FROM users u
								LEFT JOIN user_avatar a ON u.username = a.username
								JOIN friend_request fr ON ( fr.receiver = u.username)
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
								JOIN friend_request fr ON (fr.sender = u.username)
								WHERE fr.receiver = :username", [
			':username' => $username
		]);

		$result = $this->db->fetch_all($stmt);

		if (!$result) return false;

		return 	$result;
	}


	public function get_count_friend_request($username)
	{
		$stmt = $this->db->query("SELECT COUNT(sender) as number_request FROM friend_request WHERE receiver = :username", [
			':username' => $username
		]);

		$result = $this->db->fetch($stmt);

		if (!$result) return false;

		return 	$result;
	}
}
