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
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-3 col-md-4 col-sm-5" style="background-color: #f1f1f1; height:100vh ; border-right: 1px solid #ccc;">
			      		<?php 
         if (isset($_SESSION['user'])) {
            	$id=$_SESSION['user']->user_id;
         	?>
         	<div class="mt-3 mb-3 text-center">  
         		<img src="images/<?php echo $_SESSION['user']->image?>" width="150" class="img-fluid rounded-circle img=thumbnail"/>
         		<h3 class="mt-2"><?php echo $_SESSION['user']->user_name?></h3>
         		<a href="profile.php?Edit=<?php echo $_SESSION['user']->user_id?>" style="cursor: pointer;" class="btn btn-secondary">Edit</a>
         		<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $id;?>">
         		
         	</div>
         	<a style="text-decoration: none;"></a>
         	 
      <?php   }
        require 'DB.php';
     
          $select=$connect->prepare("SELECT * FROM user ");
          $select->execute();
          $select=$select->fetchAll(PDO::FETCH_ASSOC);
         
          foreach ($select as $key ) {
               	$icons='<i class="fa-sharp fa-solid fa-circle text-danger"></i>';
                         		if ($key['user_login']=='Login') {
                         			$icons='<i class="fa-sharp fa-solid fa-circle text-success"></i>';
                                                   		}
                         		if ($id!=$key['user_id']) {
                         		    
                         		     echo '<a   class ="selectUser" style="text-decoration: none; color:black;cursor: pointer;" href="privatechat.php?action='.$key['user_id'].'"
                         		    data-userid="'.$key['user_id'].'" ><img src="images/'.$key['image'].'" class="img-fluid rounded-circle img-thumbnail" width="60"/>
                         			<span class="ml-1" ><strong><span id="list_user_name'.$key['user_id'].'">'.$key['user_name'].'</span>
                         		

                         			</strong></span>
                         			<span class="mt-2 float-right"id="userstatus_'.$key['user_id'].'">'.$icons.'</span></a>';

          }}
       ?>
               



			    <div class="list-group" style="max-height: 100vh;  margin-bottom: 10px; overflow-y: scroll;-webkit-overflow-scrolling:touch;">
			    	  
			    </div>
		</div>
		<div class="col-lg-9 col-md-8 col-sm-7">
			<br>
	<h3 class="text-center">PHP Chat Application using Websoket </h3> 
	<br>
	<div id="chat_area"></div>
	<?php if (isset($_GET['action'])) {
      require 'DB.php';
     
      $user=$connect->prepare("SELECT * FROM user WHERE user_id=:id");
      $user->bindparam("id",$_GET['action']);
      $user->execute();
      $user=$user->fetchAll(PDO::FETCH_ASSOC);
      foreach ($user as $key ) {
       	$from_user_id=$key['user_id'];
      	$user_name=$key['user_name'];

      
?>



<div class="card">
            <div class="card-header" >
              <div class="row">
               <div class="col col-sm-6">
               <b>chat With <span class="text-danger" id="chat_user_name"><?php echo $key['user_name'];?></span></b> 
               </div>
               <div class="col col-sm-6 text-right">
                  <a href="chatRoom.php" class="btn btn-success btn-sm">Group Chat</a>
                  <button type="button" class="close" id="close_chat_area" data-dismiss="alert" area-label="close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
              </div>
            </div>
            <div class="card-body" id="messages_area">
                  
                    
            </div></div>
            <form method="POST" id="chat_form" data-parsley-errors-container="#validation_error">
               <div class="input-group mb-3" style="height:7vh;">
                       <textarea class="form-control " style="width:95% ;" id=chat_message name="message" placeholder="Enter Message Here" data-parsley-maxlength="1000" data-parsley-paattern="/^[a-zA-Z0-9\s]+$/" required cols="90"></textarea>
                       <div class="input-group-append">
                        <button type="submit" name="send" id="Send"  class="btn btn-primary " style="width: 100px; height:55px;"><i class="fa-solid fa-paper-plane"></i></button>
                        <input type="hidden" name="to_user_id" id="to_user_id"value="<?php echo $id?>">
                        <input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $key['user_id']?>">
                        <input type="hidden" name="" id="user_name" value="<?php echo $user_name?>">
                       </div>                
               </div>
               
                  
                 <div id="validation_error"></div>

            </form> <?php }}?>

      </div></div>
       		
	</div>
	
</div>
</body>
 <?php 
    if (isset($_POST['send'])) {
    	require 'DB.php';
          $timestamp=date('Y-m-d h:i:s');
    	   $InsertMessage=$connect->prepare("INSERT INTO chat_message (to_user_id,from_user_id,chat_message,timestamp) VALUES (:to_user_id,:from_user_id,:chat_message,:timestamp)");
    	  $InsertMessage->bindparam("to_user_id",$_POST['to_user_id']);
    	   $InsertMessage->bindparam("from_user_id",$_POST['from_user_id']);
    	  $InsertMessage->bindparam("chat_message",$_POST['message']);
    	   $InsertMessage->bindparam("timestamp",$timestamp);
    	  if ($InsertMessage->execute()) {
    	  	    	   }
    	   else{
    	   	echo "string";
    	    }
    	  }


 ?>


