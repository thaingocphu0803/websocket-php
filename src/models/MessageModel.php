<?php

require_once __DIR__ . '/../database/DB.php';

class MessageModel
{
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstance();
	}

	public function saveMessage($MessageData)
	{
		try {

			$this->db->query('INSERT INTO messages (room, sender, receiver, mssg, is_read, create_at) VALUES (:room, :sender, :receiver, :mssg, :is_read, :create_at)', [
				':room' => $MessageData['room'],
				':sender' => $MessageData['sender'],
				':receiver' => $MessageData['receiver'],
				':mssg' => $MessageData['mssg'],
				':is_read' => $MessageData['is_read'],
				':create_at' => $MessageData['create_at'],
			]);

			$insert_id = $this->db->last_insert_id();

			if (!empty($MessageData['list_image']) && $insert_id) {

				$listImage = $MessageData['list_image'];

				for ($i = 0; $i < count($listImage); $i++) {

					$stmt = $this->db->query(
						'INSERT INTO images_message (message_id, img_url) 
						VALUES (:message_id, :img_url)',
						[
							':message_id' => $insert_id,
							':img_url' => $listImage[$i]
						]
					);
				}

				return $stmt->rowCount() > 0;
			}

			return $insert_id;
		} catch (Exception $e) {

			echo "ERROR" .  $e->getMessage();
		}
	}

	public function get_list_message($room, $sender, $receiver)
	{
		try {
			$this->db->transaction_start();

			$check_unread  =  $this->get_number_unread($receiver, $sender);

			if ($check_unread && $check_unread !== 0) {
				$this->db->query('UPDATE messages SET is_read = "Y" WHERE sender = :sender AND receiver = :receiver AND  is_read = "N" ', [
					':sender' => $sender,
					':receiver' => $receiver
				]);
			}

			$stmt2 = $this->db->query('
			SELECT 
				m.id, m.room, m.mssg, m.sender, m.create_at, 
				GROUP_CONCAT(i.img_url) AS img_urls
			FROM 
				messages m
			LEFT JOIN 
				images_message i ON m.id = i.message_id
			WHERE 
				m.room = :room
			GROUP BY 
				m.id
			ORDER BY 
				m.create_at
		', [
			':room' => $room
		]);

			$result = $this->db->fetch_all($stmt2);

			$this->db->transaction_commit();

			return $result;
		} catch (Exception $e) {
			$this->db->transaction_rollback();

			echo "ERROR" .  $e->getMessage();
		}
	}

	public function get_number_unread($username, $partner_username)
	{
		try {
			$stmt = $this->db->query('SELECT COUNT(CASE WHEN is_read = "N" THEN 1 END) as number_unread FROM messages WHERE sender = :sender AND receiver = :receiver', [
				':receiver' => $username,
				':sender' => $partner_username
			]);

			$result =  $this->db->fetch($stmt);

			if (empty($result)) return 0;

			return $result['number_unread'];
		} catch (Exception $e) {
			echo "ERROR" .  $e->getMessage();
		}
	}
}
