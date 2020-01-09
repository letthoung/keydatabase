<?php
	session_start(); // Start the session.

// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) ))
{
	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user('index.php');
}
	require("includes/mysqli_connect.php");
if(isset($_POST['tag'])){
	$firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
	$lastname = addslashes($lastname);
	$firstname = addslashes($firstname);
	$tag = $_POST['tag'];

	$sql = "SELECT * FROM key_database WHERE firstname = '$firstname' AND lastname = '$lastname'AND tag = '$tag' ORDER BY dataid DESC";
	$result = mysqli_query($dbc, $sql);
	$row = mysqli_fetch_assoc($result);
	$arr = array($row['employeenum'], $row['iso'], $row['department'], $row['status'],$row['idlink'],$row['emprm'],$row['empbld']);
	echo json_encode($arr);
	}
	elseif (isset($_POST['keyname'])) {

		// code...
		$keyname = $_POST['keyname'];
		$sql = "SELECT door_number, building FROM doors WHERE door_id IN (SELECT door_id FROM door_key WHERE key_id = '$keyname')";
		$rs = mysqli_query($dbc, $sql);
		$array = array();
		$bldarray = array();
		$counter = 0;
		$flag = flase; // flag for master key 
		$masterIndex = 0;
		while ($row = mysqli_fetch_array($rs) ){
			$array[$counter] = $row['door_number'];
			$bldarray[$counter] = $row['building'];
			if(substr($array[$counter], 0, 3) == 'IMP'){
				$flag = true;
				$masterIndex = $counter;
			}
			$counter ++;
		}
		//If it is Just the master key that opens a key, then return the IMP masterkey value.
		// Suggest the master key if its is the only key opening the doors
		// if the master is the only key, the result should be 2 values where one is the IMP key and the other is the previous keys xml_set_unparsed_entity_decl_handle
		//otherwise just echo the first value
		
		$bldnum = $bldarray[$masterIndex];

		$sql2 = "SELECT DISTINCT bld_name FROM Buildings WHERE bld_no = '$bldnum' ORDER BY bld_name";
		$rs = mysqli_query($dbc, $sql2);
		$row = mysqli_fetch_array($rs);
		$bldname = $row[0];

		if($flag){
		 		echo json_encode([$array[$masterIndex], $bldname ]);
		}
		else{
		 echo json_encode([$array[0], $bldname ]);
		}
		

	}
else{
	$firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
	$lastname = addslashes($lastname);
	$firstname = addslashes($firstname);

	$sql = "SELECT DISTINCT tag FROM key_database WHERE firstname = '$firstname' AND lastname = '$lastname' ORDER BY dataid DESC";
	$q1 = mysqli_query($dbc, $sql);
	$tag;
	$employeenum;
	$iso;
	$status;
	$department;
if(mysqli_num_rows($q1)!=1){
		$sql = "SELECT DISTINCT tag FROM key_database WHERE firstname = '$firstname' AND lastname = '$lastname' ORDER BY dataid DESC";
		$q2 = mysqli_query($dbc, $sql);
	$tag = array('tags');
		while($row = mysqli_fetch_assoc($q2)){
			$tag[]= $row['tag'];
		}
		echo json_encode($tag);
}
else{
	$sql = "SELECT * FROM key_database WHERE firstname = '$firstname' AND lastname = '$lastname' ORDER BY dataid DESC";
	$q2 = mysqli_query($dbc, $sql);
	$row = mysqli_fetch_assoc($q2);
	$tag = $row['tag'];
	$employeenum = $row['employeenum'];
	$iso = $row['iso'];
	$department =  $row['department'];
	$status = $row['status'];
	$idlink = $row['idlink'];
	$emprm = $row['emprm'];
	$empbld = $row['empbld'];
	$arr = array($tag,$employeenum,$iso,$department,$status,$idlink,$emprm,$empbld);
	echo json_encode($arr);
}
}
