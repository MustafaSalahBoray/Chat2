<!DOCTYPE html>
<html>
<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="Library/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Style.css">
  <script type="text/javascript" src="Library/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Library/js/jquery-3.6.1.min.js"></script>
	<title>CHAT ROOM</title>
	<?php session_start();?>

</head>
<body>
<div class="container">
	<br>
	<h3>PHP Chat Application using Websoket </h3>
	<br>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">Profile</div>
				<div class="col-md-6 text-right"><a href="chatRoom.php" class="btn btn-warning btn-sm">Go To Chat</a></div>
			</div>
			
		</div>
		<div class="card-body">
			<?php 
			require 'DB.php';
                 if (isset($_GET['Edit'])) {
                 	$select=$connect->prepare("SELECT * FROM user WHERE user_id=:id");
                 	$select->bindparam("id",$_GET['Edit']);
                 	$select->execute();
                 	// $select=$select->fatchAll(PDO::FETCH_ACCOS);
                 	foreach ($select as $key ) {
                 		
                 	
  
			?>
				<form method="POST"  enctype="multipart/form-data">
							<div class="form-group">
							<label>Enter Your Name</label>	
							<input type="text" name="USERNAME" id="USERNAME" class="form-control" value="<?php echo $key['user_name']?>" >
							</div>
									<div class="form-group">
							<label>Enter Your Email</label>	
							<input type="text" name="Email" id="Email" class="form-control" value="<?php echo $key['user_Email']?>" >
							</div>
									<div class="form-group">
							<label>Enter Your Password</label>	
							<input type="Password" name="Password" id="Password" class="form-control"  min="8" max="12" value="<?php echo $key['user_pasword']?>">
							</div>
							<div class="form-outline">
							<label>Enter Your Profile</label>	
							<input type="file" name="image" id="image" class="form-control" >
							</div>
							
									<div class="form-group">
						<button type="submit" name="Edit" class="btn btn-primary"value="<?php echo $key['user_id']?>">Edit</button>
									</div>
			 				<?php }}?>
														</div>
						</form>

			
		</div>
	</div>	
</div>
</body>
</html>
<?php 
    if (isset($_POST['Edit'])) {
    	    	$fileName=$_FILES['image']['name'];
    	$fileTmp=$_FILES['image']['tmp_name'];
    	$Update=$connect->prepare("UPDATE user SET user_name=:user_name , user_Email=:user_Email,user_pasword=:user_pasword ,image=:image WHERE user_id=:id");
    		$Update->bindparam("user_name",$_POST['USERNAME'] );
    	  $Update->bindparam("user_Email",$_POST['Email'] );
    	 	 $Update->bindparam("user_pasword",$_POST['Password'] );
    	 	 $Update->bindparam("image",$fileName );
                 	$Update->bindparam("id",$_GET['Edit']);

    	 	
    	 	 if ($Update->execute()) {
    	 	 	move_uploaded_file($fileTmp,"images/$fileName");
    	 	 }
    }

?>