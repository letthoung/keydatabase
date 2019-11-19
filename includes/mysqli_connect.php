<?php
	$servername = "localhost:8082";
	$user = "root";
	$pass = "root";
	$db = "ezdslim30004";
	
	//Create connection 
	$dbc = @mysqli_connect($servername,$user, $pass, $db);
	if(mysqli_connect_errno())
	{
		$errors[] = "Database connection unsuccessful.";
	}
?>