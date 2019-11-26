<?php
	session_start(); // Start the session.
require ('includes/login_functions.inc.php');
	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	/*if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) )
	{

		redirect_user('index.php');
	}*/
	//This page will be used to edit exterior light records. If the user is of a sufficient admin level it makes the changes to the exterior_lights table.
	//If they are not it submits the edits to be made so that an admin can look at them and either accept or deny them.

	require ('includes/mysqli_connect.php');

	$id = $_GET['id'];
	$user_num = $_SESSION['user_number'];

	//Begin to process the changes after user submits the form
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$errors = [];
		//verify the input fields

		if(!empty($_POST['lastname']))
		{
			$lastname = $_POST['lastname'];
		}
		else
		{
			$lastname = NULL;
		}
		if(!empty($_POST['firstname']))
		{
			$firstname = $_POST['firstname'];
		}
		else
		{
			$firstname = NULL;
		}
		if(!empty($_POST['employeenum']))
		{
			$employeenum = $_POST['employeenum'];
		}
		else
		{
			$employeenum = NULL;
		}
		/*if(!empty($_POST['ssn']))
		{
			$ssn = $_POST['ssn'];
		}
		else
		{
			$ssn = NULL;
		}*/
		if(!empty($_POST['iso']))
		{
			$iso = $_POST['iso'];
		}
		else
		{
			$iso = NULL;
		}
		if(!empty($_POST['disposition']))
		{
			$disposition = $_POST['disposition'];
		}
		else
		{
			$disposition = NULL;
		}
		if(!empty($_POST['dispositiondate']))
		{
			$dispositiondate = $_POST['dispositiondate'];
		}
		else
		{
			$dispositiondate = NULL;
		}
		if(!empty($_POST['empbld']))
		{
			$empbld = $_POST['empbld'];
		}
		else
		{
			$empbld = NULL;
		}
		if(!empty($_POST['emprm']))
		{
			$emprm = $_POST['emprm'];
		}
		else
		{
			$emprm = NULL;
		}
		if(!empty($_POST['circuit_number']))
		{
			$circuit_number = $_POST['circuit_number'];
		}
		else
		{
			$tag = NULL;
		}
		if(!empty($_POST['tag']))
		{
			$tag = $_POST['tag'];
		}
		else
		{
			$tag = NULL;
		}
		if(!empty($_POST['keyname']))
		{
			$keyname = $_POST['keyname'];
		}
		else
		{
			$keyname = NULL;
		}
		if(!empty($_POST['series']))
		{
			$series = $_POST['series'];
		}
		else
		{
			$series = NULL;
		}
		if(!empty($_POST['keybld']))
		{
			$keybld = $_POST['keybld'];

		}
		else if(!empty($_POST['keybld-text']))
	    {
			$keybld = $_POST['keybld-text'];
		}
		else
		{
			$keybld = NULL;
		}
			if(!empty($_POST['keyrm']))
		{
			$keyrm= $_POST['keyrm'];
		}
		else
		{
			$keyrm = NULL;
		}
			if(!empty($_POST['issuedate']))
		{
			$issuedate = $_POST['issuedate'];
		}
		else
		{
			$issuedate = NULL;
		}
			if(!empty($_POST['department']))
		{
			$department = $_POST['department'];

		}
		else if(!empty($_POST['department-text']))
		{
			$department = $_POST['department-text'];
		}
		else
		{
			$department = NULL;
		}
			if(!empty($_POST['receiptdate']))
		{
			$receiptdate = $_POST['receiptdate'];
		}
		else
		{
			$receiptdate = NULL;
		}
			if(!empty($_POST['status']))
		{
			$status = $_POST['status'];
		}
		else
		{
			$status = NULL;
		}
        
        /*Get idlink for insertion*/
        $query = "SELECT * FROM key_database WHERE dep = '$department'";
        $query_result = mysqli_query($dbc, $query);
        if (!$query_result){
            die("GET idlink FAILED! " . mysqli_error($dbc));
        }
        $row = mysqli_fetch_assoc($query_result);
        $idlink = $row['idlink'];
            
		//If no errors were detected during validation
		if(empty($errors))
		{
			if($_SESSION['admin_level'] > 2)//These users have authority to directly make changes to records.
			{
				//Prepare a statement to send to the database with all new values.
				$stmt = mysqli_prepare($dbc, "UPDATE key_database SET idlink=?, lastname=?, firstname=?, employeenum=?, iso=?, disposition=?, dispositiondate=?, empbld=?, emprm=?, tag=?, keyname=?, series=?, keybld=?, keyrm=?, issuedate=?, department=?, receiptdate=?, status=? WHERE dataid = $id");
				mysqli_stmt_bind_param($stmt, "isssssssssssssssds", $idlink, $lastname, $firstname, $employeenum, $iso, $disposition, $dispositiondate, $empbld, $emprm, $tag, $keyname, $series, $keybld, $keyrm, $issuedate, $department, $receiptdate, $status);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_error($stmt) != '')
				{
					$errors[] = mysqli_stmt_error($stmt);
				}

				/*if(empty($errors))
				{
					require ('includes/login_functions.inc.php');
					redirect_user('keydatabase_details.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] .  '&functional=' . $_GET['functional']);
				}*/
				mysqli_stmt_close($stmt);
				$userfirstname = $_SESSION['first_name'];
				$userlastname = $_SESSION['last_name'];
				$action = 'Editied Key record at data id '.$id;
				recordTimestamp($userfirstname , $userlastname ,$action );
				
			}elseif(($_SESSION['admin_level'] < 3) && $disposition =='Processing')
			{
					$stmt = mysqli_prepare($dbc, "UPDATE key_database SET idlink=?, lastname=?, firstname=?, employeenum=?, iso=?, dispositiondate=?, empbld=?, emprm=?, tag=?, keyname=?, series=?, keybld=?, keyrm=?, issuedate=?, department=?, receiptdate=?, status=? WHERE dataid = $id");
				mysqli_stmt_bind_param($stmt, "issssssssssssssds", $idlink, $lastname, $firstname, $employeenum, $iso, $dispositiondate, $empbld, $emprm, $tag, $keyname, $series, $keybld, $keyrm, $issuedate, $department, $receiptdate, $status);
				mysqli_stmt_execute($stmt);
				if(mysqli_stmt_error($stmt) != '')
				{
					$errors[] = mysqli_stmt_error($stmt);
				}

				/*if(empty($errors))
				{
					require ('includes/login_functions.inc.php');
					redirect_user('keydatabase_details.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] .  '&functional=' . $_GET['functional']);
				}*/
				mysqli_stmt_close($stmt);
			}
			else//If user does not have appropriate admin level submit edits to an admin to approve/disapprove
			{
				//Prepare a statement to send to the database with all new suggested values.
				/*$stmt = mysqli_prepare($dbc, "INSERT INTO key_edit_requests (key_to_change, requesting_user, lastname, firstname, employeenum, iso, disposition, dispositiondate, costcenter, empbld, emprm, tag, keyname, series, keybld, keyrm, issuedate, department, receiptdate, status) VALUES ('$id','$user_num',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				mysqli_stmt_bind_param($stmt, "ssssssssssssssisdi", $lastname, $firstname, $employeenum, $iso, $disposition, $dispositiondate, $costcenter, $empbld, $emprm, $tag, $keyname, $series, $keybld, $keyrm, $issuedate, $department, $receiptdate, $status);
				mysqli_stmt_execute($stmt);*/
				$sql = "INSERT INTO key_edit_requests (key_to_change, requesting_user, lastname, firstname, employeenum, idlink, iso, disposition, dispositiondate, empbld, emprm, tag, keyname, series, keybld, keyrm, issuedate, department, receiptdate, status)";
				$sql.= " values ($id,'$user_num','$lastname', '$firstname', '$employeenum', $idlink, '$iso', '$disposition', '$dispositiondate', '$empbld', '$emprm', '$tag', '$keyname', '$series', '$keybld', '$keyrm', '$issuedate', '$department', '$receiptdate', '$status')";
				
				
				$rs = mysqli_query($dbc, $sql);
				if ($rs=='1'){
				echo 'Key edits have been entered, please see the administrators for approval! You will be redirected in 3 seconds';
				header('refresh:3;url=edit_keydatabase.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] .  '&functional=' . $_GET['functional']);
				
				}

				if(mysqli_stmt_error($stmt) != '')
				{
					$errors[] = mysqli_stmt_error($stmt);
				}
				if(empty($errors))
				{
					require ('includes/login_functions.inc.php');
					redirect_user('edit_keydatabase.php?id=' . $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] .  '&functional=' . $_GET['functional']);

				}

				
				
				$userfirstname = $_SESSION['first_name'];
				$userlastname = $_SESSION['last_name'];
				$action = 'Requested to edit Key record at data id '.$id;
				recordTimestamp($userfirstname , $userlastname ,$action );
				mysqli_stmt_close($stmt);

			}

		}
	}

	$query = "SELECT * FROM key_database WHERE dataid = $id LIMIT 1";
	$result = @mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);


	$page_title = 'Edit Keys';
	include ('includes/header.html');
