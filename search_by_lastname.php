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
	$page_title = 'Search Results';
	include ('includes/header.html');


?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script type = "text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" >
<script type = "text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

<script type = "text/javascript">
	$(document).ready(function(){
		$('#checkall').click(function(){
			$('.checklist').prop('checked',this.checked);

		});
	});
</script>
<style>
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
background-color: #E0EFFF;
}
body{
		background-color: #ECEBE4;
		border: 5px groove #BDC4A7;
		margin: 6px;
		margin-right: 8px;
	}
table, tr, td, th{
	text-align: center;

}

</style>
<body onload = "load()">
<a href ="keydatabase.php" class = "btn btn-default" style ="margin-left: 70px;">Back</a>
<h1>Search Results</h1>
<br>
<div class = "container">
    <form action="pdf_key_reciept_transfer_returnreport.php" method="post"></form>
</div>
<?php
if (isset($_POST['search-box']) || isset($_GET['tagfromlink'])){

	$name = $_POST['name'];
	$bld = $_POST['keybld'];
	$dep = $_POST['department'];
	$disp = $_POST['disposition'];
	$sql = "SELECT * FROM key_database";

//enables searching from link under tags
	if (isset($_GET['tagfromlink'])){
		$tag = $_GET['tagfromlink'];
		$sql .= " WHERE tag LIKE '%".$tag."%' ";
	}else{
// searching from search box
	if ($_GET['tag']!=""){
		$tag = $_GET['tag'];
		$sql .= " WHERE tag LIKE '%".$name."%' ";

	}

	else if ($_GET['key']!=""){
		$key = $_GET['key'];
		$sql .= " WHERE keyname = '".$name."' ";
	}

	else if ($_GET['count'] == 0){
		//$name = preg_replace("#[^0-9a-z]#i","",$name);
		$name = addslashes($name);
		$sql .= " WHERE (lastname LIKE '%".$name."%' OR firstname LIKE '%".$name."%')";
		if ($bld !='all'){
			$sql.=" AND keybld ='".$bld."'";
		}
		if ($dep != 'all'){
			$sql.=" AND idlink = '".$dep."'";
		}
		if ($disp != 'all'){
			$sql.=" AND disposition = '".$disp."'";
		}

		if($name ==""){
				$sql = "SELECT * FROM key_database ";
				if ($bld !='all'){
					$sql.=" WHERE keybld LIKE '%".$bld."%' ";

					if ($dep != 'all'){
						$sql.=" AND idlink = '".$dep."'";

					}

					if($disp != 'all'){
						$sql.=" AND disposition = '".$disp."'";
						//echo "disp - ".$sql."<br>";
					}

				}else if($dep != 'all'){
						$sql.=" WHERE idlink = '".$dep."'";
						if ($bld !='all'){
							$sql.=" AND keybld LIKE '%".$bld."%' ";
						}
						if($disp != 'all'){
							$sql.=" AND disposition = '".$disp."'";
							//echo "disp - ".$sql."<br>";
						}
				}
				else if ($disp != 'all'){
					$sql.=" WHERE disposition = '".$disp."'";
					if ($dep != 'all'){
						$sql.=" AND idlink = '".$dep."'";

					}
					if ($bld !='all'){
						$sql.=" AND keybld LIKE '%".$bld."%' ";
					}

				}
		}

	}
}
// echo $sql;
	if ($name =="" && $bld =="all" && $dep == "all" && $disp =="all"){
		echo 'NOTHING ENTERED';
	}
else{


	$result = mysqli_query($dbc,$sql);

	$records = mysqli_num_rows($result);
	if ($records == 0){

		echo '<h1>NOT FOUND. Try selecting a filter</h1>';

	}
	else{
	?>
	<div style="margin-left: 200px;">
	<a style ="margin-left:20px;" id="key" class="btn btn-primary" tabindex="0" href  = "" target="_blank" onclick = "sendCheck('p','key')">Key Agreement</a>
	<!-- <a style ="margin-left:20px;" id ="key-transfer" class="btn btn-primary" tabindex="0" href  = "" target="_blank" onclick = "sendCheck('t','key-transfer')">Key Transfer Receipt</a> -->
	<a href = "key_transfer_process.php"style ="margin-left:20px;" class = "btn btn-primary">Process Transfer</a>
	<a style ="margin-left:20px;" id ="key-return-report" class="btn btn-primary" tabindex="0" href  = "" target="_blank" onclick = "sendCheck('r','key-return-report')">Key Return Report</a>
  <a style ="margin-left:20px;" id ="trigger" class="btn btn-primary" tabindex="0" href  = "" target="_blank" onclick = "triggerReturn()">Process Return</a>
	<a style ="margin-left:20px;" href= "add_key.php" class="btn btn-primary" tabindex="0">Add Key</a>
	<a style ="margin-left:20px;" id ="excel-export" class="btn btn-success" tabindex="0" href  = "" target="_blank" onclick = "sendCheck('e','excel-export')">Export Excel</a>

	<?php
	if($_SESSION['admin_level'] >= 3)//These users have authority to directly make changes to records.
		{
			echo '<a href = ""style ="margin-left:20px;" class = "btn btn-primary" id = "assignKey" onClick = "assignKey()">Assign Key</a>';
			echo '<a style ="margin-right:20px; margin-left: 20px;" href= "" class="btn btn-danger" tabindex="0" id = "delete" onClick="deleteSelected()">Delete Key</a>';
		}
	echo'</div>';
	echo '<h1 style ="font-size:12pt; text-decoration:none">Displaying ' . $records .' records</h1><br>';

	echo "<br>";
	echo '<table style="width: 90%; margin-right: auto; margin-left: auto;" class = "table table-striped table-bordered table-hover table-condensed" id ="full-table">'; //Display table, allowing sort to be done based on user selection
	echo '<thead>';
	echo '
	<th><input type = "checkbox" id = "checkall" name="checkall" value =""/></th>
	<th><b>Campus Group</b></th>
	<th><b>Last Name </b></th>
	<th><b>First Name</b></th>
	<th><b>Employee Number</b></th>
	<th><b>ISO</b></th>
	<th><b>Department</b></th>
	<th><b>Tag Number</b></th>
	<th><b>Key</b></th>
	<th><b>Series #</b></th>
	<th><b>Key Building</b></th>
	<th><b>Key Room</b></th>
	<th><b>Disposition</b></th>
	<th><b>Disposition Date</b></th>
	<th><b>Issue Date</b></th>';
	echo '</thead>';

		while ($row = mysqli_fetch_array($result)){

			echo '<tr>';
			echo '<td>';?>

			<input type = "checkbox" name = "checklist[]" class="checklist" value ="<?php echo $row['dataid'];?>"	/>

			<input type = "submit" id ="submit-checked" name = "submit-checked" class = "hidden"/>
			<input type = "submit" id ="submit-checked-transfer" name = "submit-checked-transfer" class = "hidden"/>
			<input type = "submit" id ="submit-checked-report" name = "submit-checked-report" class = "hidden"/>
			<input type = "submit" id ="submit-checked-excel" name = "submit-checked-excel" class = "hidden"/>
			<?php echo '</td>';

            // this is only to get the department
			$qq = "SELECT dep FROM department WHERE idlink = '".$row['idlink']."'";
			$rr = mysqli_query($dbc, $qq);
			$r3 = mysqli_fetch_array($rr);
            $dep = $r3['dep'];

			/////////////////////////////////////

			echo '<td>' . $row['status'] . '</td>';
			echo '<td><a href = "keydatabase_details.php?id=' . $row['dataid'] . '" target = "_blank">' . $row['lastname'] . '</a></td>';
			echo '<td>' . $row['firstname'] . '</td>';
			echo '<td>' . $row['employeenum'] . '</td>';
			echo '<td>' . $row['iso'] . '</td>';
			//echo '<td><a href = "department.php?c='.$r3[0].'">' . $row['department']. '<a></td>';
	       //echo '<td><a href = "department.php?c='.$r3[0].'">' . $r3[0]. '<a></td>';
	       echo '<td><a href = "department.php?c='. $row['idlink'] .'">'. $dep . '</a></td>';

			echo '<td><a href = "search_by_lastname.php?tagfromlink='.$row['tag'].'" >' . $row['tag'] . '</a></td>';
			echo '<td><a href = "search_by_key.php?keyNum=' . $row['keyname'] . '" target = "_blank">' . $row['keyname'] . '</a></td>';
			echo '<td>' . $row['series'] . '</td>';
			echo '<td>' . $row['keybld'] . '</td>';
			echo '<td>' . $row['keyrm'] . '</td>';
			echo '<td>' . $row['disposition'] . '</td>';
			echo '<td>' . $row['dispositiondate'] . '</td>';

			echo '<td>' . $row['issuedate'] . '</td>';
			echo '</tr>';

		}
		echo '</table>';


	}
  }
}
?>




