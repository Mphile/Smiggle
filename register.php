<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
include 'conf.inc.php';
	echo '<h3>Welcome to Smiggle.</h3>';
	echo '<h4>Login below:</h4>';
	?>
	<form  name="login_form" action="register.php" method="POST">
			Email: &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;<input type="text" name="mail"></input><br/><br/>
			Password:  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="password" name="pass1"></input><br/><br/>
			Repeat password: <input type="password" name="pass2"></input><br/><br/>
			<input type="submit" id="btnRegister" value="Register"></input>
	</form>
	
	<?php
	if(isset($_POST['mail']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
		$email_address = $_POST['mail'];
		$password1 = $_POST['pass1'];
		$password2 = $_POST['pass2'];
		
		if($password1 != $password2){
				echo 'Please ensure passwords match';
		}
		if(filter_var($email_address, FILTER_VALIDATE_EMAIL)){
			 
		}else{
			echo 'Your email ('.$email_address.') address is not valid';
		}
		
		if($password1 == $password2 && filter_var($email_address, FILTER_VALIDATE_EMAIL)){
			$check_user_exists = mysqli_query($link, "select id, email, password from users where email='$email_address' AND password='$password1'") 
									or die("Could not check user:".mysqli_error($link));
									
			if(mysqli_num_rows($check_user_exists)>0){
					echo 'Notice: User with '.$email_address.' already exists.<br/>';
					exit;
			}
			else{
				$add_user = mysqli_query($link, "insert into users values ('NULL','$email_address','$password1')") 
								or die("Could not add to users: ".mysqli_error($link));
				echo 'Registration success.';
				/*********************Login this user********************/
				$select_user = mysqli_query($link, "select id, email, password from users where email='$email_address' AND password='$password1' LIMIT 1") 
								or die("Could not select user :".mysqli_error($link));
				if($temp_user_id = mysqli_fetch_row($select_user)){
					$user_id = $temp_user_id[0];
					$_SESSION['my_user_id'] = $user_id;
					?>
						<script type="text/javascript">
							window.location="users.php";
						</script>
					<?php
				}
				/*****************Ends login in this user****************/
				
			}
		}
	}else{
		echo 'Error: Please fill all fields.';
	}
?>