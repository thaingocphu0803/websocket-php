<?php
require_once __DIR__ . '/../models/MessageModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../helpers/Util.php';

class InboxController {

    private $messageModel;
    private $roomModel;
    private $util;

    public function __construct(){
        $this->messageModel = new MessageModel();
        $this->roomModel = new RoomModel();
        $this->util = new Util();
    }

    public function get_message(){
		$input = json_decode(file_get_contents('php://input'), true);

        $listMessage = $this->messageModel->get_list_message($input['room']);
         
        if(!$listMessage) {
            $this->util->sendData(false,'fail to get list message');
        };

        $this->util->sendData(true, '', ['listMessage' => $listMessage]);

    }

    public function set_room_status(){
        $input = json_decode(file_get_contents('php://input'), true);

        $result = $this->roomModel->set_room_status($input);

        if($result){
            $this->util->sendData(true, 'set_status successfully');
        }
    }
}