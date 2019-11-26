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
	$page_title = 'Key Holder Profile';
	include ('includes/header.html');

	$empnum = $_GET['empnum'];
	$fname = $_GET['fname'];
	$lname = $_GET['lname'];
	$id = $_GET['id'];

	if ($empnum !== ""){
	$sql = "SELECT DISTINCT iso,tag,tag2, email FROM key_database WHERE employeenum = '$empnum'";

	}
	else{

	$sql = "SELECT DISTINCT iso,tag,tag2, email FROM key_database WHERE firstname = '$fname' AND lastname = '$lname'";

	}
	$result = mysqli_query($dbc, $sql);
	$row = mysqli_fetch_assoc($result);
		$iso = $row['iso'];
		$tag1 = $row['tag'];
		$tag2 = $row['tag2'];
		$employeenum = $_GET['empnum'];
		$email = $row['email'];

	if (isset($_POST['submit'])){
		$status = $_POST['status'];
		$fname = $_GET['fn'];
		$lname = $_GET['ln'];
		$employeenum = $_POST['empnum'];
		$iso = $_POST['iso'];
		$tag1 = $_POST['tag1'];
		$tag2 = $_POST['tag2'];
		$email = $_POST['email'];

		$department = $_POST['department'];

		if ($empnum =="" || ($empnum !== $employeenum)){// empnum is empty need to fix this prblm

			$sql1 = "UPDATE key_database SET employeenum = '$employeenum', iso = '$iso', tag = '$tag1', tag2='$tag2', email = '$email', status = '$status' WHERE firstname = '$fname' AND lastname = '$lname'" ;

		}
		else{
			$sql1 = "UPDATE key_database SET iso = '$iso', tag = '$tag1', tag2='$tag2',email = '$email', status ='$status' WHERE employeenum = $empnum" ;

		}

		$sql0 = "UPDATE key_database SET department = '$department' WHERE dataid = '$id' ";
		//echo $sql1;
		//echo $sql0;
		mysqli_query($dbc, $sql0);
		mysqli_query($dbc, $sql1);
		echo '<h1 style = "color:green">RECORD UPDATED</h1>';
	}
	echo '<a href = "keydatabase.php" type = "button" class = "btn btn-primary " style = "margin-left:25%">Back</a>';
?>
<html>

<head>

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">

</head>

<body>
<h1>Key Holder Profile</h1>
    <br>
	<div class = "container">
	<?php
	echo '<form action="keyholder.php?id='.$id.'&fn='.$fname.'&ln='.$lname.'" method = "post">';

	?>
	<table class="table table-hover">
		<tr>
			<td class="col-xs-4">Campus Group</td>
			<td> <?php

					$que = "SELECT status FROM key_database WHERE dataid = '$id'";

					$res = mysqli_query($dbc, $que);
					$r1 = mysqli_fetch_array($res);
					//echo $r1[0];
					echo '<select name = "status">';
					$options = array('Faculty','Student','Staff','Master Ring', 'Contractor');
					foreach ($options as $val => $option ){
						echo '<option value = "'.$option.'"';
							if($option == $r1[0] ){
								echo  ' selected';
							}
						echo '>'.$option.'</option>';

					}
					echo '</select>';
					?>
			</td>
		</tr>
		<tr>
			<td class="col-xs-4">Employee Name</td>
			<td><?php echo $fname." ".$lname; ?></td>
		</tr>
		<tr>
			<td class="col-xs-4">Employee Email</td>
			<td><input type = "text" name = "email" value = "<?php echo $email;?>"> </td>
		</tr>
		<tr>
			<td >Employee number</td>
			<td> <input type = "text" name = "empnum" value = "<?php echo $employeenum;?>"> </td>
		</tr>
		<tr>
			<td >ISO</td>
			<td> <input type = "text" name = "iso" value = "<?php echo $iso; ?>"> </td>
		</tr>
		<tr>
			<td >Department</td>
			<?php
			// select statement for getting the departments and setting it using the dropdown
				$q0 = "SELECT department FROM key_database WHERE dataid = '$id'";
				$r0 = mysqli_query($dbc, $q0);
				$row0 = mysqli_fetch_array($r0);
				echo $q0;
				echo $department;
				
				echo "dep ".$row0['department'];
			?>
			<td>
				<select name = "department" id = "department" >
					<option value = ""><option>
					<?php
					$q = "SELECT dep FROM department";
					$rs = @mysqli_query($dbc, $q);
					while($ro = mysqli_fetch_array($rs))
					{

						echo '<option value = "' . $ro['dep'] . '" ';
							if($department == $ro['dep'] || $row0['department'] == $ro['dep'] ){
								echo 'selected';
							}
						echo '>' . $ro['dep'] . '</option>';
					}
				//mysqli_free_result($rs);
			?>
				</select>
			</td>
		</tr>

		<tr>
			<td >Tag 1</td>
			<td> <input type = "text" name = "tag1" value = "<?php echo $tag1;?>"></td>
		</tr>
		<tr>
			<td >Tag 2</td>
			<td><input type = "text" name = "tag2" value = "<?php echo $tag2;?>"></td>
		</tr>
		<tr>
			<td>All Assigned Keys</td>
			<td>
			<?php

			$sql1= "SELECT keyname FROM key_database WHERE firstname = '".$fname."' AND lastname = '".$lname."' AND disposition = 'Assigned'";
			$r1 = mysqli_query($dbc, $sql1);

			while($row1 = mysqli_fetch_array($r1)){

				echo '<a style = "color:blue; text-decoration: underline"href ="search_by_key.php?keyNum='.$row1['keyname'].'" target = "_blank">'.$row1['keyname'].', ';
			}

			?>
			</td>
		</tr>
	</table>
	<input type = "submit"  name ="submit" class = "btn btn-info" value = "Submit Changes"></input>
	</form>
	</div>

</body>

<script>

</script>

</html>
