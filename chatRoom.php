<!DOCTYPE html>
<html>
<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="Library/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script type="text/javascript" src="Library/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Library/js/jquery-3.6.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<title>CHAT ROOM</title>
	<?php session_start(); ?>
	<style type="text/css">
		html,body{
			height: 100%;
			width: 100%;
			margin: 0;
		}
		#wrapper{
			display: flex;
			flex-flow: column;
			 height: 100%;}
	 #remaining{
			 	flex-grow: 1;
			 }
			 #messages{
			 	height: 200px;
			 	background: whitesmoke;
			 	overflow: auto;

			 }
			 #chat-room-frm{
			 	margin-top: 10px;
			 }
			 #chat_list{
			 	height: 450px;
			 	overflow-y: auto;

			 }
  #messages_area{
  	height: 650px;
  	overflow-y: auto;
  		background-color: #e6e6e6;
  }
		
	</style>
  

</head>
<body>
<div class="container">
	<br>
	<h3>PHP Chat Application using Websoket </h3> 
	<br>
	<div class="row">
		<div class="col-lg-8">
			 <div class="card">
			 	<div class="card-header">
			
			 			 	<h3 class="text-center">Chat Room</h3>
			 			 		<a href="privatechat.php" class="btn btn-success btn-sm text-right"> Private Chat</a>
			 			<!-- </div> -->
			 			<!-- <div class="col col-sm-4 text-right">
			 			
			 			</div -->
			 	</div>
			 	<div class="card-body" id="messages_area">
                  <?php
                     require 'DB.php';
                     $msgData=$connect->prepare("SELECT * FROM chatroom INNER JOIN user ON user.user_id = chatroom.user_Id ORDER BY chatroom.id ASC");
                     $msgData->execute();
                     $msgData=$msgData->fetchAll(PDO::FETCH_ASSOC);
                     foreach($msgData as $key){
                     	 
                     	if (isset($_SESSION['user']->user_id)==$key['user_Id']) {
                     		$from="me";
                     		$row_class='row justify-content-start';
                     		$background_class='text-dark alert-light';
                     	}
                     	else{
                     		$row_class='row justify-content-end';
    	                    $background_class='alert-success';
                     	}
                     	 echo "<div classs='".$row_class."'><div class='col-sm-10'><div class='shadow-sm alert ".$background_class."'><b>".$from."-</b>".$key['msg']."<br><div class='text-right'><small><i>".$key['created']."</i></small></div></div></div></div>";

                     }

                 ?>

			 	</div></div>
			 	<form method="POST" id="chat_form">
			 		<div class="input-group mb-3">
                      <textarea class="form-control " id=chat_message name="message" placeholder="Enter Message Here" data-parsley-maxlength="1000"  cols="90"></textarea>
                      <div class="input-group-append">
                      	<button type="submit" name="send" id="Send"  class="btn btn-primary form-control mt-3">Send</button>
                      </div>			 			
			 		</div>
			 		 <?php 
                         if (isset($_SESSION['user'])) {
                         	  $id=$_SESSION['user']->user_id;
                     require 'DB.php';
                 
                   $select=$connect->prepare("SELECT * FROM user WHERE user_id='$id'");
                 
                   
                   $select->execute();

                   foreach ($select as $key) {
                   	// code...
                   


         		?>
         		<input type="hidden" name="userId" id="userId" value="<?php echo $key['user_id']?>">
                       <?php   }}?>

			 		 

			 	</form>

		</div>
				<div class="col-lg-4">
			<?php 
         if (isset($_SESSION['user'])) {
         	?>
         	<div class="mt-3 mb-3 text-center">  
         		<img src="images/<?php echo $_SESSION['user']->image?>" width="150" class="img-fluid rounded-circle img=thumbnail"/>
         		<h3 class="mt-2"><?php echo $_SESSION['user']->user_name?></h3>
         		<a href="profile.php?Edit=<?php echo $_SESSION['user']->user_id?>" class="btn btn-secondary">Edit</a>
         		<a  href="logout.php?logout=<?php echo $_SESSION['user']->user_id?>" class="btn btn-danger" >Logout</a>
         		
         		
         	</div>
         	 
      <?php   }  $created=date("d-m-Y h:i:s");
               
                 
			?>
				<div class="card mt-3">
				<div class="card-header">List Users</div>
				<div class="card-body" id="user">

					<div class="list-group list-group-flush ">
					  <div>
					  	<?php

                         $icon=$connect->prepare("SELECT * FROM user ");
                         $icon->execute();

                           foreach ($icon as $key) {
                         		
                                                		$icons='<i class="fa-sharp fa-solid fa-circle text-danger"></i>';
                         		if ($key['user_login']=='Login') {
                         			$icons='<i class="fa-sharp fa-solid fa-circle text-success"></i>';
 
                         		}
                         		if ($id!=$key['user_id']) {
                         			echo '<a ><img src="images/'.$key['image'].'" class="img-fluid rounded-circle img-thumbnail" width="60"/>
                         			<span class="ml-1"><strong>'.$key['user_name'].'</strong></span>
                         			<span class="mt-2 float-right">'.$icons.'</span></a>';
                         		}
                         	}
                         


					  	?> 

					  </div>	
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>
        <script>
           var conn = new WebSocket('ws://localhost:8080');
      conn.onopen = function(e) {
    console.log("Connection established!");
};


conn.onmessage = function(e) {
    console.log(e.data);
    var data =JSON.parse(e.data);
    var row_class ='';
    var background_class='';
    if (data.from=='me') {
    	row_class='row justify-content-start';
    	background_class='text-dark alert-light';
    }
    else{
    	row_class='row justify-content-end';
    	background_class='alert-success';
    }
    var html_data ="<div classs='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+"-</b>"+data.msg+"<br><div class='text-right'><small><i>"+data.dt+"</i></small></div></div></div></div>";
   $('#messages_area').append(html_data);
   // $('#chat_message').val('');
 };
 $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

$("#Send").click(function(){
          var userId =$('#userId').val();
		 var message= document.getElementById('chat_message').value;
		 		 var data ={
		 	userId: userId ,
		 	msg:message
		 };
		  

       conn.send(JSON.stringify(data));
       $('#chat_message').val('');
           $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
		

     
});
// $('#chat_form').parsley();
// $('#chat_form').on('submit',function(event){
// 	event.preventDefault();
// 	if ($('#chat_form').parsley().isValid()) {
// 		 var user_id =$('#login_user_id').val(); 
// 		 var message= $('#Cat_message').val();
// 		 var data ={
// 		 	userId: user_id ,
// 		 	msg:message
// 		 };

// 	}

// });
        </script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
 
</body>
</html>