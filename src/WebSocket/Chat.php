<?php
namespace MyApp;

use MessageModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use UserConnectionModel;
use Validation;

require_once __DIR__ . '/../models/UserConnectionModel.php';
require_once __DIR__ . '/../models/MessageModel.php';
require_once __DIR__ . '/../helpers/Validation.php';

class Chat implements MessageComponentInterface {
    protected $userConnectionModel;
    protected $clients;
    protected $messageModel;
    protected $validation;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->userConnectionModel = new UserConnectionModel();
        $this->messageModel =  new MessageModel();
        $this->validation = new Validation();
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients->attach($conn);
         
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $ojbMessage = json_decode($msg, true);
        $connection_id = $from->resourceId;

        if($ojbMessage["type"] == 'userConnect'){
            $userConnect = $ojbMessage["userConnect"] ?? null ;
            $result = $this->userConnectionModel->save_user_connection($userConnect, $connection_id, 1);
            if(!$result) die;

            
            foreach ($this->clients as $client){
                if($from !== $client){

                    $sendMessage = [
                        'type' => $ojbMessage["type"],
                        'username' => $ojbMessage["userConnect"],
                        'isOnline' => 1,
                    ];

                    $client->send(json_encode($sendMessage));
                }
            }

        }elseif ($ojbMessage["type"] == 'userDisconnect'){
            $onlineUser = $ojbMessage['userDisconect'];
            $result = $this->userConnectionModel->save_user_connection($onlineUser, $connection_id, 0);
            if(!$result) die;

            foreach ($this->clients as $client){
                if($from !== $client){

                    $sendMessage = [
                        'type' => $ojbMessage["type"],
                        'username' => $ojbMessage["userDisconect"],
                        'isOnline' => 0,
                    ];

                    $client->send(json_encode($sendMessage));
                }
            }

        }elseif ($ojbMessage["type"] == 'sendMessage'){
            
            $toUser = $ojbMessage['to'];
            $receiver = $this->userConnectionModel->get_user_connection($toUser);
            $mssg = $this->validation->clearInput($ojbMessage["message"]);

            $messageData = [
                'room' => $ojbMessage["room"],
                'sender' => $ojbMessage["from"],
                'mssg' => $mssg,
                'create_at' => $ojbMessage["date"],             
            ];

            $result = $this->messageModel->saveMessage($messageData);

            if(!$result) die();

            foreach ($this->clients as $client){
                if($client->resourceId === $receiver['connection_id']){

                    $sendMessage = [
                        'type' => $ojbMessage["type"],
                        'room' => $ojbMessage['room'],
                        'date' => $ojbMessage['date'],
                        'message' => $ojbMessage['message'],
                    ];

                    $client->send(json_encode($sendMessage));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }           
}