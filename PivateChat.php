<?php 
   /**
    * 
    */
   class PrivateChat 
   {
   	private $chat_message_id;
   	private $to_user_id;
   	private $from_user_id;
   	private $chat_message;
   	private $timeStamp;
   	private $stauts;
   	protected $connect;
   	function __construct(argument)
   	{
   		require 'DB.php';
   	}
   	function setChatMessageId($chat_message_id){
   		$this->chat_message_id=$chat_message_id;
   	}
   	function getChatMessageId(){
   		return $this->chat_message_id;
   	}
   	 function setUserId($to_user_id){
   		$this->to_user_id=$to_user_id;
   	}
   	 	function getUserid(){
   		return $this->to_user_id;
   	}
   	 function SetfromUserId($from_user_id){
   		$this->from_user_id=$from_user_id;
   	}
   	 	function getUserid(){
   		return $this->from_user_id;
   	}
   	 function SetfromUserId($from_user_id){
   		$this->from_user_id=$from_user_id;
   	}
   	 	function getUserid(){
   		return $this->from_user_id;
   	}
   	 function setChatMessage($chat_message){
   		$this->chat_message=$chat_message;
   	}
   	 	function getUserid(){
   		return $this->chat_message;
   	}
   		 function setTimesTamp($timeStamp){
   		$this->timeStamp=$timeStamp;
   	}
   	 	function getUserid(){
   		return $this->timeStamp;
   	}
   	 function setStatus($stauts){
   		$this->stauts=$stauts;
   	}
   	 	function getUserid(){
   		return $this->stauts ;
   	}
   	function get_all_chat_data(){
   		require 'DB.php';
   		$Prive=$connect->prepare("SELECT a.user_name as from_user_name, b.user_name as to_user_name,chat_message,timestamp, stutus ,to_user_id ,from_user_id FROM chat_message INNER JOIN user a ON chat_message.from_user_id=a.user_id  INNER JOIN user b ON chat_message.to_user_id
   		  WHERE (chat_message.from_user_id=:from_user_id AND chat_message.to_user_id=:to_user_id) OR (chat_message.from_user_id=:to_user_id AND chat_message.to_user_id=:from_user_id) " );
   		$statment->bindparam("from_user_id",$this->from_user_id);
   		$statment->bindparam("to_user_id",$this->to_user_id);
   		if ($statment->execute()) {
           echo "sing"
         }else
         {
       echo "string";
         }
   	}
      function save_chat(){
         require 'DB.php';
         $Insert=$connect->prepare("INSERT INTO chat_message (to_user_id ,from_user_id ,  chat_message ,timestamp  ,stutus) VALUES (:to_user_id ,:from_user_id , :chat_message ,:timestamp  ,:stutus)");
         $Insert->bindparam("to_user_id",$this->to_user_id);
         $Insert-<bindparam("from_user_id",$this->from_user_id);
         $Insert->bindparam("chat_message",$this->chat_message);
         $Insert->bindparam("timestamp",$this->timeStamp);
         $Insert->bindparam("stutus",$this->stauts);
         return $this->connect->lastInsertId();

      }
      function update_chat_status();
      $Update=$connect->prepare("UPDATE chat_message SET stutus=:stutus WHERE chat_message_id=:chat_message_id");
      $Update->bindparam("stutus",$this->stauts);
      $Update->bindparam("chat_message_id",$this->chat_message_id);

      $Update->execute();
   }




?>