<?php
require_once __DIR__ . '/src/controllers/UserController.php';
require_once __DIR__ . '/config.php';


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

class Router
{
	public $user;
	public $path;
	public $param;
	private static $instance = null;

	public function __construct()
	{
		$this->user = new UserController();
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
		$request_uri = explode('/', $request_uri);

		$this->path =  isset($request_uri[0]) ? $request_uri[0] : NULL;
		$this->param =  isset($request_uri[1]) ? $request_uri[1] : NULL;
	}
}

$router = Router::getInstance();


//check request URL to call subtable function
switch ($router->path) {
		// auhenController
	case null:
		$router->user->index();
		break;
	case 'login':
		$router->user->login();
		break;
	case 'register':
		$router->user->register();
		break;
	case 'list':
		$router->user->list();
		break;
	case 'logout':
		$router->user->logout();
		break;
	default:
		break;
}
