<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8"/>
	<script src="js/jquery-3.1.1.min.js"></script>
</head>
<body>
<script>
		$(document).ready(function () {
    var interval = 12000;   //number of mili seconds between each call
    var refresh = function() {
        $.ajax({
            url: 'check_new_messages.php',
            cache: false,
            success: function(html) {
				
                $('#chat_messages').html(html);
                setTimeout(function() {
                    refresh();
                }, interval);
            }
        });
    };
    refresh();
});
</script>
<?php

	include 'conf.inc.php';
	
	if(!isset($_SESSION['my_user_id'])){// not logged in
		?>
		<script type="text/javascript">
			window.location="login.php";
		</script>
		<?php
		
	}
	
	$my_user_id = $_SESSION['my_user_id'];
	if(isset($_GET['f_id']))
			$friend_id = $_GET['f_id'];
	else
			$friend_id = $_SESSION['friend_id'];
	$friend_id = mysqli_real_escape_string($link, $friend_id);
	
		if(is_numeric($friend_id)){
			
			$_SESSION['friend_id'] = $friend_id;//session created for persistent friendID after page reloads (on each message sent)
			
			
	/*****************************Send message to friend***************/
	if(isset($_POST['message_to_send'])){
		
			$message_to_send = $_POST['message_to_send'];
			$message_to_send = mysqli_real_escape_string($link, $message_to_send);
			$message_to_send = trim($message_to_send);
			if(strlen($message_to_send)>0){
				$message_to_send = str_replace('+','', $message_to_send);
				$read_flag = 0;
				$insert_to_messages = mysqli_query($link, "insert into messages values('NULL', '$message_to_send','$my_user_id', '$friend_id','$read_flag')")
										or die("Could not insert to messages: ".mysqli_error($link));
			}
			
	}
	/**********************Ends sending message to friend section******/
			
			
			$select_friend = mysqli_query($link, "select id,email,password from users where id='$friend_id' LIMIT 1") 
						or die("could not select from users:".mysqli_error($link));
			$temp_friend_email = mysqli_fetch_row($select_friend);
			$friend_email = $temp_friend_email[1];
			
			echo '<a href="users.php">All friends</a>';
			echo '<h3>Chat with '.$friend_email.'</h3>';
			echo '<div id="chat_messages">';
			
			
			$select_messages = mysqli_query($link, "select id,message_content,from_user_id, to_user_id from messages where (from_user_id='$my_user_id' AND to_user_id='$friend_id') OR (from_user_id='$friend_id' AND to_user_id='$my_user_id')") 
								or die("Could not select messages: ".mysqli_error($link));
			$indicator_message = 'Message:';					
			while($temp_message = mysqli_fetch_row($select_messages)){
				 $message_id = $temp_message[0];
				$message_content = $temp_message[1];
				$from_user_id = $temp_message[2];
				$to_user_id = $temp_message[3];
				
				if($from_user_id == $my_user_id){//if message is from "Me"
					echo '<p>Me: <br/>'.$message_content.'</p>';
				}
				else{
					echo '<p>'.$friend_email.': '.$message_content.'</p>';
					$indicator_message = 'Reply:';
				}
				
						/*********Update this message as "read"******************/
		
			 
			  
				if($to_user_id==$my_user_id){
										
										 echo 'Updating...';
										$read_val = 1;
										 
										$update_message = mysqli_query($link,"update messages set read_flag='$read_val' where id='$message_id' LIMIT 1") 
															or die("Could not update message:".mysqli_error($link));//set this message to me as "read"
										
										
										
							}
		
		/********Ends updating message as "read"*****************/

				
			}
			
			echo '</div>';
			?>
				<form name="chat_form" action="chat.php" method="POST">
				  <?php echo $indicator_message; ?><input type="text" name="message_to_send"></input><br/><br/>
					<input type="submit" value="Send"></input>
				</form>
			<?php
	}else{
		echo 'Requested page not found &nbsp; ';
		echo '<a href="users.php"> Back home</a>';
		exit;
	}
	
	
	
	
	
	
	

	
mysqli_close($link);	
?>
</body>
</html>