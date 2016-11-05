<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
	include 'conf.inc.php';

	if(isset($_SESSION['my_user_id']) && isset($_SESSION['friend_id'])){
		$my_user_id = $_SESSION['my_user_id'];
		$friend_id = $_SESSION['friend_id'];
	 
		
		$select_friend = mysqli_query($link, "select id,email,password from users where id='$friend_id' LIMIT 1") 
						or die("could not select from users:".mysqli_error($link));
			$temp_friend_email = mysqli_fetch_row($select_friend);
			$friend_email = $temp_friend_email[1];
			
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
			}
		
	
		
	}
				
	mysqli_close($link);
?>