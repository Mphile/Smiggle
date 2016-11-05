<?php
/*
*******Copyright (c) 2016, Nkosi Nzotho****
*******All rights reserved.****
*/
session_start();
date_default_timezone_set('Africa/Johannesburg');
ini_set('display_errors', 'on');


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 /*****************Connect to database*********************************/
            $server="localhost";
            $db_user="root";
            $db_pass="password";
			$database="smiggle_chat";
			
            // connect to the mysql server
            $link = mysqli_connect($server, $db_user, $db_pass, $database);
					

            if (mysqli_connect_errno())
			  {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
           
			//set time zone
            $set_zone = mysqli_query($link, 'SET GLOBAL time_zone =Africa,Johannesburg');
			$setTime = mysqli_query($link, "SET time_zone = '+2:00'") or die();
   /********************END connection to database***************************/
     
   
?>
 