<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../models/MessageModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../helpers/Util.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Cloudinary\Cloudinary;

class InboxController
{

	private $messageModel;
	private $roomModel;
	private $util;

	public function __construct()
	{
		$this->messageModel = new MessageModel();
		$this->roomModel = new RoomModel();
		$this->util = new Util();
	}

	public function get_message()
	{
		$input = json_decode(file_get_contents('php://input'), true);

		[$user1, $user2] = explode('_', $input['room']);

		$receiver = $input['from'];

		$sender = ($user1 === $receiver) ? $user2 : $user1;

		$listMessage = $this->messageModel->get_list_message($input['room'], $sender, $receiver);

		if (!$listMessage) {
			$this->util->sendData(false, 'fail to get list message');
		};

		$this->util->sendData(true, '', ['listMessage' => $listMessage]);
	}

	public function set_room_status()
	{
		$input = json_decode(file_get_contents('php://input'), true);

		$result = $this->roomModel->set_room_status($input);

		if ($result) {
			$this->util->sendData(true, 'set_status successfully');
		}
	}

	public function upload_message_images()
	{
		$cloudinary = new Cloudinary([
			'cloud' => [
				'cloud_name' => CLOUD_NAME,
				'api_key'    => CLOUD_API_KEY,
				'api_secret' => CLOUD_API_SECRET,
			],
		]);


		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			$this->util->sendData(false, 'Incorrect request format');
		};

		if (!isset($_FILES['images']) || empty($_POST['room'])) {
			$this->util->sendData(false, 'upload images failed');
		};

		$files = $_FILES['images']["tmp_name"];

		$room = $_POST['room'];

		$listImage = [];

		foreach ($files as $file) {
			$result = $cloudinary->uploadApi()->upload($file, [
				'folder' => $room,
				'transformation' => [
					'width' => 500,
					'height' => 500,
					'crop' => 'pad',
					'gravity' => 'center'
				]
			]);

			$listImage[] = base64_encode($result['secure_url']);
		}

		$this->util->sendData(true, 'upload images successfully', ['listImage' => $listImage]);
	}
}
