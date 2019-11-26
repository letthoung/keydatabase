<?php 
session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) 
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	//This page will be used to edit exterior light records. If the user is of a sufficient admin level it makes the changes to the exterior_lights table.
	//If they are not it submits the edits to be made so that an admin can look at them and either accept or deny them.
	
	require ('includes/mysqli_connect.php');
	
	$return = array();
	if (isset ($_GET['w'])){
		$department = $_GET['w'];
		// Cost center 
		$q1 = "SELECT DISTINCT costcenter FROM department WHERE dep = '$department'";
		$r1 = mysqli_query($dbc, $q1);
		$cc;
		while ($row1 = mysqli_fetch_array($r1)){
			$cc = $row1[0]; 
		}
		$return [] = $cc;
		mysqli_free_result($rs1);
		
				// employee building 
		$q2 = "SELECT DISTINCT empbld FROM department WHERE dep = '$department'";
		$r2 = mysqli_query($dbc, $q2);
		$empbld;
		while ($row2 = mysqli_fetch_array($r2)){
			$empbld = $row2[0]; 
		}
		$return [] = $empbld;
		mysqli_free_result($rs2);
		
				// employee room 
		$q3 = "SELECT DISTINCT emprm FROM department WHERE dep = '$department'";
		$r3 = mysqli_query($dbc, $q3);
		$emprm;
		while ($row3 = mysqli_fetch_array($r3)){
			$emprm = $row3[0]; 
		}
		$return [] = $emprm;
		mysqli_free_result($rs3);
		
		echo json_encode($return);
		
	}
		
	




?>