<script>
$(document).ready(function() {
    $('#full-table').DataTable({
		"bPaginate": false,
		"bFilter": false,

		"columnDefs": [{
			'targets': 0,
			'searchable': false,
			'orderable': false,
			'className': 'dt-body-center',
			//'render': function (data, type, full, meta){
			//	return '<input type="checkbox" name="checklist[]" value="' + $('<div/>').text(data).html() + '">';
			//}

		}],
		'order': [[1, 'asc']],
	});
} );
function load(){
	var tr = document.getElementsByTagName("tr");

	for ( var i = 0; i < tr.length ; i++){
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
function sendCheck(k, m){
	var checkboxes = document.getElementsByClassName("checklist");
	var id = [];
	for (var j = 0; j < checkboxes.length; j++){
		if(checkboxes[j].checked){
			id.push(checkboxes[j].value);
		}
	}


	var link = "pdf_key_reciept_transfer_returnreport.php?";
	for (var i = 0; i < id.length; i++){

		link = link+"id[]="+id[i]+"&";


	}
	link = link+"w="+k;

	document.getElementById(m).href = link;
	console.log(link);
}
function deleteAlert(){
	alert("Are you sure you want to delete the key records? ");
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
		if (i < id.length - 1){
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
	console.log(checkboxes);
	for (var i = 0; i < checkboxes.length; i++){
		if(checkboxes[i].checked){
			id.push(checkboxes[i].value);
		}
	}
	console.log(id);
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
console.log(link);

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
</form>
</body>
