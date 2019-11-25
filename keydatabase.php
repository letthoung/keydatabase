<!DOCTYPE html>
<html>
<head>
<?php
	require('includes/fpdf181/fpdf.php');
	session_start(); // Start the session.

	//If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!

    /*if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) OR ($_SESSION['admin_level'] < 1) )
	{
		// Need the functions:
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}*/
	require("includes/mysqli_connect.php");
	/*require ('includes/login_functions.inc.php');*/
	$page_title = 'Key Database';
	include ('includes/header.html');

    //Get information from the form if user submitted a search
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$dataid = $_POST['dataid'];
		$lastname = $_POST['lastname'];
		$firstname = $_POST['firstname'];
		$employeenum = $_POST['employeenum'];
		$ssn = $_POST['ssn'];
		$iso = $_POST['iso'];
		$disposition = $_POST['disposition'];
		$dispositiondate = $_POST['dispositiondate'];
		$costcenter = $_POST['costcenter'];
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
        
	} else {
        $dataid = (isset($_GET['dataid']))? $_GET['dataid']:'';
		$lastname = (isset($_GET['lastname']))? $_GET['lastname']:'';
		$firstname = (isset($_GET['firstname']))? $_GET['firstname']:'';
		$employeenum = (isset($_GET['employeenum']))? $_GET['employeenum']:'';
		$ssn = (isset($_GET['ssn']))? $_GET['ssn']:'';
		$iso = (isset($_GET['iso']))? $_GET['iso']:'';
		$disposition = (isset($_GET['disposition']))? $_GET['disposition']:'';
		$dispositiondate = (isset($_GET['dispositiondate']))? $_GET['dispositiondate']:'';
		$costcenter = (isset($_GET['costcenter']))? $_GET['costcenter']:'';
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

	if($lastname != '' || $firstname != '' || $employeenum != '' || $ssn != '' || $iso != '' || $disposition != '' || $dispositiondate != '' || $costcenter != '' || $empbld != '' || $emprm != '' || $tag != '' || $keyname != '' || $series != '' || $keybld != '' || $keyrm != '' || $issuedate != '' || $department != '' || $receiptdate != '' || $status != '') {
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
		if($costcenter != '')
		{
		$query = "SELECT * FROM key_database WHERE costcenter = '$costcenter' ORDER BY costcenter LIMIT $start,$display";
		$query2 = "SELECT * FROM key_database WHERE costcenter = '$costcenter'";
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


	$result = @mysqli_query($dbc, $query);
	$rscount = @mysqli_query($dbc, $query2);
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


?>

<?php
	if(!empty($errors))
	{
		echo '<p class = "error">Errors:</p>';
		foreach($errors as $value)
		{
			echo '<p class = "error">' . $value . '</p>';
		}
	}


?>

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

			<?php
				/*$q = "SELECT DISTINCT lastname FROM key_database WHERE lastname != '' ORDER BY dataid";
				$rs = @mysqli_query($dbc, $q);

				mysqli_free_result($rs);*/
			?>
		</input>
			<select name = "keybld" class = "search-select" id = "keybld" style = "width:150px">
			<option value = 'all' <?php if($keybld ==''){echo 'selected';}?>>All Buildings</option>
			<?php
			//#E0EFFF
				$q = "SELECT DISTINCT keybld FROM key_database WHERE keybld != '' ORDER BY keybld";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['keybld'] . '" ';
					if($miscbrand != '' && $miscbrand == $row['keybld'])
					{
						echo ' selected ';
					}
					echo '>' . $row['keybld'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
			</select>
			<select name = "department" class = "search-select" id = "department" style = "width:200px">
					<option value = "all">Department<option>
					<?php
					$q = "SELECT dep, costcenter FROM department ORDER BY dep";
					$rs = @mysqli_query($dbc, $q);
					while($ro = mysqli_fetch_array($rs))
					{
						echo '<option value = "' . $ro['costcenter'] . '" ';
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
			<input type = "checkbox" id = "check-tag" value = "tag">Tag</input>
			<input type = "checkbox" id = "check-key" style = "margin-left: 10px" value = "keyname">Key</input>
			<!--<input type = "checkbox" id = "check-dep" style = "margin-left: 10px" value = "department">Department/Costcenter</input>-->

			<hr>
			<input type = "submit" class = "btn btn-default" name = "search-box" onClick = "filter()" >
			<a href = "keydatabase.php" class="btn btn-default">Clear Search</a>
			<br>
		</form>

		<form action="pdf_key_reciept_transfer_returnreport.php" method="post" >

	</div>
	<script>
	function filter(){
		console.log("filter");
		var tag = document.getElementById("check-tag");
		var key = document.getElementById("check-key");
		var dep = document.getElementById("check-dep");
		var name = document.getElementById("name").text;
		var count = 0;
		if (tag.checked){
			tag = tag.value;
			count++;
		}else{
			tag = "";
		}
		if (key.checked){
			key = key.value;
			count++;
		}else{
			key = "";
		}

		var keySearch = document.getElementById("key-search");
		keySearch.action = "search_by_lastname.php?tag="+tag+"&key="+key+"&count="+count;
	}


	</script>

	<?php
		echo'<div style="margin-left: 100px;">';
		echo '<b style="margin-top: 10px;">Number of records: ' . $records . '</b><br>';
		echo '<br>';
		echo '<table class = "table table-striped table-bordered table-hover table-condensed" id ="full-table" style="width: 90%; margin-left: auto; margin-right: 130px;">'; //Display table, allowing sort to be done based on user selection		echo '<table class = "  " id ="full-table">'; //Display table, allowing sort to be done based on user selection
		echo '<label style ="margin-left:20px;"for= "submit-checked" id="key" class="btn btn-primary" tabindex="0">Print Key Agreement</label>';
		if($_SESSION['admin_level'] >= 3)//These users have authority to directly make changes to records.
		{
		echo '<a href = "key_transfer_process.php"style ="margin-left:20px;" class = "btn btn-primary">Process Transfer</a>';

	//	echo '<label style ="margin-left:20px;"for= "submit-checked-transfer" id ="key-transfer" class="btn btn-primary" tabindex="0">Key Transfer Receipt</label>';
		echo '<label style ="margin-left:20px;"for= "submit-checked-report" id ="key-return-report" class="btn btn-primary" tabindex="0">Key Return Report</label>';

	//	echo '<label style ="margin-left:20px;"for= "submit-checked-report" id ="key-return-report" class="btn btn-primary" tabindex="0" onclick = "triggerReturn()">Return Report & Change Disposition</label>';
		echo '<a href = ""style ="margin-left:20px;" class = "btn btn-primary" id = "assignKey" onClick = "assignKey()">Assign Key</a>';
		echo '<a href = "" class = "btn btn-primary" style ="margin-left:20px;"id = "trigger" onClick="triggerReturn()">Process Return</a>';
		}
		echo '<a style ="margin-left:20px;" href= "add_key.php" class="btn btn-primary" tabindex="0">Add Key</a>';
		echo '<a style ="margin-left:20px;" href= "add_department.php" class="btn btn-primary" tabindex="0">Add Department</a>';
		echo '<label style ="margin-left:20px;"for= "submit-checked-excel" id ="excel-export" class="btn btn-success" tabindex="0">Export Excel</label>';
		if($_SESSION['admin_level'] >= 3)//These users have authority to directly make changes to records.
		{
			echo '<a href = ""style ="margin-left:20px;" class = "btn btn-primary" id = "assignKey" onClick = "assignKey()">Assign Key</a>';
			echo '<a style ="margin-left:20px;" href= "" class="btn btn-danger" tabindex="0" id = "delete" onClick="deleteConfirm()">Delete Key</a>';
		}
		echo '</div>';
		echo "<br><br>";
		echo '<thead>';
		$order = 'issuedate';
		/*if (isset ($_GET['order'])){
			$order = $_GET['order'];
		}
		else{
			$order = 'dataid';
		}*/
		if (isset ($_GET['sort'])){
			$sort = $_GET['sort'];
		}
		else{
		$sort = 'DESC';
		}
		echo '
			<th><input type = "checkbox" id = "checkall" name="checkall" value =""/></th>
			<th><b>Campus Group</b></th>
			<th><b>Last Name </b></th>
			<th><b>First Name</b></th>
			<th><b>Employee Number</b></th>
			<th><b>ISO</b></th>
			<th><b>Department</b></th>
			<!--<th ><b>Cost Center</b></th>-->
			<!--<th><b>Employee Building</b></th>-->
			<!--<th><b>Employee Room</b></th>-->
			<th><b>Tag Number</b></th>
			<th><b>Key</b></th>
			<th><b>Series #</b></th>
			<th><b>Key Building</b></th>
			<th><b>Key Room</b></th>
			<th><b>Disposition</b></th>
			<th><b>Disposition Date</b></th>
			<th><b>Issue Date</b></th>';
		echo '</thead>';

	while($row = mysqli_fetch_array($result))
	{
		$dataid = $row['dataid'];
		$q = "SELECT * FROM key_database WHERE dataid = $dataid ORDER BY $order $sort ";
		$rs = @mysqli_query($dbc, $q);

		while($row2 = mysqli_fetch_assoc($rs))
		{
			// this is only to get the department
            $idlink = $row2['idlink'];
			$qq = "SELECT dep FROM department WHERE idlink = $idlink";
			$rr = mysqli_query($dbc, $qq);
			$r3 = mysqli_fetch_array($rr);
			if(mysqli_num_rows($rr)==0){
				$dep = $row2['department'];
			}else{
				$dep = $r3[0];
			}
			/////////////////////////////////////

			// This is  color coding dispositions

			///////


			echo '<tr bgcolor = "">';
			echo '<td>';?>
			<input type = "checkbox" name = "checklist[]" class="checklist" value ="<?php echo $row2['dataid'];?>"	/>
			<input type = "submit" id ="submit-checked" name = "submit-checked" class = "hidden"/>
			<input type = "submit" id ="submit-checked-transfer" name = "submit-checked-transfer" class = "hidden"/>
			<input type = "submit" id ="submit-checked-report" name = "submit-checked-report" class = "hidden"/>
			<input type = "submit" id ="submit-checked-excel" name = "submit-checked-excel" class = "hidden"/>

			<?php echo '</td>';
			echo '<td>' . $row2['status'] . '</td>';
			echo '<td><a href = "keydatabase_details.php?id=' . $dataid . '" target = "_blank">' . $row2['lastname'] . '</a></td>';
			echo '<td>' . $row2['firstname'] . '</td>';
			echo '<td>' . $row2['employeenum'] . '</td>';
			echo '<td>' . $row2['iso'] . '</td>';
			echo '<td><a href = "department.php?c='.$row2['costcenter'].'&id='.$dataid.'">' . $dep. '</a></td>';
			//echo '<td>' . $row2['costcenter'] . '</td>';
			//echo '<td>' . $row2['empbld'] . '</td>';
			//echo '<td>' . $row2['emprm'] . '</td>';
			echo '<td><a href = "search_by_lastname.php?tagfromlink='.$row2['tag'].'" >' . $row2['tag'] . '</a></td>';
			echo '<td><a href = "search_by_key.php?keyNum=' . $row2['keyname'] . '" target = "_blank">' . $row2['keyname'] . '</a></td>';
			echo '<td>' . $row2['series'] . '</td>';
			echo '<td>' . $row2['keybld'] . '</td>';
			echo '<td>' . $row2['keyrm'] . '</td>';
			echo '<td>' . $row2['disposition'] . '</td>';
			echo '<td>' . $row2['dispositiondate'] . '</td>';
			echo '<td>' . $row2['issuedate'] . '</td>';
			echo '</tr>';

		}
		mysqli_free_result($rs);
	}
	mysqli_free_result($result);

	echo '</table>';
	echo '</form>';
?>
<script>
function load(){

	var tr = document.getElementsByTagName("tr");
	for (var i = 0; i < tr.length ; i++){
		var disp = tr[i].childNodes[12].innerText;

		if (disp == 'Processing'){
			tr[i].style.backgroundColor = "#fc5353";
			tr[i].style.color = "#ffffff";
		}
		if (disp == 'No Receipt'){
			tr[i].style.backgroundColor = "#FFFF00";
			//tr[i].style.color = "#ffffff";
		}
		if (disp == 'Returned'){
			tr[i].style.backgroundColor = "#D3D3D3";
			//tr[i].style.color = "#ffffff";
		}
	}
}
function deleteConfirm(){
	if(confirm("You are about to delete key(s), are you sure you want to do that?")){
		deleteSelected();
	}else{

	}

}
function deleteSelected(){
	var checkboxes = document.getElementsByClassName("checklist");
	var id = [];
	for (var j = 0; j < checkboxes.length; j++){
		if(checkboxes[j].checked){
			id.push(checkboxes[j].value);
		}
	}


	var link = "delete_key.php?";
	for (var i = 0; i < id.length; i++){
		if (i <id.length - 1){
			link = link+"id[]="+id[i]+"&";
		}
		else{
			link = link+"id[]="+id[i];
		}

	}

	document.getElementById("delete").href = link;
	console.log(link);
}
function triggerReturn(){
	var checkboxes = document.getElementsByClassName("checklist");
	var id = [];
	//console.log(checkboxes);
	for (var i = 0; i < checkboxes.length; i++){
		if(checkboxes[i].checked){
			id.push(checkboxes[i].value);
		}
	}
	//console.log(id);
	var link = "trigger_return.php?";
	for (var i = 0; i < id.length; i++){
		if (i <id.length - 1){
			link = link+"id[]="+id[i]+"&";
		}
		else{
			link = link+"id[]="+id[i];
		}
}
document.getElementById("trigger").href = link;
//console.log(link);

}
function assignKey(){
	var checkboxes = document.getElementsByClassName("checklist");
	var id = [];
	for (var i = 0; i < checkboxes.length; i++){
		if(checkboxes[i].checked){
			id.push(checkboxes[i].value);
		}
	}
	if(confirm("You are changing the Dispostions of the selected keys")){

		$.ajax({
			type: "GET",
			url: "assign_key.php",
			data:{
				idList: id,
			},
			dataType: "JSON",
			success: function(data){
			}

		});

	}
}
</script>
<center>
<ul class = "pagination">
<?php

	if($pages > 1) //Set up pages if necessary
	{
		$link = 'keydatabase.php?dataid=' . $dataid. '&p=' . $pages . '&lastname=' .$lastname . '&firstname=' .$firstname . '&employeenum=' .$employeenum . '&ssn=' .$ssn .'&iso=' . $iso . '&disposition=' . $disposition . '&dispositiondate=' . $dispositiondate . '&costcenter=' . $costcenter . '&empbld=' . $empbld . '&emprm=' . $emprm . '&tag=' . $tag . '&keyname=' . $keyname . '&series=' . $series . '&keybld=' . $keybld . '&keyrm=' . $keyrm . '&issuedate=' . $issuedate . '&department=' . $department . '&receiptdate=' . $receiptdate . '&status=' . $status;
		echo paginate($pages, $start, $display, $link);
	}
	include ('includes/footer.html');
?>
</ul>
</center>
</body>
</html>
