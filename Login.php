



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="Library/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Style.css">
  <script type="text/javascript" src="Library/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Library/js/jquery-3.6.1.min.js"></script>
	<title>CHAT ROOM</title>
</head>
<body>
	<div class="container">
		<br><br>
		<h1 class="text-center">PHP CHAT Application using Websoket</h1>
		<div class="row justify-content-md-center">
			<div class="col col-md-4 mt-5">
				<div class="card">
					<div class="card-header">Login</div>
					<div class="card-body">
						<form method="POST">
							
							<div class="form-group">
							<label>Enter Your Email</label>	
							<input type="text" name="Email" id="Email" class="form-control" >
							</div>
									<div class="form-group">
							<label>Enter Your Password</label>	
							<input type="Password" name="Password" id="Password" class="form-control"  min="8" max="12">
							</div>
									<div class="form-group">
						<button type="submit" name="submit" class="btn btn-success">Login</button>
						<a href="http://localhost/Chat2/register.php" class="btn btn-danger">Register</a>
									</div>
			 				
														</div>
						</form>

						
					</div>
					
				</div>
			</div>
			
		</div>
		

	</div>

</body>
</html>

<?php
   if (isset($_POST['submit'])) {
   	 // session_start();
   	 // if (isset($_SESSION['user_data'])) {
   	 // 	header('location:chatRoom.php');
   	 // } 
   	   require 'DB.php'; 
   	   $selec=$connect->prepare("SELECT * FROM user WHERE user_Email=:user_Email AND user_pasword=:user_pasword");
   	       	  $selec->bindparam("user_Email",$_POST['Email'] );
    	 	 $selec->bindparam("user_pasword",$_POST['Password'] );
    	 	 $selec->execute();
    	 	 if ($selec->rowcount()==1) {
    	 	 	$user=$selec->fetchObject();
    	 	 	session_start();
    	 	 	$_SESSION['user']=$user;
          $Update=$connect->prepare("UPDATE user SET user_login='Login' WHERE user_Email=:user_Email AND user_pasword=:user_pasword");
             	       	  $Update->bindparam("user_Email",$_POST['Email'] );
    	 	 $Update->bindparam("user_pasword",$_POST['Password'] );
    	 	  $Update->execute();
    	 	  	// code...

    	 	 	header('location:chatRoom.php');
    	 	 }
    	 	 else{
    	 	 	echo "string";
    	 	 }
    
    	 		

    	 	}
    	 
    	 

     



?>
