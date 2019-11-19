<!DOCTYPE html>
<html>
<head>
<?php
	require('includes/fpdf181/fpdf.php');
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	/*if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) OR ($_SESSION['admin_level'] < 1) )
	{
		// Need the functions:
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}*/
	require("includes/mysqli_connect.php");
	//require ('includes/login_functions.inc.php');
	$page_title = 'Key Database';
	include ('includes/header.html');
    
    //Get information from the form if user submitted a search
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		$dataid = $_POST['dataid'];
		$lastname = $_POST['lastname'];
		$firstname = $_POST['firstname'];
		$employeenum = $_POST['employeenum'];
		$ssn = $_POST['ssn'];
		$iso = $_POST['iso'];
		$disposition = $_POST['disposition'];
		$dispositiondate = $_POST['dispositiondate'];
		$idlink = $_POST['idlink'];
		$empbld = $_POST['empbld'];
		$emprm = $_POST['emprm'];
		$tag = $_POST['tag'];
		$keyname = $_POST['keyname'];
		$series = $_POST['series'];
		$keybld = $_POST['keybld'];
		$keyrm = $_POST['keyrm'];
		$issuedate = $_POST['issuedate'];
		$department = $_POST['department'];
		$receiptdate = $_POST['receiptdate'];
		$status = $_POST['status'];

	}

	else
	{
	    $dataid = (isset($_GET['dataid']))? $_GET['dataid']:'';
		$lastname = (isset($_GET['lastname']))? $_GET['lastname']:'';
		$firstname = (isset($_GET['firstname']))? $_GET['firstname']:'';
		$employeenum = (isset($_GET['employeenum']))? $_GET['employeenum']:'';
		$ssn = (isset($_GET['ssn']))? $_GET['ssn']:'';
		$iso = (isset($_GET['iso']))? $_GET['iso']:'';
		$disposition = (isset($_GET['disposition']))? $_GET['disposition']:'';
		$dispositiondate = (isset($_GET['dispositiondate']))? $_GET['dispositiondate']:'';
		$idlink = (isset($_GET['idlink']))? $_GET['idlink']:'';
		$empbld = (isset($_GET['empbld']))? $_GET['empbld']:'';
		$emprm = (isset($_GET['emprm']))? $_GET['emprm']:'';
		$tag = (isset($_GET['tag']))? $_GET['tag']:'';
		$keyname = (isset($_GET['keyname']))? $_GET['keyname']:'';
		$series = (isset($_GET['series']))? $_GET['series']:'';
		$keybld = (isset($_GET['keybld']))? $_GET['keybld']:'';
		$keyrm = (isset($_GET['keyrm']))? $_GET['keyrm']:'';
		$issuedate = (isset($_GET['issuedate']))? $_GET['issuedate']:'';
		$department = (isset($_GET['department']))? $_GET['department']:'';
		$receiptdate = (isset($_GET['receiptdate']))? $_GET['receiptdate']:'';
		$status = (isset($_GET['status']))? $_GET['status']:'';
	}
    
    if (isset($_GET['s']) && is_numeric($_GET['s'])) //Find the starting point or initialize to zero
	{
		$start = $_GET['s'];
	}
	else
	{
		$start = 0;
	}

	$display = 15;

	if($lastname != '' || $firstname != '' || $employeenum != '' || $ssn != '' || $iso != '' || $disposition != '' || $dispositiondate != '' || $idlink != '' || $empbld != '' || $emprm != '' || $tag != '' || $keyname != '' || $series != '' || $keybld != '' || $keyrm != '' || $issuedate != '' || $department != '' || $receiptdate != '' || $status != '')
	{
		if($lastname != '')
		{
		$query = "SELECT * FROM key_database WHERE lastname = '$lastname' ORDER BY 'lastname' LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE lastname = '$lastname'";
	}
		if($firstname != '')
		{
		$query = "SELECT * FROM key_database WHERE firstname = '$firstname' ORDER BY firstname LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE firstname = '$firstname'";
	}
		if($employeenum != '')
		{
		$query = "SELECT * FROM key_database WHERE employeenum = '$employeenum' ORDER BY employeenum LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE employeenum = '$employeenum'";
	}
		if($ssn != '')
		{
		$query = "SELECT * FROM key_database WHERE ssn = '$ssn' ORDER BY ssn LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE ssn = '$ssn'";
	}
		if($iso != '')
		{
		$query = "SELECT * FROM key_database WHERE iso = '$iso' ORDER BY iso LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE iso = '$iso'";
	}
		if($disposition != '')
		{
		$query = "SELECT * FROM key_database WHERE disposition = '$disposition' ORDER BY disposition LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE disposition = '$disposition'";
	}
		if($dispositiondate != '')
		{
		$query = "SELECT * FROM key_database WHERE dispositiondate = '$dispositiondate' ORDER BY dispositiondate LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE dispositiondate = '$dispositiondate'";
	}
		if($idlink != '')
		{
		$query = "SELECT * FROM key_database WHERE idlink = '$idlink' ORDER BY idlink LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE idlink = '$idlink'";
	}
		if($empbld != '')
		{
		$query = "SELECT * FROM key_database WHERE empbld = '$empbld' ORDER BY empbld LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE empbld = '$empbld'";
	}
		if($emprm != '')
		{
		$query = "SELECT * FROM key_database WHERE emprm = '$emprm' ORDER BY emprm LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE emprm = '$emprm'";
	}
		if($tag != '')
		{
		$query = "SELECT * FROM key_database WHERE tag = '$tag' ORDER BY tag LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE tag = '$tag'";
	}
		if($keyname != '')
		{
		$query = "SELECT * FROM key_database WHERE keyname = '$keyname' ORDER BY keyname LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE keyname = '$keyname'";
	}
		if($series != '')
		{
		$query = "SELECT * FROM key_database WHERE series = '$series' ORDER BY series LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE series = '$series'";
	}
		if($keybld != '')
		{
		$query = "SELECT * FROM key_database WHERE keybld = '$keybld' ORDER BY keybld LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE keybld = '$keybld'";
	}
		if($keyrm != '')
		{
		$query = "SELECT * FROM key_database WHERE keyrm = '$keyrm' ORDER BY keyrm LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE keyrm = '$keyrm'";
	}
		if($issuedate != '')
		{
		$query = "SELECT * FROM key_database WHERE issuedate = '$issuedate' ORDER BY issuedate LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE issuedate = '$issuedate'";
	}
		if($department != '')
		{
		$query = "SELECT * FROM key_database WHERE department = '$department' ORDER BY department LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE department = '$department'";
	}
		if($receiptdate != '')
		{
		$query = "SELECT * FROM key_database WHERE receiptdate = '$receiptdate' ORDER BY receiptdate LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE receiptdate = '$receiptdate'";
	}
		if($status != '')
		{
		$query = "SELECT * FROM key_database WHERE status = '$status' ORDER BY status LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE status = '$status'";
	}
	}
	else
	{
		$query = "SELECT key_database.* FROM key_database Order By dataid DESC LIMIT $start,$display";
		$query2 = "SELECT key_database.* FROM key_database";
	}
    
    
    
    $result = mysqli_query($dbc, $query);
	$rscount = mysqli_query($dbc, $query2);
	$records = mysqli_num_rows($rscount);

	if (isset($_GET['p']) && is_numeric($_GET['p'])) //Get the number of pages, either from $_GET or calculate from query results
	{
		$pages = $_GET['p'];
	}
	else
	{
		if ($records > $display)
		{
			$pages = ceil ($records/$display);
		}
		else
		{
			$pages = 1;
		}
	}
    
    // he may want to check if some errors occur
	/*if(!empty($errors))
	{
		echo '<p class = "error">Errors:</p>';
		foreach($errors as $value)
		{
			echo '<p class = "error">' . $value . '</p>';
		}
	}*/


