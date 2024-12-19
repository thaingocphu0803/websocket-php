<?php
require_once __DIR__ . '/../models/MessageModel.php';

class MessageController {

    private $messageModel;

    public function __construct(){
        $this->messageModel = new MessageModel();
    }

    public function get_message(){
		$input = json_decode(file_get_contents('php://input'), true);
        var_dump($input);
        die;
    }
}