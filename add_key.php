<?php
	session_start(); // Start the session.

	require ('includes/login_functions.inc.php');

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) )
	{
		redirect_user('index.php');
	}
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
		if(!empty($_POST['ssn']))
		{
			$ssn = $_POST['ssn'];
		}
		else
		{
			$ssn = NULL;
		}
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
		if(!empty($_POST['department']))
		{
			$idlink = $_POST['department'];
		}
		else
		{
			$idlink = NULL;
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


		//If no errors were detected during validation
		if(empty($errors))
		{
			/*if($_SESSION['admin_level'] >= 2)//These users have authority to directly make changes to records.
			{*/
				//Prepare a statement to send to the database with all new values.
				$query = "INSERT INTO key_database ( lastname, firstname, employeenum, iso, disposition, dispositiondate, empbld, emprm, tag, keyname, series, keybld, keyrm, issuedate, receiptdate, status, idlink)";
				$query.=" VALUES ('".mysqli_real_escape_string($dbc,$lastname)."', '".mysqli_real_escape_string($dbc,$firstname)."', '$employeenum', '$iso', '$disposition', '$dispositiondate', '$empbld', '$emprm', '$tag', '$keyname', '$series', '$keybld', '$keyrm', '$issuedate', '$receiptdate', '".mysqli_real_escape_string($dbc,$status)."', {$idlink})";
				$result = mysqli_query($dbc, $query);
				if(!$result) {
				    die('Query FAILED! ' . mysqli_error($dbc));
				} else {
                    echo 'Key Added';
                    $userfirstname = $_SESSION['first_name'];
                    $userlastname = $_SESSION['last_name'];
                    $action = 'ADDED new key record for key: '.$keyname;
                    recordTimestamp($userfirstname , $userlastname ,$action );
				}
/*
			}*/

		}
	}



	$page_title = 'Add Keys';
	include ('includes/header.html');
?>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<body>
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
		echo '<a href="keydatabase.php"><b>Back</b></a><br>';
		echo '<br />';
	?>

<form style = "width:100%" action = "add_key.php" method = "POST">
	<table class = "table table-striped table-bordered table-hover table-condensed">
		<tbody>
			<tr>
				<th>Key ID: </th>
				<td><?php echo $row['dataid']; ?></td>
			</tr>
			<tr>
			<th>Name</th>
			<td>
			<select class="search" name="name" id = 'search' onchange="change()">
				<option>Select a Person</option>
				<?php
					$sql = "SELECT DISTINCT firstname, lastname From key_database";
					echo '';
					$res = mysqli_query($dbc, $sql);
					while ($row = mysqli_fetch_array($res)){
						echo "<option>".$row['firstname']." ".$row['lastname']."</option>";
					}
				 ?>
			 </select>

			</td>
			</tr>
			<tr>
			<th>Last Name</th>
			<td><input type = "text" id = "lastname" name = "lastname" ></td>
			</tr>
			<tr>
				<th>First Name</th>
				<td><input type = "text" id = "firstname" name = "firstname" ></td>
			</tr>
			<tr>
				<th>Tag Number</th>
				<td id = 'tagtd'><input type = "text" id = "tag" name = "tag" ></td>
			</tr>
			<tr>
				<th>Employee Number</th>
				<td><input type = "text" id = "employeenum" name = "employeenum" ></td>
			</tr>
			<tr >
				<th>ISO</th>
				<td><input type = "text" id = "iso" name = "iso" ></td>
			</tr>
			<tr>
				<th>Department</th>
				<td>
				<select name = "department" id = "department" onchange = "autoFill(this[selectedIndex].value)">
				<option></option>
				<?php
				$q = "SELECT * FROM department ORDER BY dep";
				$rs = @mysqli_query($dbc, $q);

				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['idlink'] . '" >' . $row['dep'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
				</select>

				</td>
			</tr>
			<tr>
				<th>Campus Group</th>
				<td><select  id = "type" name = "status">
						<option value = " " > </option>
						<option value = "Faculty" > Faculty </option>
						<option value = "Student"> Student </option>
						<option value = "Staff"> Staff </option>
						<option value = "Master Ring">Master Ring</option>
						<option value = "Contractor"> Contractor </option>
					</select>
				</td>
			</tr>
			<tr>
			<th>Key Disposition</th>
			<td><select name = "disposition" id = "disposition">
				<option id = "Processing"> Processing </option>
				<option id = "Assigned"> Assigned </option>
				<option id = "Returned"> Returned </option>
				<option id = "Lost-Not-Paid"> Lost-Not Paid </option>
				<option id = "Lost-Paid"> Lost-Paid </option>
				<option id = "Lost-Stolen"> Lost-Stolen </option>
				<option id = "Left University"> Left University</option>
				<option id = "No Receipt"> No Receipt</option>
				</select>
			</td>
			</tr>
			<tr>
				<th>disposition Date</th>
				<td><input type = "date" id = "dispositiondate" name = "dispositiondate" value ="<?php echo date('Y-m-d'); ?>"></td>
			</tr>



			<tr>
				<th>Key Name:</th>
				<td><input type = "text" id = "keyname" name = "keyname" onblur="findKeyRoom()"></td>
			</tr>
			<tr>
				<th>Series</th>
				<td><input type = "text" id = "series" name = "series" ></td>
			</tr>
			<tr>
				<th>Key Building</th>
				<td>
				<select class = "search" name = "keybld" id = "bld">
				<option value = ""><option>
				<?php
				$s = "SELECT DISTINCT bld_name FROM Buildings ORDER BY bld_name";
				$res = mysqli_query($dbc, $s);
				while ($rr = mysqli_fetch_assoc($res)){
					echo "<option value = '".$rr['bld_name']."' ";
						if($keybld == $rr['bld_name'] || $row['keybld'] == $rr['bld_name']){
							echo 'selected';
						}
					echo ">".$rr['bld_name']."</option>";
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<th>Key Room</th>
				<td><input type = "text" id = "keyrm" name = "keyrm" > <a href = "http://norsegis.nku.edu/search_by_key.php">Locksmith database</a></td>
			</tr>
			<tr>
				<th>Issue Date</th>
				<td><input type = "date" id = "issuedate" name = "issuedate" value = "<?php echo date('Y-m-d');?>"></td>
			</tr>



			<tr style = "display: none">
				<th>Cost Center</th>
				<td><input type = "text" id = "costcenter" name = "costcenter" ></td>
			</tr>
			<tr style = "display: none">
				<th>Employee Building</th>
				<td><!--<select name = "empbld">
				<option></option>
				<?php/*
				$rb = mysqli_query($dbc, "SELECT DISTINCT bld_name FROM Buildings WHERE bld_no");
				while ($row = mysqli_fetch_assoc($rb)){
					echo '<option value = "'.$row['bld_no'].'">'.$row['bld_name'] .'</option>';
				}
				*/?>
				</select>-->
				<input type = "text" id = "empbld" name = "empbld" ></td>
			</tr>
			<tr style = "display: none">
				<th>Employee Room</th>
				<td><input type = "text" id = "emprm" name = "emprm" ></td>
			</tr>
			<tr style = "display: none">
				<th>Reciept Date</th>
				<td><input type = "text" id = "receiptdate" name = "receiptdate"></td>
			</tr>
		</tbody>
	</table>
<script>
function autoFill(dep){
	var xmlhttp;
	xmlhttp = new XMLHttpRequest()

	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			var returnval = JSON.parse(this.responseText);
			document.getElementById("idlink").value = returnval[0];
			document.getElementById("empbld").value = returnval[1];
			document.getElementById("emprm").value = returnval[2];

		}
	}
	xmlhttp.open("GET","http://norsegis.nku.edu/addkeyphp.php?w="+escape(dep),true);
	xmlhttp.send();

}


