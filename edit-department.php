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
	/*require ('includes/login_functions.inc.php');*/
	$page_title = 'Edit Department Profile';
	include ('includes/header.html');

    $name = $_GET['n'];
    $dep = $_GET['d'];
    $idlink = $_GET['c'];
    $bld = $_GET['b'];
    $room = $_GET['r'];
    $phone = $_GET['p'];
    $email = $_GET['e'];

    $name2 = $_GET['n2'];
    $phone2 = $_GET['p2'];
    $email2 = $_GET['e2'];

    $chair = $_GET['ch'];
    $dean = $_GET['de'];
    $provost = $_GET['pr'];


	if (isset($_POST['submit'])){
			$dep = $_POST['dep'];
			$bld = $_POST['empbld'];
			$room = $_POST['emprm'];
            $name = $_POST['name'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];

			$name2 = $_POST['name2'];
			$phone2 = $_POST['phone2'];
			$email2 = $_POST['email2'];

			$chair = $_POST['chair'];
			$dean = $_POST['dean'];
			$provost = $_POST['provost'];

			$sql = "UPDATE department SET name = '$name', dep = '$dep', empbld = '$bld', phone = '$phone', emprm = '$room', email = '$email', name2 = '$name2', phone2 = '$phone2', email2 = '$email2', chair = '$chair', dean = '$dean', provost = '$provost' WHERE idlink = ".$idlink;
			$res = mysqli_query($dbc, $sql);
        
            if (!res){
                die("QUERY FAIL!!" . mysqli_error($dbc));
            } else{
			     echo '<h1 style = "color:green">RECORD UPDATED!!!</h1>';
            } 
			//echo $sql;
	}
			echo "<a href = 'department.php?c=".$dep."' type = 'button' class = 'btn btn-secondary btn-lg' style = 'margin-left:25%'>Back</a>";

	?>
<!DOCTYPE html>
<html>
<head>
	<title>Department profile</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
	td{
		font-size: 14px;
	}
	</style>
	</head>
<body>

	<h1>Department Profile</h1>
    <br>
	<div class = "container">
	<form action="" id = "form" method = "post" onclick="setLink()">
	<table class="table table-hover">
		<tr>
			<td class="col-xs-4">Dept. Name</td>
			<td> <input type = "text" name = "dep" value = "<?php echo $dep;?>"> </td>
		</tr>
		<tr>
			<td >Building</td>
			<td> <input type = "text" name = "empbld" value = "<?php echo $bld;?>"></td>
		</tr>
		<tr>
			<td >Room #</td>
			<td><input type = "text" name = "emprm" value = "<?php echo $room;?>"></td>
		</tr>
		<tr>
			<td >Designee Name</td>
			<td > <input type = "text" name = "name" value = "<?php echo $name;?>" ></td>
		</tr>
		<tr>
			<td >Designee Phone #</td>
			<td ><input type = "text" name = "phone" value = "<?php echo $phone;?>"</td>
		</tr>
		<tr>
			<td>Designee Email</td>
			<td><input type = "text" name = "email" value = "<?php echo $email;?>"></td>
		</tr>

		<tr>
			<td>Designee 2 Name</td>
			<td > <input type = "text" name = "name2" value = "<?php echo $name2;?>" ></td>
		</tr>
		<tr>
			<td>Designee 2 Phone #</td><td >
			<input type = "text" name = "phone2" value = "<?php echo $phone2;?>"</td>
		</tr>
		<tr>
			<td>Designee 2 Email</td>
			<td><input type = "text" name = "email2" value = "<?php echo $email2;?>"></td>
		</tr>
			<td >Chair / Director</td>
			<td > <input type = "text" name = "chair" value = "<?php echo $chair;?>" ></td>
		</tr>
			<td >Dean / AVP</td>
			<td > <input type = "text" name = "dean" value = "<?php echo $dean;?>" ></td>
		</tr>
			<td >VP / Provost</td>
			<td > <input type = "text" name = "provost" value = "<?php echo $provost;?>" ></td>
		</tr>
	</table>
	<input type = "submit"  name ="submit" class = "btn btn-info btn-lg" value = "Submit Changes"></input>
	</form>
	</div>

</body>
<script type="text/javascript">
	function setLink(){
		link = '<?php echo "edit-department.php?c=".$_GET['c'];?>';
		document.getElementById("form").action = link;
	}
</script>
</html>
<?php


?>
