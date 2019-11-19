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
	$page_title = 'Department Profile';
	include ('includes/header.html');
			$id = $_GET['id'];
			$q = "SELECT * FROM department WHERE costcenter = '".$_GET['c']."'";
			$r = mysqli_query($dbc, $q);
			$dep;
			$empbld;
			$emprm;
			$name;
			$email;
			$phone;
			while ($row = mysqli_fetch_assoc($r)){
				$dep = $row['dep'];
				$empbld = $row['empbld'];
				$emprm = $row['emprm'];
				$name = $row['name'];
				$phone = $row['phone'];
				$email = $row['email'];
				$name2 = $row['name2'];
				$phone2 = $row['phone2'];
				$email2 = $row['email2'];

				$chair = $row['chair'];
				$dean = $row['dean'];
				$provost = $row['provost'];
			}

			$costcenter = $_GET['c'];

	?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
	td{
		font-size: 14px;
	}
	</style>
	</head>
<body>
	<a href = "keydatabase.php" type = "button" class = "btn btn-secondary btn-lg" style = "margin-left:20%">Back</a>
	<h1>Department Profile</h1>
    <br>
	<div class = "container">
	<table class="table table-hover">
		<tr>
			<td class="col-xs-4">Dept. Name</td>
			<td><?php echo $dep?></td>
		</tr>
		<tr>
			<td >Cost Center</td>
			<td> <?php echo $_GET['c']?></td>
		</tr>
		<tr>
			<td >Building</td>
			<td><?php echo $empbld?></td>
		</tr>
		<tr>
			<td >Room #</td>
			<td><?php echo $emprm?></td>
		</tr>
		<tr>
			<td> Tags</td>
			<td>
		<?php
		$q0 = "SELECT DISTINCT tag FROM key_database WHERE department = '$dep' AND status = 'Master Ring'";
		$r0 = mysqli_query($dbc, $q0);

		while($rw = mysqli_fetch_assoc($r0)){
			if($rw['tag']!=="")
				echo $rw['tag'].", ";
		}


		?>
		</td>
		</tr>
		<tr>
			<td >Designee 1 Name</td>
			<td ><?php echo $name?></td>
		</tr>
		<tr>
			<td >Designee 1 Phone #</td>
			<td ><?php echo $phone?></td>
		</tr>
		<tr>
			<td>Designee 1 Email</td>
			<td><?php echo $email?></td>
		</tr>

		<tr>
			<td>Designee 2 Name</td>
			<td><?php echo $name2?></td>
		</tr>
				<tr>
			<td>Designee 2 Phone #</td>
			<td><?php echo $phone2?></td>
		</tr>
				<tr>
			<td>Designee 2 Email</td>
			<td><?php echo $email2?></td>
		</tr>
			<td >Chair / Director</td>
			<td><?php echo $chair?></td>
		</tr>
			<td >Dean / AVP</td>
			<td><?php echo $dean?></td>
		</tr>
			<td >VP / Provost</td>
			<td><?php echo $provost?></td>
		</tr>

	</table>
	<a  type = "button" href = "edit-department.php?<?php echo "c=".$costcenter."&d=".$dep."&b=".$empbld."&r=".$emprm."&n=".$name."&p=".$phone."&e=".$email."&n2=".$name2."&p2=".$phone2."&e2=".$email2."&ch=".$chair."&de=".$dean."&pr=".$provost;?>" class = "btn btn-info btn-lg">Edit</a>
	</div>

</body>
</html>
