



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
					<div class="card-header">Register</div>
					<div class="card-body">
						<form method="POST">
							<div class="form-group">
							<label>Enter Your Name</label>	
							<input type="text" name="USERNAME" id="USERNAME" class="form-control" >
							</div>
									<div class="form-group">
							<label>Enter Your Email</label>	
							<input type="text" name="Email" id="Email" class="form-control" >
							</div>
									<div class="form-group">
							<label>Enter Your Password</label>	
							<input type="Password" name="Password" id="Password" class="form-control"  min="8" max="12">
							</div>
							
									<div class="form-group">
						<button type="submit" name="submit" class="btn btn-success">Register</button>
						<a href="http://localhost/Chat2/Login.php" class="btn btn-danger">Login</a>
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
      $fileName='profile.jpeg';
 
   	   require 'DB.php';
    
    	 			$InsertUser=$connect->prepare("INSERT INTO user (user_name,user_Email,user_pasword,image) VALUES(:user_name,:user_Email,:user_pasword,:image)");
    	 	$InsertUser->bindparam("user_name",$_POST['USERNAME'] );
    	  $InsertUser->bindparam("user_Email",$_POST['Email'] );
    	 	 $InsertUser->bindparam("user_pasword",$_POST['Password'] );
    	 	 $InsertUser->bindparam("image",$fileName );
    	 	
    	 if ( $InsertUser->execute()) {
  
    	 }
    	 else{
    	 	echo "string";
    	 }

    	 	}
    	 
    	 

     



?>
