<?php
	require('includes/fpdf181/fpdf.php');
	require('includes/PHPExcel-1.8/Classes/PHPExcel.php');
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) OR ($_SESSION['admin_level'] < 1) )
	{
		// Need the functions:
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	require("includes/mysqli_connect.php");
	require ('includes/login_functions.inc.php');
	$page_title = 'Delete Key';
	include ('includes/header.html');

	$id = $_GET['id'];
	foreach($id as $val){
		$sql = "DELETE FROM key_database WHERE dataid = '".$val."'";
		@mysqli_query($dbc, $sql);
		echo "Record with id ".$val." has been deleted";
		$userfirstname = $_SESSION['first_name'];
		$userlastname = $_SESSION['last_name'];
		$action = 'DELETED key record with id '.$val;
		recordTimestamp($userfirstname , $userlastname ,$action );
	}




?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
</head>
<body>

</body>

</html>
