<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use UserConnectionModel;

require_once __DIR__ . '/../models/UserConnectionModel.php';

class Chat implements MessageComponentInterface {
    protected $userConnectionModel;
    protected $clients;
    protected $onlineConnection = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->userConnectionModel = new UserConnectionModel();
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients->attach($conn);
         
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $ojbMessage = json_decode($msg, true);

        $connection_id = $from->resourceId;

        if($ojbMessage["type"] == 'userConnect'){
            $username = $ojbMessage["userId"] ?? null ;
            $result = $this->userConnectionModel->save_user_connection($username, $connection_id, 1);
            if(!$result) die;

            $this->onlineConnection[$connection_id] = $username;

        }elseif ($ojbMessage["type"] == 'userDisconnect'){
            $onlineUser = $this->onlineConnection[$connection_id];
            $this->userConnectionModel->save_user_connection($onlineUser, $connection_id, 0);
        }elseif ($ojbMessage["type"] == 'sendMessage'){
            $toUser = $ojbMessage['to'];
            $result = $this->userConnectionModel->get_user_connection($toUser);
            foreach ($this->clients as $client){
                if($client->resourceId === $result['connection_id']){
                    $client->send($ojbMessage['message']);
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