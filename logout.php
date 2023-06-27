<?php 
    if (isset($_GET['logout'])) {
    	require 'DB.php';
               $Update=$connect->prepare("UPDATE user SET user_login='Logout' WHERE user_id=:id");
              $Update->bindparam("id",$_GET['logout'] );
    	 	 if (  $Update->execute()) {
    	 	 	// code...
    	 	 
    	 	                        session_destroy();
                        session_unset();
                        header("location:Login.php");
                }
                        }



?>