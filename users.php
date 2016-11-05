<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/

include 'conf.inc.php';

if(isset($_SESSION['my_user_id'])){
	$my_user_id = $_SESSION['my_user_id']; //so my profile will not show. I dont want to chat to myself
}else{//not logged in.
	?>
	 <script type="text/javascript">
			window.location="login.php";
	 </script>

	<?php
}

echo '<h3>Friends</h3>';

$get_my_email_address =  mysqli_query($link, "select id,email,password from users where id='$my_user_id' LIMIT 1") 
							or die("could not select from users:".mysqli_error($link));
$temp_my_email = mysqli_fetch_row($get_my_email_address);
$my_email_address = $temp_my_email[1];
echo 'Logged as: '.$my_email_address.'&nbsp; &nbsp; &nbsp; &nbsp; <a href="logout.php">Logout</a><br/><br/>';

$select_users = mysqli_query($link, "select id,email,password from users where NOT id='$my_user_id'") // I do not want to chat to myself 
					or die("could not select from users:".mysqli_error($link));
while($user = mysqli_fetch_row($select_users)){
	  $user_id = $user[0];
	  $user_email = $user[1];
		$chats_to_this_user = mysqli_query($link, "select id, message_content, from_user_id, to_user_id from messages where (from_user_id='$user_id' AND to_user_id='$my_user_id') OR (from_user_id='$my_user_id' AND to_user_id='$user_id')") 
								or die("Could not select from users :".mysql_error($link));//select (messages directed to me) OR (messages I sent to this user)
							
		if(mysqli_num_rows($chats_to_this_user)>0){
			$button_message = 'Continue chatting';
		}
		else{
			$button_message = 'Start chatting';
		}
		
		/**************Check unread messages to this user******************************/
		$read=0;
		$select_messages = mysqli_query($link, "select id,message_content,from_user_id, to_user_id from messages where to_user_id='$my_user_id' AND from_user_id='$user_id' AND read_flag='$read'") 
								or die("Could not select messages: ".mysqli_error($link));
								
		$num_unread = mysqli_num_rows($select_messages);
		/***********ENDS checking new messages to this user****************************/
		if($num_unread>0){
			echo $user_email.' ('.$num_unread.') Unread| <a href="chat.php?f_id='.$user_id.'">'.$button_message.'</a><br/>';
		}else{
			echo $user_email.' | <a href="chat.php?f_id='.$user_id.'">'.$button_message.'</a><br/>';
		}
}

mysqli_close($link);
?>