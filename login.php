<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
	include 'conf.inc.php';
	echo '<h3>Welcome to Smiggle.</h3>';
	echo '<h4>Login below:</h4>';
	?>
	<form  name="login_form" action="login.php" method="POST">
			Email: &nbsp; &nbsp; &nbsp;&nbsp;<input type="text" name="mail"></input><br/><br/>
			Password: <input type="password" name="pass"></input><br/><br/>
			
			<input type="submit" id="btnLogin" value="Login"></input>
			&nbsp; &nbsp;<a href="register.php">Register</a>
	</form>
	
	<?php
	
	if(isset($_POST['mail']) && isset($_POST['pass'])){
		$email = $_POST['mail'];
		$email = trim($email);
		$password = $_POST['pass'];
		$password = trim($password);
	
		$email = mysqli_real_escape_string($link, $email);
		$password = mysqli_real_escape_string($link, $password);
		if(strlen($email)>0 && strlen($password)>0){
				$select_user = mysqli_query($link, "select id, email, password from users where email='$email' AND password='$password' LIMIT 1") 
								or die("Could not select user :".mysqli_error($link));
				if($temp_user_id = mysqli_fetch_row($select_user)){
					$user_id = $temp_user_id[0];
					$_SESSION['my_user_id'] = $user_id;
					?>
						<script type="text/javascript">
							window.location="users.php";
						</script>
					<?php
				}else{ //invalid credentials
					echo 'Wrong email address or password.';
					?>
					
					<?php
				}
		}
	}
	mysqli_close($link);
?>