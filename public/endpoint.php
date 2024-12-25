<?php
require_once __DIR__ . '/../src/controllers/UserController.php';
require_once __DIR__ . '/../src/controllers/InboxController.php';
require_once __DIR__ . '/../config.php';


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

class Router
{
	public $user;
	public $inbox;
	public $path;
	public $param;
	private static $instance = null;

	public function __construct()
	{
		$this->user = new UserController();
		$this->inbox = new InboxController();
		$this->setURL();
	}

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Router();
		}

		return self::$instance;
	}

	//check and return request URL
	public function setURL()
	{
		if (empty($_SERVER['REQUEST_URI'])) {
			die('ERROR: Cannot find URL');
		}
		$request_uri = trim($_SERVER['REQUEST_URI'], '/');

		$end_point = str_replace('endpoint.php/', '', $request_uri);

		$this->path =  isset($end_point) ? strtolower($end_point) : NULL;
	}
}


$router = Router::getInstance();

//check request URL to call subtable function
switch ($router->path) {
		// UserController
	case 'login':
		$router->user->login();
		break;
	case 'register':
		$router->user->register();
		break;
	case 'check-login':
		$router->user->check_login();
		break;
	case 'list':
		$router->user->list();
		break;
	case 'logout':
		$router->user->logout();
		break;
	// InboxController
	case 'get-message':
		$router->inbox->get_message();
		break;
	case 'set-room-status':
		$router->inbox->set_room_status();
		break;
	case 'upload-message-images':
		$router->inbox->upload_message_images();
	default:
		break;
}
