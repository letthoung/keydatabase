<!DOCTYPE html>
<html>
<head>
<?php
	require('includes/fpdf181/fpdf.php');
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
	$page_title = 'Key Database';
	include ('includes/header.html');