?>
    


<!--This is the main html code-->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type = "text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" >
<script type = "text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/js/dataTables.checkboxes.min.js"></script>

<script type = "text/javascript">

	$(document).ready(function(){
		$('#checkall').click(function(){
			$('.checklist').prop('checked',this.checked);
		});
		//Select2
	 $('.search-select').select2({
		 placeholder: 'Select a Value',
		 allowClear: true
	 });
	});

	</script>
<style>
th{
	background-color: white;
	color: #000;
	font-size: 1.1em;
}
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
background-color: #EEEBD0;
color: #000;
}
body{
	background-color: #ECEBE4;
	border: 5px groove #BDC4A7;
	margin: 6px;
	margin-right: 8px;
	}
</style>
</head>
<body onLoad= "load()">
	<div>
	<img src="norse.jpeg" style="width:150px; position: absolute; right: 3.5%; top: 3.5%;"> 
	</div>
	<div class="container-fluid">
		<a href = "http://norsegis.nku.edu/locksmith.php" target = "_self" class = "btn btn-default"style="margin-left:50px;">Back</a><br><br>
		<form id = "key-search" action=" " method="post" name = "key-search" >
			<input type="text" placeholder = 'Search' name = "name" id = "name">
            
			<select name = "keybld" class = "search-select" id = "keybld" style = "width:150px">
			<option value = 'all' <?php if($keybld ==''){echo 'selected';}?>>All Buildings</option>
                <?php
                //#E0EFFF
                $q = "SELECT DISTINCT keybld FROM key_database WHERE keybld != '' ORDER BY keybld";
                $rs = mysqli_query($dbc, $q);
                while($row = mysqli_fetch_array($rs)){
                    echo '<option value = "' . $row['keybld'] . '" ';
                    if($miscbrand != '' && $miscbrand == $row['keybld']){
                        echo ' selected ';
                    }
                    echo '>' . $row['keybld'] . '</option>';
                }
                mysqli_free_result($rs);
                ?>
			</select>
			<select name = "department" class = "search-select" id = "department" style = "width:200px">
                <option value = "all">Department</option>
                <?php
                /*change here*/
                $q = "SELECT dep, idlink FROM department ORDER BY dep";
                $rs = @mysqli_query($dbc, $q);
                while($ro = mysqli_fetch_array($rs))
                {
                    echo '<option value = "' . $ro['idlink'] . '" ';
                    echo '>' . $ro['dep'] . '</option>';
                }
                mysqli_free_result($rs);
                ?>
            </select>

            <select id = "disposition" class = "search-select" name = "disposition" style = "width: 200px">
                <option value="all">Disposition</option>
                <option value = "Processing"> Processing </option>
                <option value = "Assigned"> Assigned </option>
                <option value = "Returned"> Returned </option>
                <option value = "Lost-Not-Paid"> Lost-Not Paid </option>
                <option value = "Lost-Paid"> Lost-Paid </option>
                <option value = "Lost-Stolen"> Lost-Stolen </option>
                <option value = "Left University"> Left University</option>
                <option value = "No Receipt"> No Receipt</option>
            </select>

			<br>
			<label>Search By: </label>
			<input type = "checkbox" id = "check-tag" value = "tag">Tag
			<input type = "checkbox" id = "check-key" style = "margin-left: 10px" value = "keyname">Key
			<!--<input type = "checkbox" id = "check-dep" style = "margin-left: 10px" value = "department">Department/Costcenter</input>-->

			<hr>
			
			<input type = "submit" class = "btn btn-default" name = "search-box">
			<a href = "keydatabase.php" class="btn btn-default">Clear Search</a>
			<br>
		</form>
	</div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    