?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body onload = "load()">
  <div class="container">

	<br />


	<div class="error">
	<?php
		if(!empty($errors))
		{
			echo 'Changes were not submitted because of the following errors:';
			echo '<br>';
			foreach($errors as $value)
			{
				echo $value . "<br>";
			}
		}
	?>
	</div>
	<?php
		echo '<a href="keydatabase_details.php?id=' . $row['dataid'] . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&functional=' . $_GET['functional'] . '&ts=' . $textSearch . '" target = "_self"><b>Back</b></a><br>';
		echo '<br />';
	?>
<form style = "width:100%" action = "edit_keydatabase.php?id=<?php echo $id . '&sort=' . $_GET['sort'] . '&s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&bld=' . $_GET['bld'] . '&ts=' . $_GET['ts'] . '&functional=' . $_GET['functional'].'&stat=' . $_GET['stat'];?>" method = "POST">
	<table class = "table table-striped table-bordered table-hover table-condensed">
		<tbody>
			<tr>
				<th>Key ID: </th>
				<td><?php echo $row['dataid']; ?></td>
			</tr>
			<tr>
			<th>Last Name</th>
			<td><input type = "text" id = "lastname" name = "lastname" value = "<?php echo (empty($lastname))? $row['lastname']:$lastname; ?>"></td>
			</tr>
			<tr>
				<th>First Name</th>
				<td><input type = "text" id = "firstname" name = "firstname" value = "<?php echo (empty($firstname))? $row['firstname']:$firstname; ?>"></td>
			</tr>
			<tr>
				<th>Employee Number</th>
				<td><input type = "text" id = "employeenum" name = "employeenum" value = "<?php echo (empty($employeenum))? $row['employeenum']:$employeenum; ?>"></td>
			</tr>

			<tr>
				<th>ISO</th>
				<td><input type = "text" id = "iso" name = "iso" value = "<?php echo (empty($iso))? $row['iso']:$iso; ?>"></td>
			</tr>
			<tr>
				<th>Key Disposition</th>
				<td><input type = "hidden" id = "disposition" name = "disposition" value = "<?php echo (empty($disposition))? $row['disposition']:$fixture_type;?>" >
				<select name = "disposition" id = "disposition" onChange = "resetDate()">
					<option id = "Processing"> Processing </option>
					<option id = "Assigned"> Assigned </option>
					<option id = "Returned"> Returned </option>
					<option id = "Lost-Not Paid"> Lost-Not Paid </option>
					<option id = "Lost-Paid"> Lost-Paid </option>
					<option id = "Lost-Stolen"> Lost-Stolen </option>
					<option id = "Left University"> Left University</option>
					<option id = "No Receipt"> No Receipt</option>
				</select>
				</td>
			</tr>
			<tr>
				<th>disposition Date</th>
				<td><input type = "date" id = "dispositiondate" name = "dispositiondate" value = "<?php echo (empty($dispositiondate))? $row['dispositiondate']:$dispositiondate; ?>"></td>
			</tr>
			<!-- <tr>
				<th>Employee Building</th>
				<td><input type = "text" id = "empbld" name = "empbld" value = "<?php echo (empty($empbld))? $row['empbld']:$empbld; ?>"></td>
			</tr>
			<tr>
				<th>Employee Room</th>
				<td><input type = "text" id = "emprm" name = "emprm" value = "<?php echo (empty($emprm))? $row['emprm']:$emprm; ?>"></td>
			</tr> -->
			<tr>
				<th>Tag Number</th>
				<td><input type = "text" id = "tag" name = "tag" value = "<?php echo (empty($tag))? $row['tag']:$tag; ?>"></td>
			</tr>
			<tr>
				<th>Key Name:</th>
				<td><input type = "text" id = "keyname" name = "keyname" value = "<?php echo (empty($keyname))? $row['keyname']:$keyname; ?>"></td>
			</tr>
			<tr>
				<th>Series</th>
				<td><input type = "text" id = "series" name = "series" value = "<?php echo (empty($series))? $row['series']:$series; ?>"></td>
			</tr>
			<tr>
				<th>Key Building</th>
				<td><select name = "keybld" id = "bld">
				<option value = ""><option>
				<?php
				$s = "SELECT DISTINCT bld_name FROM Buildings ORDER BY bld_name";
				$res = mysqli_query($dbc, $s);
				while ($rr = mysqli_fetch_assoc($res)){
					echo "<option value = '".$rr['bld_name']."' ";
						if($keybld == $rr['bld_name'] || $row['keybld']== $rr['bld_name']){
							echo 'selected';
						}
					echo ">".$rr['bld_name']."</option>";
				}
				?>
				</select>
				<input type = "text" id = "keybld" name = "keybld-text" value = "<?php echo (empty($keybld))? $row['keybld']:$keybld; ?>" style = "display: none">
				<a class = "btn btn-danger" id = "xbtn1" href ="#" onClick = "textToDrop('keybld','bld','xbtn1')" style = "display: none">X</a>
				</td>
			</tr>
			<tr>
				<th>Key Room</th>
				<td><input type = "text" id = "keyrm" name = "keyrm" value = "<?php echo (empty($keyrm))? $row['keyrm']:$keyrm; ?>"></td>
			</tr>
			<tr>
				<th>Issue Date</th>
				<!-- <td><input type = "text" id = "issuedate" name = "issuedate" value = "<?php echo (empty($issuedate))? $row['issuedate']:$issuedate; ?>"></td>
				--><td><input type = "date" id = "issuedate" name = "issuedate" value = "<?php echo (empty($issuedate))? $row['issuedate']:$issuedate; ?>"></td>
					<script>
						var value = <?php echo (empty($issuedate))? $row['issuedate']:$issuedate; ?>;
						console.log(value);
						var dis = <?php echo (empty($dispositiondate))? $row['dispositiondate']:$dispositiondate; ?>;
						console.log(dis);
					</script>
			</tr>
			<tr>
				<th>Department</th>
				<td>
					<select name = "department" id = "department" onchange = "autoFill(this[selectedIndex].text)">
					<option value = ""><option>
					<?php
					$q = "SELECT dep FROM department";
					$rs = @mysqli_query($dbc, $q);
					while($ro = mysqli_fetch_array($rs))
					{

						echo '<option value = "' . $ro['dep'] . '" ';
							if($department == $ro['dep'] || $row['department'] == $ro['dep'] ){
								echo 'selected';
							}
						echo '>' . $ro['dep'] . '</option>';
				}
				//mysqli_free_result($rs);
			?>
				</select>
				<input type = "text" id = "department-text" name = "department-text" value = "<?php echo (empty($department))? $row['department']:$department; ?>" onChange="textToDrop(this)" style = "display: none">
				<a class = "btn btn-danger" id = "xbtn" href ="#" onClick = "textToDrop('department-text','department','xbtn')" style = "display: none">X</a>
				</td>
			</tr>
			<!-- <tr>
				<th>Reciept Date</th>
				<td><input type = "text" id = "receiptdate" name = "receiptdate" value = "<?php echo (empty($receiptdate))? $row['receiptdate']:$receiptdate; ?>"></td>
			</tr> -->
			<!--<tr>
				<th>Status</th>
				<td><input type = "text" id = "status" name = "status" value = "<?php echo (empty($status))? $row['status']:$status; ?>"></td>
			</tr>	-->
			<tr>
				<th>Campus Group</th>
				<td><select name = "status" id = "status">


						<?php
							$options = array(' ','Faculty','Student','Staff','Master Ring', 'Contractor');
							foreach ($options as $id => $option ){
								echo '<option value = "'.$option.'"';
									if($option == $status || $row['status']== $option){
										echo  ' selected';
									}
								echo '>'.$option.'</option>';

							}

						?>
					</select>
				</td>
			</tr>
			<tr>

			</tr>
		</tbody>
	</table>

