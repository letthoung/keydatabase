<?php
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if ( !isset($_SESSION['agent']) OR $_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) OR $_SESSION['admin_level'] < 2 ) 
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	
	require ('includes/mysqli_connect.php');
	$page_title = 'Key database Edit Requests Approval';
	include ('includes/header.html');
	
	$query = "SELECT * FROM key_edit_requests";
							
	$result = @mysqli_query($dbc, $query);	

?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
	table
	{
		width:751px;
		margin:auto;
	}
	table tr:nth-child(even) 
	{
		background-color: #CEE4F5;
	}
	table tr:nth-child(odd) 
	{
		background-color: #eeeeee;
	}
	body{
		background-color: #ECEBE4;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
	<!--
	function acceptRequest(request)
	{
		var xmlhttp;
		if (confirmAction()) {
			xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
			xmlhttp.onreadystatechange = function ()//Function called when there is a change of state for the server
			{                                      //request
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//when request is complete and no issues
				{
					location.reload();
				}
			};
			xmlhttp.open("GET", "get_keys.php?p=accept&id=" + request, true);//accept changes proposed by request
			xmlhttp.send();
		}
	}
	function deny(request)
	{
		var xmlhttp;
		if (confirmAction()) {
			xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
			xmlhttp.onreadystatechange = function ()//Function called when there is a change of state for the server
			{                                      //request
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//when request is complete and no issues
				{
					location.reload();
				}
			};
			xmlhttp.open("GET", "get_keys.php?p=deny&id=" + request, true);//deny changes proposed by request
			xmlhttp.send();
		}
	}
	function hide_table(nm)
	{
		var table_selector = "#table_" + nm;
		$(table_selector).toggle();
	}
	//-->
</script>
<body>
   	<div>
	<img src="norse.jpeg" style="width:150px; position: absolute; right: 3.5%; top: 3.5%;"> 
	</div>
    <div class="container"> 
	<p><a href = "tools.php" target = "_self"><b>Back</b></a></p>
	<p>Changed values are <mark>highlighted</mark>.<br>No highlighted value indicates that the field was not changed.<br><br> Oldest requests at the top, newest requests at the bottom.</p><br>
<?php
	while($row = mysqli_fetch_array($result))
	{
		$key_number = $row['key_to_change'];		
		$query = "SELECT * FROM key_database WHERE dataid = $key_number LIMIT 1";
		$rs = @mysqli_query($dbc, $query);
		$row1 = mysqli_fetch_array($rs);
		//gets name of who requested
		$sql1 = "SELECT * FROM users WHERE user_id = '".$row['requesting_user']."' LIMIT 1";
		$rs1 = mysqli_query($dbc, $sql1);
		$rr = mysqli_fetch_array($rs1);
		//
		echo '<p style = "border:thin solid black;padding:2px;" onclick = "hide_table(' . $row['key_edit_id'] . ');">' . $rr['first_name'] . ' ' . $rr['last_name'] . ' requested an edit for key number ' . $key_number . ' (Show/Hide)</p>';
		echo '<table id = "table_' . $row['key_edit_id'] . '" name = "table_' . $row['key_edit_id'] . '" style = "display:none;">';
		echo '<tr><th>Field</th><th>Old Value</th><th>New Value</th></tr>';
		echo '<tr><th>Id</th><td colspan = "0">' . $key_number . '</td></tr>';
		echo '<tr><th>Last Name</th><td>' . $row1['lastname'] . '</td><td>';
		echo ($row1['lastname'] == $row['lastname'])? '':'<mark>';
		echo $row['lastname'];
		echo ($row1['lastname'] == $row['lastname'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>First Name</th><td>' . $row1['firstname'] . '</td><td>';
		echo ($row1['firstname'] == $row['firstname'])? '':'<mark>';
		echo $row['firstname'];
		echo ($row1['firstname'] == $row['firstname'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Employee Number</th><td>' . $row1['employeenum'] . '</td><td>';
		echo ($row1['employeenum'] == $row['employeenum'])? '':'<mark>';
		echo $row['employeenum'];
		echo ($row1['employeenum'] == $row['employeenum'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Social Secuirty Number</th><td>' . $row1['ssn'] . '</td><td>';
		echo ($row1['ssn'] == $row['ssn'])? '':'<mark>';
		echo $row['ssn'];
		echo ($row1['ssn'] == $row['ssn'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>ISO</th><td>' . $row1['iso'] . '</td><td>';
		echo ($row1['iso'] == $row['iso'])? '':'<mark>';
		echo $row['iso'];
		echo ($row1['iso'] == $row['iso'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Disposition</th><td>' . $row1['disposition'] . '</td><td>';
		echo ($row1['disposition'] == $row['disposition'])? '':'<mark>';
		echo $row['disposition'];
		echo ($row1['disposition'] == $row['disposition'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Disposition Date</th><td>' . $row1['dispositiondate'] . '</td><td>';
		echo ($row1['dispositiondate'] == $row['dispositiondate'])? '':'<mark>';
		echo $row['dispositiondate'];
		echo ($row1['dispositiondate'] == $row['dispositiondate'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Cost Center</th><td>' . $row1['costcenter'] . '</td><td>';
		echo ($row1['costcenter'] == $row['costcenter'])? '':'<mark>';
		echo $row['costcenter'];
		echo ($row1['costcenter'] == $row['costcenter'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Employee Building</th><td>' . $row1['empbld'] . '</td><td>';
		echo ($row1['empbld'] == $row['empbld'])? '':'<mark>';
		echo $row['empbld'];
		echo ($row1['empbld'] == $row['empbld'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Employee Room</th><td>' . $row1['emprm'] . '</td><td>';
		echo ($row1['emprm'] == $row['emprm'])? '':'<mark>';
		echo $row['emprm'];
		echo ($row1['emprm'] == $row['emprm'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Tag</th><td>' . $row1['tag'] . '</td><td>';
		echo ($row1['tag'] == $row['tag'])? '':'<mark>';
		echo $row['tag'];
		echo ($row1['tag'] == $row['tag'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Key Name</th><td>' . $row1['keyname'] . '</td><td>';
		echo ($row1['keyname'] == $row['keyname'])? '':'<mark>';
		echo $row['keyname'];
		echo ($row1['keyname'] == $row['keyname'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Series</th><td>' . $row1['series'] . '</td><td>';
		echo ($row1['series'] == $row['series'])? '':'<mark>';
		echo $row['series'];
		echo ($row1['series'] == $row['series'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Key Building</th><td>' . $row1['keybld'] . '</td><td>';
		echo ($row1['keybld'] == $row['keybld'])? '':'<mark>';
		echo $row['keybld'];
		echo ($row1['keybld'] == $row['keybld'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Key Room</th><td>' . $row1['keyrm'] . '</td><td>';
		echo ($row1['keyrm'] == $row['keyrm'])? '':'<mark>';
		echo $row['keyrm'];
		echo ($row1['keyrm'] == $row['keyrm'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Issue Date</th><td>' . $row1['issuedate'] . '</td><td>';
		echo ($row1['issuedate'] == $row['issuedate'])? '':'<mark>';
		echo $row['issuedate'];
		echo ($row1['issuedate'] == $row['issuedate'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Department</th><td>' . $row1['department'] . '</td><td>';
		echo ($row1['department'] == $row['department'])? '':'<mark>';
		echo $row['department'];
		echo ($row1['department'] == $row['department'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Receipt Date</th><td>' . $row1['receiptdate'] . '</td><td>';
		echo ($row1['receiptdate'] == $row['receiptdate'])? '':'<mark>';
		echo $row['receiptdate'];
		echo ($row1['receiptdate'] == $row['receiptdate'])? '':'</mark>';
		echo '</td></tr>';
		echo '<tr><th>Status</th><td>' . $row1['status'] . '</td><td>';
		echo ($row1['status'] == $row['status'])? '':'<mark>';
		echo $row['status'];
		echo ($row1['status'] == $row['status'])? '':'</mark>';
		echo '</td></tr>';
		//$row['light_edit_id']
		echo '<tr><td colspan = "0"><input type = "button" value = "Approve Changes" align = "left" onclick = "acceptRequest(' . $row['key_edit_id'] . ');">
		                            <input type = "button" value = "Deny Changes" align = "left" onclick = "deny(' . $row['key_edit_id'] . ');"></td></tr>';
		echo '</table>';
		echo '<br>';
		mysqli_free_result($rs);
	}
	
	mysqli_free_result($result);
	mysqli_close($dbc);
	include ('includes/footer.html');
?>
</div>
</body>