<script type="text/javascript">
$(document).ready(function(){
	setInterval(function(){
    $.ajax({
    	url:"action.php",
    	method:"POST",
    	data:{
    		fromUser:document.getElementById("from_user_id").value,
    		toUser:document.getElementById("to_user_id").value,
    		user_name:document.getElementById("user_name").value
    		   	},
    		dataType:"text",
    		success:function(data)
    		{
    			$('#messages_area').html(data);
    		}
    })
	},1000);
});


	// $(document).ready(function(){
	//	var receiver_user_id ='';
// 		  var conn = new WebSocket('ws://localhost:8080');
//       conn.onopen = function(e) {
//     console.log("Connection established!");
// };
// conn.onmessage = function(e) {
//     console.log(e.data);
//     var data=JSON.parse(e.data);
//     var row_class ='';
//     var background_class='';
//     if (data.from=='me') {
//     	row_class='row justify-content-start';
//     	background_class='alert-primary';
//     }
//     else{
//     	row_class='row justify-content-end';
//     	background_class='alert-success';
//     }
//     if (receiver_user_id==data.userId||data.from=='me') {
//     	if ($('#is_active_chat').val()=='YES') {}
//     }
//     var html_data ="<div classs='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+"-</b>"+data.msg+"<br><div class='text-right'><small><i>"+data.datatime+"</i></small></div></div></div></div>";
//    $('#messages_area').append(html_data);
//  $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
//    $('#chat_message').val('');
   
    		

     
// };
//  function make_chat_area(user_name)
//  {
//  	var html= `
//  	 <div class="card">
//  			 	<div class="card-header">
//  			     <div class="row">
//  			     	<div class="col col-sm-6">
//  			     	<b>chat With <span class="text-danger" id="chat_user_name">`+user_name+`</span></b>	
//  			     	</div>
//  			     	<div class="col col-sm-6 text-right">
//  			     		<a href="chatRoom.php" class="btn btn-success btn-sm">Group Chat</a>
//  			     		<button type="button" class="close" id="close_chat_area" data-dismiss="alert" area-label="close">
//  			     			<span aria-hidden="true">&times;</span>
//  			     		</button>
//  			     	</div>
//  			     </div>
//  			 	</div>
//  			 	<div class="card-body" id="messages_area">
                 

                 

//  			 	</div></div>
//  			 	<form method="POST" id="chat_form" data-parsley-errors-container="#validation_error">
//  			 		<div class="input-group mb-3" style="height:7vh;">
//                        <textarea class="form-control " style="width:95% ;" id=chat_message name="message" placeholder="Enter Message Here" data-parsley-maxlength="1000" data-parsley-paattern="/^[a-zA-Z0-9\s]+$/" required cols="90"></textarea>
//                        <div class="input-group-append">
//                        	<button type="submit" name="send" id="Send"  class="btn btn-primary " style="width: 100px; height:55px;"><i class="fa-paper-plane"></i></button>
//                        </div>			 			
//  			 		</div>
			 		
                  
//                  <div id="validation_error"></div>

//  			 	</form>

//  		</div>`;
//  		$('#chat_area').html(html);
//  		 // $('#chat_form').parsley();
//  }
// $(document).on('click','.selectUser',function(){
// 	receiver_user_id=$(this).data('userid');
// 	var from_user_id=$('#login_user_id').val();
// 	var reciever_user_name =$('#list_user_name'+receiver_user_id).text();
// 	$('.selectUser .active').removeClass('active');
// 	$(this).addClass('active');
// 	make_chat_area(reciever_user_name);
// 	$('#is_active_chat').val('YES');

// 	$.ajax({
// 		 url:"action.php",
//  		 method:"POST",
// 	 data:{action:'fetch_chat',to_user_id:receiver_user_id,from_user_id:from_user_id}, 
// 		 dataType:"JSON",
// 		 success:function(data){
// 		 	if(data.length >0){
//  		 		 var html_data='';
// 	 		for(var count=0;count<data.length;count++){
//  		 			var row_class='';
//  		 			var background_class='';
//  		 			var user_name='';
//  		 			if(data[count].from_user_id==from_user_id){
// 		 				row_class='row justify-content-start';
//  		 				background_class='alert-primary';
//  		 				$user_name='me';
//  		 			}
//  		 			else{
//  		 				row_class='row justify-content-end';
// 		 				background_class='alert-success';
// 		 				user_name=data[count].from_user_name;

// 	 			}
// html_data +=`<div classs='`+row_class+`'><div class='col-sm-10'><div class='shadow-sm alert `+background_class+`'><b>`+user_name+`-</b>`+data[count].chat_message+`<br><div class='text-right'><small><i>`+data[count].timestamp+`</i></small></div></div></div></div>`;
// 	 		}
//        // conn.send(JSON.stringify());

//  		 		$('#userid_'+receiver_user_id).html('');
//  		 				 		$('#messages_area').html(html_data);
//   $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
 

//    }
		 		
//  		 	}
		 
// 	})

// });
// $("#Send").click(function(){
//           var userId =$('#userId').val();
// 		 var message= document.getElementById('chat_message').value;
// 		 		 var data ={
// 		 	userId: userId ,
// 		 	msg:message,
// 		 	receiver_user_id :receiver_user_id,command:'private'
// 		 };
		  

//        conn.send(JSON.stringify(data));$('#chat_message').val('');
//            $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
// });
// });

// </script>
</html>