<input style = "margin-top:5px;margin-left:0px;border:thin solid black;" type = "submit" class="btn btn-default" value = "Submit Changes" onClick = "return confirmAction();">
</form>
</div>
</body>
<script>
function load(){
	var disp = document.getElementById("disposition").value;
	console.log(disp);
	document.getElementById(disp).selected=true;

	dep = document.getElementById("department").options[document.getElementById("department").selectedIndex].value;
	bld = document.getElementById("bld").options[document.getElementById("bld").selectedIndex].value;
	if(dep == ""){
		document.getElementById("xbtn").style.display = "inline";
		document.getElementById("department-text").style.display = "inline";
	}
	if(bld == ""){
		document.getElementById("xbtn1").style.display = "inline";
		document.getElementById("keybld").style.display = "inline";
	}
	//document.getElementById("<?php echo $type1;?>").selected=true;
	//needs some more work on department dropdown
	//document.getElementById("<?php echo $departmanet1;?>");//.selected=true;
}
function resetDate(){
	document.getElementById("dispositiondate"). value ="<?php echo date('Y-m-d');?>";
}
function textToDrop(tb, dd, xbtn){
	dt = document.getElementById(tb);
	op = document.getElementById(dd);
	dep = op.options[op.selectedIndex].text;
	if(dep != ""){
		dt.style.display = "none";
		document.getElementById(xbtn).style.display = "none";
		console.log("done");
	}

}
function autoFill(empbld){
	var xmlhttp;
	xmlhttp = new XMLHttpRequest()

	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			var returnval = JSON.parse(this.responseText);
			document.getElementById("empbld").value = returnval[1];
			document.getElementById("emprm").value = returnval[2];

		}
	}
	xmlhttp.open("GET","http://norsegis.nku.edu/addkeyphp.php?w="+empbld,true);
	xmlhttp.send();

}

</script>
<?php
	mysqli_free_result ($result);
	mysqli_close($dbc);
	include ('includes/footer.html');
?>