</script>
<input style = "margin-top:5px;margin-left:0px;border:thin solid black;" type = "submit" class="btn btn-default" value = "Add Key" onClick = "return confirmAction();">
<?php $link = 'http://norsegis.nku.edu/add_duplicate_key.php?lastname=' .$lastname . '&firstname=' .$firstname . '&employeenum=' .$employeenum .'&iso=' . $iso . '&disposition=' . $disposition . '&dispositiondate=' . $dispositiondate . '&costcenter=' . $costcenter . '&empbld=' . $empbld . '&emprm=' . $emprm . '&tag=' . $tag . '&keyname=' . $keyname . '&series=' . $series . '&keybld=' . $keybld . '&keyrm=' . $keyrm . '&issuedate=' . $issuedate . '&department=' . $department . '&receiptdate=' . $receiptdate . '&status=' . $status;
	?>
<a style = "margin-top:5px;margin-left:0px;border:thin solid black;" id = "cp" class = "btn btn-default" onClick="link()" href="" target="_blank" >Copy & Create</a>
<script>


function link(){
	var lname = document.getElementById('lastname').value;
	var fname = document.getElementById('firstname').value;
	var employeenum = document.getElementById('employeenum').value;
	var iso = document.getElementById('iso').value;
	var disposition = document.getElementById('disposition').value;
	var dispositiondate = document.getElementById('dispositiondate').value;
	var costcenter = document.getElementById('costcenter').value;
	var empbld = document.getElementById('empbld').value;
	var emprm = document.getElementById('emprm').value;
	var tag = document.getElementById('tag').value;
	var keyname = document.getElementById('keyname').value;
	var series = document.getElementById('series').value;
	var keybld = document.getElementById('keybld').value;
	var keyrm = document.getElementById('keyrm').value;
	var issuedate = document.getElementById('issuedate').value;
	var receiptdate = document.getElementById('receiptdate').value;
	var type = document.getElementById('type').value;
	var department = document.getElementById('department').value;
	//console.log(department);
	var link = "add_duplicate_key.php?lastname="+lname+"&firstname="+fname+"&employeenum="+employeenum+"&iso="+iso+ '&disposition='+disposition + '&dispositiondate=' +dispositiondate + '&costcenter=' + costcenter +'&empbld=' +empbld +'&emprm=' +emprm +'&tag=' +tag +'&keyname=' +keyname + '&series=' +series +'&keybld=' +keybld +'&keyrm=' +keyrm + '&issuedate=' +issuedate + '&department=' +department + '&receiptdate=' +receiptdate + '&type=' +type;
	document.getElementById('cp').href=link;
}

