<?php
session_start(); // Start the session.

 //If no session value is present, redirect the user:
 //Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {

	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user('login.php');
}
$page_title = 'Main Page';
include ('includes/header.html');

include ('includes/footer.html');
