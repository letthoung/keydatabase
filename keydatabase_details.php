<?php
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	/*if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])))
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	if(!isset($_GET['id']))
	{
		require ('includes/login_functions.inc.php');
		redirect_user('light_assets.php');
	}*/
	require ('includes/mysqli_connect.php');

	$id = $_GET['id'];



	//First get all the record and its associated building name from the database.
	$query = "SELECT * FROM key_database WHERE dataid = $id";
	$result = @mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);

	$page_title = 'Key Record';
	include ('includes/header.html');
?>
	<br />
	<?php
		//Display a 'back' link
		echo '<p><a href = "keydatabase.php?sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] . '&functional=' . $_GET['functional'] . '" target = "_self">Back</a></p>';
		echo '<br>';
		//Display Delete Light if user has appropriate permissions, and Edit Record for everyone
		echo '<table class = "t01"><tr>';
		if($_SESSION['admin_level'] > 1)
		{
			echo '<td style = "width:20%;text-align:center;"><a href = "delete_key.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] . '&functional=' . $_GET['functional'] . '" onClick = "return confirmAction();" target = "_self"><b>Delete Key</b></a></td>';
		}
		//echo '<td style = "width:15%;text-align:center;"><a href = "keyholder.php?lname='.$row['lastname'].'&fname='.$row['firstname'].'&empnum='.$row['employeenum'].'" target = "_self"><b>Key Holder Profile</b></a></td>';
		echo '<td style = "width:15%;text-align:center;"><a href = "keyholder.php?lname='.$row['lastname']."".'&fname='.$row['firstname'].'&empnum='.$row['employeenum'].'&id='.$id.'" target = "_self"><b>Key Holder Profile</b></a></td>';


		echo '<td style = "width:15%;text-align:center;"><a href = "edit_keydatabase.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] . '&functional=' . $_GET['functional'] . '" target = "_self"><b>Edit Key</b></a></td>';
		echo '<td style = "width:15%;text-align:center;"><a href = "keyreciept.php?id=' . $id . '" target = "_self"><b>Key Agreement</b></a></td>';
		echo '<td style = "width:15%;text-align:center;"><a href = "key_transfer_process.php?id=' . $id  . '" target = "_self"><b>Transfer Process</b></a></td>';
		echo '<td style = "width:15%;text-align:center;"><a href = "key_return_report.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] . '&functional=' . $_GET['functional'] . '" target = "_self"><b>Key Return Report</b></a></td>';
		echo '</tr></table>';
		echo '<br />';
	?>

	<!-- Create tables to display the record. -->

	<table class = "t01">
		<tr>
			<th>Id</th>
			<td><?php echo $row['dataid']; ?></td>
		</tr>
		<tr>
			<th>Last Name</th>
			<td><?php echo $row['lastname']; ?></td>
		</tr>
		<tr>
			<th>First Name</th>
			<td><?php echo $row['firstname']; ?></td>
		</tr>
        <tr>
			<th>Employee Number</th>
			<td><?php echo $row['employeenum']; ?></td>
		</tr>
		<tr>
			<th>ISO</th>
			<td><?php echo $row['iso']; ?></td>
		</tr>
		<tr>
			<th>Disposition</th>
			<td><?php echo $row['disposition']; ?></td>
		</tr>
		<tr>
			<th>Disposition Date</th>
			<td><?php echo $row['dispositiondate']; ?></td>
		</tr>
		<!--<tr>
			<th>Employee Building</th>
			<td><?php //echo $row['empbld']; ?></td>
		</tr>
		<tr>
			<th>Employee Room Number</th>
			<td><?php //echo $row['emprm']; ?></td>
		</tr>-->
		<tr>
			<th>Tag</th>
			<td><?php echo $row['tag']; ?></td>
		</tr>
		<tr>
			<th>Tag 2</th>
			<td><?php echo $row['tag2']; ?></td>
		</tr>
		<tr>
			<th>Key Name</th>
			<td><?php echo $row['keyname']; ?></td>
		</tr>
		<tr>
			<th>All Assigned Keys</th>
			<td>
			<?php
			//echo $row['keyname'];
			$sql1= "SELECT keyname FROM key_database WHERE firstname = '".$row['firstname']."' AND lastname = '".$row['lastname']."' AND (disposition = 'Assigned' OR disposition = 'No Receipt')";
			$r1 = mysqli_query($dbc, $sql1);

			while($row1 = mysqli_fetch_array($r1)){

				echo '<a style = "color:blue; text-decoration: underline"href ="search_by_key.php?keyNum='.$row1['keyname'].'" target = "_blank">'.$row1['keyname'].', ';
			}

			?>
			</td>
		</tr>
		<tr>
			<th>Series Number</th>
			<td><?php echo $row['series']; ?></td>
		</tr>
		<tr>
			<th>Key Building</th>
			<td><?php echo $row['keybld']; ?></td>
		</tr>
		<tr>
			<th>Key Room</th>
			<td><?php echo $row['keyrm']; ?></td>
		</tr>
		<tr>
			<th>Issue Date</th>
			<td><?php echo $row['issuedate']; ?></td>
		</tr>
		<tr>
			<th>Department</th>
			<td><?php echo $row['department']; ?></td>
		</tr>
		<tr>
			<th>Reciept Date</th>
			<td><?php echo $row['receiptdate']; ?></td>
		</tr>
		<tr>
			<th>Campus Group</th>
			<td><?php echo $row['status']; ?></td>
		</tr>
	</table>
<?php
	mysqli_free_result ($result);
	mysqli_close($dbc);

	include ('includes/footer.html');
?>
