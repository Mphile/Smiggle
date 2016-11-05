<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
	include 'conf.inc.php';
	
	session_destroy();
	
	mysqli_close($link);
?>
<script type="text/javascript">
		window.location="login.php";
</script>