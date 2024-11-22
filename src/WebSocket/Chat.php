<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use UserConnectionModel;

require_once __DIR__ . '/../models/UserConnectionModel.php';

class Chat implements MessageComponentInterface {
    protected $userConnectionModel;
    protected $clients; 

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->userConnectionModel = new UserConnectionModel();
    }

    public function onOpen(ConnectionInterface $conn) {

        // parse_str($conn->httpRequest->getUri()->getQuery(), $param);

        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        // $username = $param['username'];
        // $connection_id = $conn->resourceId;

        // $result = $this->userConnectionModel->save_user_connection($username, $connection_id, 1);

        // if(!$result) die;
         
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {


            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
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