<?php
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/config.php';


if (isset($_SERVER['HTTP_ORIGIN'])) {
	$origin = $_SERVER['HTTP_ORIGIN'];

	if ($origin === $allowed_http_origin || $origin === $allowed_https_origin) {
		header("Access-Control-Allow-Origin: $origin");
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');
	}
}

class Router
{
	public $auth;
	public $path;
	public $param;
	private static $instance = null;

	public function __construct()
	{
		$this->auth = new AuthController();
		$this->setURL();
	}

	public static function getInstance(){
		if(self::$instance === null){
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

		$this->path =  isset($request_uri[1]) ? $request_uri[1] : NULL;
		$this->param =  isset($request_uri[2]) ? $request_uri[2] : NULL;
	}
}

$router = Router::getInstance();


//check request URL to call subtable function
switch ($router->path) {
		// auhenController
	case null:
		$router->auth->index();
		break;
	case 'login':
		$router->auth->login();
		break;
	case 'logout':
		$router->auth->logout();
		break;
	default:
		break;
}