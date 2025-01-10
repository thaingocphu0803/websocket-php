<?php
require_once __DIR__ . '/../src/controllers/UserController.php';
require_once __DIR__ . '/../src/controllers/InboxController.php';
require_once __DIR__ . '/../src/controllers/FriendController.php';
require_once __DIR__ . '/../src/controllers/TemplateController.php';

require_once __DIR__ . '/../config.php';


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

class Router
{
	public $user;
	public $inbox;
	public $friend;
	public $path;
	public $param;
	public $template;
	private static $instance = null;

	public function __construct()
	{
		$this->user = new UserController();
		$this->inbox = new InboxController();
		$this->friend = new FriendController();
		$this->template = new TemplateController();
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
	case 'change-fullname':
		$router->user->change_fullname();
		break;
	case 'change-password':
		$router->user->change_password();
		break;
	case 'change-avatar':
		$router->user->change_avatar();
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
		break;
		//  FriendController
	case 'search-people':
		$router->friend->search_people();
		break;
	case 'handle-friend-request':
		$router->friend->handle_friend_request();
		break;
	case 'handle-friend-response':
		$router->friend->handle_friend_response();
		break;
	case 'list-send-add':
		$router->friend->get_list_send_add();
		break;
	case 'list-add-request':
		$router->friend->get_list_add_request();
		break;
	case 'get-count-friend-request':
		$router->friend->get_count_friend_request();
		break;
		//TemplateController
	case 'handle-template':
		$router->template->handle_template();
		break;
	default:
		break;
}
