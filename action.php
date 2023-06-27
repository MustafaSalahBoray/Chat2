<?php
    require 'DB.php';
   session_start();
   if (isset($_SESSION['user'])) {
    $id=$_SESSION['user']->user_id; 
   }

      $message=$connect->prepare("SELECT * FROM chat_message WHERE (to_user_id=:to_user_id AND from_user_id=:from_user_id)OR ( to_user_id=:from_user_id AND from_user_id=:to_user_id)");
                      $message->bindparam("to_user_id",$_POST['toUser']);
                      $message->bindparam("from_user_id",$_POST['fromUser']);
                      if ($message->execute()) {
                                              
                      $message=$message->fetchAll(PDO::FETCH_ASSOC);
                     
                      foreach($message as $row){
                         $row_class='';
                        $background_class='';
                        $user_name=$_POST['user_name'];
                         $row['to_user_id'];
                            
                        if ($id==$row['to_user_id']) {
                              $row_class='row justify-content-start';
                           $background_class='alert-success';
                           $user_name='Me';
                             echo   "<div classs='".$row_class."'><div class='col-sm-10'><div class='shadow-sm alert ".$background_class."'><b>".$user_name."-</b>".$row['chat_message']."<br><div class='text-right'><small><i>".$row['timestamp']."</i></small></div></div></div></div>";
                        }
                        
                        if($id!=$row['to_user_id']){
                              $row_class='row justify-content-end';
                           $background_class='alert-light';
                        
                             echo   "<div classs='".$row_class."'><div class='col-sm-10'><div class='shadow-sm alert ".$background_class."'><b>".$user_name."-</b>".$row['chat_message']."<br><div class='text-right'><small><i>".$row['timestamp']."</i></small></div></div></div></div>";
                        }
                    
                      }}
                      

?>