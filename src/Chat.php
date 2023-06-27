<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface; 
//require dirname(__DIR__).'/ChatUser.php';


class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $data=json_decode($msg,true);
        if ($data['command']=='private') {
         $private_chat_object=new \PrivateChat;
         $private_chat_object->setUserId($data['receiver_user_id']);
         $private_chat_object->SetfromUserId($data['userId']);
         $private_chat_object->setChatMessage($data['msg']);
         $timestamp =date('Y-m-d h:i:s');
         $private_chat_object->setTimesTamp($timestamp);
         $private_chat_object->setStatus('YES');
         $chat_message_id=$private_chat_object->save_chat();
         $id=$data['receiver_user_id'];
         require 'DB.php';
          $select=$connect->prepare("SELECT * FROM user WHERE user_id='$id'");
                 
                   
                $select->execute();
                     // code...
                 
                  
                   foreach ($select as $key) {
                    echo $username=$key['user_name'];
                   
                   }
                   $data['datetime']=$timestamp;
                   foreach($this->clients as $client){
                    if($from==$client){
                        $data['from']='me';
                    }else{
                    $data['from']=$username;}
                    if ($from==$client) {
                        $client->send(json_encode($data));
                    }
                    else{
                     $private_chat_object->setStatus('NO');
                     $private_chat_object->getChatMessageId($chat_message_id);
                     $private_chat_object->update_chat_status();   
                    }

                   }





        }
        else{
      $id=$data['userId'];
       require 'DB.php';
                                  
                 $Insert=$connect->prepare("INSERT INTO chatroom (user_Id ,msg ,created) VALUES (:user_Id ,:msg ,Now())");
               $Insert->bindparam("user_Id",$id);
               $Insert->bindparam("msg",$data['msg']);
               // $Insert->bindparam("created",$created);
              if ($Insert->execute()) {
                  // code...
              }
              else{
                echo "string";
              }
                  
                 
        

                   $select=$connect->prepare("SELECT * FROM user WHERE user_id='$id'");
                 
                   
                $select->execute();
                     // code...
                 
                  
                   foreach ($select as $key) {
                    $username=$key['user_name'];
                   
                   } 
                   }
                

               $data["dt"]=date("d-m-Y h:i:s");
         // **************************************************/
    
        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            //     // The sender is not the receiver, send to each client connected
             
            // }
            if ($client==$from) {
                $data['from']="me";
               
            }
            else{
               $data['from']=$username; 

            }
            $client->send(json_encode($data));
              // $client->send($msg);

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
?>