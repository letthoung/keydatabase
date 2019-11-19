<?php
session_start(); // Start the session.
require("includes/mysqli_connect.php");


// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
require ('includes/login_functions.inc.php');
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) ))
{
  redirect_user('index.php');
}
$idList = $_GET['idList'];
//$idList = array("43875", "43874");
foreach ($idList as $id) {
  $sql = "UPDATE key_database SET disposition = 'Assigned' WHERE dataid = '$id'";
  mysqli_query($dbc, $sql);
  //echo $id."<br>";
  //Record timestamp
  $userfirstname = $_SESSION['first_name'];
	$userlastname = $_SESSION['last_name'];
	$action = 'Set dispostion to Assigned for value at dataid '. $id;
	recordTimestamp($userfirstname , $userlastname ,$action );
}

 ?>