var firstname;
var lastname;
function change(){
	//auto completes the fields empnm, iso, dep, tag,status when name is entered
	 var name = document.getElementById('search').value;
	 //console.log(name);
	  var namearr = name.split(" ");
	  //console.log(namearr);
	  firstname = "";
		var firstarr = [];

	  for (var i =  0 ; i <= (namearr.length-2); i++){
	 	 	firstarr.push(namearr[i]);
	  }
		//console.log(firstarr);
		firstname = firstarr.join(" ");
	  lastname = namearr[namearr.length -1];
		if (namearr[0]=='Master'&& namearr[1]=='Ring'){
			firstname = 'Master Ring';
			lastarr = [];
			for (var i = 2; i<namearr.length; i++){
				lastarr.push(namearr[i]);
			}
			//console.log(lastarr);
			lastname = lastarr.join(" ");
		}
	 document.getElementById('firstname').value = firstname;
	 document.getElementById('lastname').value = lastname;
	$.ajax({
		type: 'post',
		url:"add_key_ajax.php",
		data:{
			fname:firstname,
			lname: lastname
		},
		dataType: "JSON",
		success: function(data){
			var arr = data;
			console.log(arr);
			if(arr[0]=="tags"){
				// this condition only modifies the tag input to change it to a dropdown when there are multiple tags associated with the given name
				var select = '<select class = "search" name = "tag" id = "tagsearch" onchange = "tagChange()"><option value = "">Tags</option></select>';
				document.getElementById('tagtd').innerHTML= select;
				for(var i = 1; i< arr.length; i++){
					document.getElementById("tagsearch").innerHTML +='<option>'+arr[i]+'</option>';
				}
				// ressettin the values back to empty to avoid confusion.
				document.getElementById('employeenum').value = "";
				document.getElementById('iso').value = '';
				document.getElementById("department").options[0].selected=true;
				document.getElementById("type").options[0].selected = true;
			}
			else{
				var input = '<input type = "text" id = "tag" name = "tag" >';
				document.getElementById('tagtd').innerHTML = input;
				document.getElementById('tag').value = arr[0];
				document.getElementById('employeenum').value = arr[1];
				document.getElementById('iso').value = arr[2];
                console.log(arr);
				var x = document.getElementById("department").options;
				   for(var i=0;i<x.length;i++){
				        if(x[i].value==arr[5]){
				            x[i].selected=true;
				            break;
				   }
				}
				var y = document.getElementById("type").options;
   			for(var i=0;i<y.length;i++){
        	if(y[i].text==arr[4]){
            y[i].selected=true;
            break;
   }
}
				//document.getElementById('tag').value = arr[3];
				//document.getElementById('tag').value = arr[4];
				document.getElementById('idlink').value = arr[5];
				document.getElementById('emprm').value = arr[6];
				document.getElementById('empbld').value = arr[7];
			}
		}
	});
}
function tagChange(){
	var tag = document.getElementById('tagsearch').value;
	$.ajax({
		type: 'post',
		url: "add_key_ajax.php",
		data:{
			fname: firstname,
			lname: lastname,
			tag:tag
		},
		dataType: "JSON",
		success: function(data){
			var arr = data;
			//console.log(arr);
			document.getElementById('employeenum').value = arr[0];
			document.getElementById('iso').value = arr[1];
			var x = document.getElementById("department").options;
				 for(var i=0;i<x.length;i++){
							if(x[i].text==arr[2]){
									x[i].selected=true;
									break;
				 }
			}
			var y = document.getElementById("type").options;
			for(var i=0;i<y.length;i++){
				if(y[i].text==arr[3]){
					y[i].selected=true;
					break;
		}
}
	document.getElementById('costcenter').value = arr[4];
	document.getElementById('emprm').value = arr[5];
	document.getElementById('empbld').value = arr[6];
}
	});
}
$(document).ready(function(){
	//Select2
 $('.search').select2({
	 placeholder: 'Select a Value',
	 allowClear: true
 });
});
function findKeyRoom(){

	var keyname = document.getElementById('keyname').value;
	console.log(keyname);
	$.ajax({
		type: 'post',
		url:"add_key_ajax.php",
		data:{
			keyname: keyname
		},
		dataType: "JSON",
		success: function(data){
			var arr = data;
			console.log(data);
			document.getElementById('keyrm').value= arr[0];
			//$('#bld option:contains("'+ arr[1] +'")').attr("selected","selected");
			$('#bld').val(''+ arr[1] +'');
			$('#bld').trigger('change');
		}

	});
}
</script>
</form>
</div>
</body>
<?php
	mysqli_free_result ($result);
	mysqli_close($dbc);
	include ('includes/footer.html');
?>
