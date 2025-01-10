<?php

namespace MyApp;

use MessageModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use RoomModel;
use UserConnectionModel;
use UserModel;
use Validation;

require_once __DIR__ . '/../models/UserConnectionModel.php';
require_once __DIR__ . '/../models/MessageModel.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class Chat implements MessageComponentInterface
{
	protected $userConnectionModel;
	protected $clients;
	protected $messageModel;
	protected $validation;
	protected $roomModel;
	protected $userModel;

	public function __construct()
	{
		$this->clients = new \SplObjectStorage;
		$this->userConnectionModel = new UserConnectionModel();
		$this->messageModel =  new MessageModel();
		$this->validation = new Validation();
		$this->roomModel = new RoomModel();
		$this->userModel = new UserModel();
	}

	public function onOpen(ConnectionInterface $conn)
	{

		$this->clients->attach($conn);

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg)
	{
		$ojbMessage = json_decode($msg, true);
		$connection_id = $from->resourceId;

		echo $ojbMessage['type'];

		if ($ojbMessage["type"] == 'userConnect') {
			$userConnect = $ojbMessage["userConnect"] ?? null;
			$result = $this->userConnectionModel->save_user_connection($userConnect, $connection_id, 1);
			if (!$result) die;


			foreach ($this->clients as $client) {
				if ($from !== $client) {

					$sendMessage = [
						'type' => $ojbMessage["type"],
						'username' => $ojbMessage["userConnect"],
						'isOnline' => 1,
					];

					$client->send(json_encode($sendMessage));
				}
			}
		} elseif ($ojbMessage["type"] == 'userDisconnect') {
			$onlineUser = $ojbMessage['userDisconect'];
			$result = $this->userConnectionModel->save_user_connection($onlineUser, 0, 0);
			if (!$result) die;

			foreach ($this->clients as $client) {
				if ($from !== $client) {

					$sendMessage = [
						'type' => $ojbMessage["type"],
						'username' => $ojbMessage["userDisconect"],
						'isOnline' => 0,
					];

					$client->send(json_encode($sendMessage));
				}
			}
		} elseif ($ojbMessage["type"] == 'sendMessage') {

			$toUser = $ojbMessage['to'];
			$receiver = $this->userConnectionModel->get_user_connection($toUser);
			$mssg = $this->validation->clearInput($ojbMessage["message"]);

			$room_status = $this->roomModel->check_room_status($ojbMessage["to"]);

			if (!$room_status) die;



			if ($room_status['room'] === $ojbMessage["room"] && $room_status['stt'] === 'A') {
				$is_read = "Y";
			} else {
				$is_read = "N";
			}

			$messageData = [
				'room' => $ojbMessage["room"],
				'sender' => $ojbMessage["from"],
				'receiver' => $ojbMessage["to"],
				'mssg' => $mssg,
				'is_read' => $is_read,
				'create_at' => $ojbMessage["date"],
				'list_image' => $ojbMessage["listImage"]
			];

			$result = $this->messageModel->saveMessage($messageData);

			if (!$result) die();

			foreach ($this->clients as $client) {
				if ($client->resourceId === $receiver['connection_id']) {

					if ($is_read === "N") {
						$client->send(json_encode([
							'type' => 'unRead',
							'sender' => $ojbMessage["from"]
						]));
					}
					$sendMessage = [
						'type' => $ojbMessage["type"],
						'room' => $ojbMessage['room'],
						'date' => $ojbMessage['date'],
						'message' => $ojbMessage['message'],
						'listImage' => $ojbMessage['listImage']
					];

					$client->send(json_encode($sendMessage));
				}
			}
		}else if($ojbMessage["type"] == "sendFriendRequest"){
				$receiverId = $ojbMessage["to"];
				$senderId = $ojbMessage["from"];

				$sender = $this->userModel->check_authen($senderId);
				$receiver = $this->userConnectionModel->get_user_connection($receiverId);

				var_dump($receiver);


				if(!$receiver || !$sender) die();

				foreach ($this->clients as $client) {
					if ($client->resourceId === $receiver['connection_id']) {
	
						$sendMessage = [
							'type' => $ojbMessage["type"],
							'senderId' => $senderId,
							'senderAvt' => $sender['avatar'],
							'senderFullname' => $sender['fullname']
						];
						$client->send(json_encode($sendMessage));
					}
				}
		}else if($ojbMessage["type"] == "cancelFriendRequest"){
			$receiverId = $ojbMessage["to"];
			$receiver = $this->userConnectionModel->get_user_connection($receiverId);


				if(!$receiver) die();

				foreach ($this->clients as $client) {
					if ($client->resourceId === $receiver['connection_id']) {
	
						$sendMessage = [
							'type' => $ojbMessage["type"],
							'senderId' => $ojbMessage['from']
						];
	
						$client->send(json_encode($sendMessage));
					}
				}
		}
	}

	public function onClose(ConnectionInterface $conn)
	{
		// The connection is closed, remove it, as we can no longer send it messages

		$from = $conn->resourceId;
		
		$username = $this->userConnectionModel->get_username_by_connection($from);
		if (!$username) die;

		$result = $this->userConnectionModel->save_user_connection($username, 0, 0);

		if (!$result) die;

		foreach ($this->clients as $client) {
			if ($from !== $client) {

				$sendMessage = [
					'type' => 'userDisconnect',
					'username' => $username,
					'isOnline' => 0,
				];

				$client->send(json_encode($sendMessage));
			}
		}

		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e)
	{
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}
}
