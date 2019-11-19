<?php
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	//require ('includes/login_functions.inc.php');
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) 
	{		
		redirect_user('index.php');
	}
	
	require ('includes/mysqli_connect.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST') //Get information from the form if user submitted a search
	{				
		$key_num = $_POST['key_id'];
		$mailbox = $_POST['mailbox'];
		$bedroom_a = $_POST['bedroom_a'];
		$bedroom_b = $_POST['bedroom_b'];
		$bedroom_c = $_POST['bedroom_c'];
		$bedroom_d = $_POST['bedroom_d'];
	}
	else
	{		
		$key_num = (isset($_GET['keyNum']))? $_GET['keyNum']:'';
		$mailbox = (isset($_GET['mailbox']))? $_GET['mailbox']:'';
		$bedroom_a = (isset($_GET['bedroom_a']))? $_GET['bedroom_a']:'';
		$bedroom_b = (isset($_GET['bedroom_b']))? $_GET['bedroom_b']:'';
		$bedroom_c = (isset($_GET['bedroom_c']))? $_GET['bedroom_c']:'';
		$bedroom_d = (isset($_GET['bedroom_d']))? $_GET['bedroom_d']:'';
		
	}
	
	if (isset($_GET['s']) && is_numeric($_GET['s'])) //Find the starting point or initialize to zero
	{
		$start = $_GET['s'];
	}
	else 
	{
		$start = 0;
	}
	
	$display = 10;
	
	if($key_num != '' || $mailbox != '' || $bedroom_a != '' || $bedroom_b != '' || $bedroom_c != '' || $bedroom_d != '')
	{
		if($key_num != '')
		{
			
			$query = "SELECT door_key.*, doors.door_number  FROM door_key LEFT JOIN doors ON door_key.door_id = doors.door_id WHERE door_key.key_id = '$key_num' ORDER BY CASE WHEN (doors.door_number LIKE 'IMP%') THEN 1 ELSE 2 END LIMIT $start,$display";
		//$query = "SELECT * FROM door_key WHERE key_id = '$key_num' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM door_key WHERE key_id = '$key_num'";
	}
	
		if($mailbox != '')
	{
		$query = "SELECT * FROM doors WHERE mailbox = '$mailbox' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM doors WHERE mailbox = '$mailbox'";
	}
		if($bedroom_a != '')
		{
		$query = "SELECT * FROM doors WHERE bedroom_a = '$bedroom_a' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM doors WHERE bedroom_a = '$bedroom_a'";
	}
	if($bedroom_b != '')
		{
		$query = "SELECT * FROM doors WHERE bedroom_b = '$bedroom_b' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM doors WHERE bedroom_b = '$bedroom_b'";
	}
	if($bedroom_c != '')
		{
		$query = "SELECT * FROM doors WHERE bedroom_c = '$bedroom_c' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM doors WHERE bedroom_c = '$bedroom_c'";
	}
	if($bedroom_d != '')
		{
		$query = "SELECT * FROM doors WHERE bedroom_d = '$bedroom_d' ORDER BY door_id LIMIT $start,$display";
		$query2 = "SELECT * FROM doors WHERE bedroom_d = '$bedroom_d'";
	}
	}
	else
	{
		$query = "SELECT door_key.*, doors.* FROM door_key INNER JOIN doors ON door_key.door_id = doors.door_id LIMIT $start,$display";
		$query2 = "SELECT door_key.*, doors.* FROM door_key INNER JOIN doors ON door_key.door_id = doors.door_id";
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
	
	
	
	
	

	$page_title = 'Search by keys';
	include ('includes/header.html');
?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  body{
		background-color: #ECEBE4;
		border: 5px groove #BDC4A7;
		margin: 6px;
		margin-right: 8px;
	}
  </style>
<body>	
   <div>
	<img src="norse.jpeg" style="width:150px; position: absolute; right: 3.5%; top: 3.5%;">  
   </div>
   <div class="container"> 
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
	<a href = "locksmith.php" target = "_self"><b style="margin-left:50px;">Back</b></a><br><br>
	<form action="search_by_key.php" method="post" style="margin-left:50px;">
	
    			<input type="text" placeholder = 'Search' name = "key_id" id = "key_id">
			<?php
				$q = "SELECT DISTINCT key_id FROM door_key WHERE key_id != '' ORDER BY key_id";
				$rs = @mysqli_query($dbc, $q);
				
				mysqli_free_result($rs);
			?>
		</input>	
       
	   <select name = "mailbox" id = "mailbox">
			<option value = '' <?php if($mailbox ==''){echo 'selected';}?>>Mailboxes</option>
			<?php
				$q = "SELECT DISTINCT mailbox FROM doors WHERE mailbox != '' ORDER BY mailbox";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['mailbox'] . '" ';
					if($mailbox != '' && $mailbox == $row['mailbox'])
					{
						echo ' selected ';
					}
					echo '>' . $row['mailbox'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
		
		<select name = "bedroom_a" id = "bedroom_a">
			<option value = '' <?php if($bedroom_a ==''){echo 'selected';}?>>Bedroom A</option>
			<?php
				$q = "SELECT DISTINCT bedroom_a FROM doors WHERE bedroom_a != '' ORDER BY bedroom_a";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['bedroom_a'] . '" ';
					if($bedroom_a != '' && $bedroom_a == $row['bedroom_a'])
					{
						echo ' selected ';
					}
					echo '>' . $row['bedroom_a'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
		
		<select name = "bedroom_b" id = "bedroom_b">
			<option value = '' <?php if($bedroom_b ==''){echo 'selected';}?>>Bedroom B</option>
			<?php
				$q = "SELECT DISTINCT bedroom_b FROM doors WHERE bedroom_b != '' ORDER BY bedroom_b";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['bedroom_b'] . '" ';
					if($bedroom_b != '' && $bedroom_b == $row['bedroom_b'])
					{
						echo ' selected ';
					}
					echo '>' . $row['bedroom_b'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
		
		<select name = "bedroom_c" id = "bedroom_c">
			<option value = '' <?php if($bedroom_c ==''){echo 'selected';}?>>Bedroom C</option>
			<?php
				$q = "SELECT DISTINCT bedroom_c FROM doors WHERE bedroom_c != '' ORDER BY bedroom_c";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['bedroom_c'] . '" ';
					if($bedroom_c != '' && $bedroom_c == $row['bedroom_c'])
					{
						echo ' selected ';
					}
					echo '>' . $row['bedroom_c'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
		
		<select name = "bedroom_d" id = "bedroom_d">
			<option value = '' <?php if($bedroom_d ==''){echo 'selected';}?>>Bedroom D</option>
			<?php
				$q = "SELECT DISTINCT bedroom_d FROM doors WHERE bedroom_d != '' ORDER BY bedroom_d";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['bedroom_d'] . '" ';
					if($bedroom_d != '' && $bedroom_d == $row['bedroom_d'])
					{
						echo ' selected ';
					}
					echo '>' . $row['bedroom_d'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
	
		
		<br><br>
		<input type = 'Submit' class="btn btn-default" value = 'Search'>
		<a href = "search_by_key.php" class="btn btn-default">Clear Search</a>
	</form>
	
<?php
	echo '<p><b>Number of records: ' . $records . '</b></p>';
	echo '<table class = "table table-striped table-bordered table-hover table-condensed">'; //Display table, allowing sort to be done based on user selection
	echo '<tr>';
	echo '<th><b>Door Number</b></th><th><b>Building</b></th><th><b>Used For</b></th><th><b>Brand</b></th><th><b>Type</b></th><th><b>Function</b></th><th><b>Description</b></th><th><b>Miscellaneous</b></th><th><b>Mailbox</b></th><th><b>Bedroom A</b></th><th><b>Bedroom B</b></th><th><b>Bedroom C</b></th><th><b>Bedroom D</b></th>';
	echo '</tr>';
	while($row = mysqli_fetch_array($result))
	{
		$d_id = $row['door_id'];
		$q = "SELECT doors.*, lock_buildings.bld_name FROM doors LEFT JOIN lock_buildings ON doors.building = lock_buildings.bld_no WHERE door_id = $d_id";
		$rs = @mysqli_query($dbc, $q);
		while($row2 = mysqli_fetch_array($rs))
		{
			echo '<tr>';		
			echo '<td><a href = "edit_door.php?id=' . $d_id . '" target = "_blank">' . $row2['door_number'] . '</a></td>';			
			echo '<td>' . $row2['bld_name'] . '</td>';
			echo '<td>' . $row2['used_for'] . '</td>';
			echo '<td>' . $row2['brand'] . '</td>';
			echo '<td>' . $row2['type'] . '</td>';
			echo '<td>' . $row2['function'] . '</td>';
			echo '<td>' . $row2['description'] . '</td>';
			echo '<td>' . $row2['misc'] . '</td>';
			echo '<td>' . $row2['mailbox'] . '</td>';
			echo '<td>' . $row2['bedroom_a'] . '</td>';
			echo '<td>' . $row2['bedroom_b'] . '</td>';
			echo '<td>' . $row2['bedroom_c'] . '</td>';
			echo '<td>' . $row2['bedroom_d'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<th>Keys:</th>';
			echo '<td colspan="12">';
			$q = "SELECT * FROM door_key WHERE door_id = $d_id";
			$rs2 = @mysqli_query($dbc, $q);
			$keys = '';
			while($row3 = mysqli_fetch_array($rs2))
			{
				if($keys == '')
				{
					$keys .= $row3['key_id'];
				}
				else
				{
					$keys .= ' X ' . $row3['key_id'];
				}
			}
			mysqli_free_result($rs2);
			echo $keys;
			echo '</td>';
			echo '</tr>';
		}
		mysqli_free_result($rs);
	}
	mysqli_free_result($result);
	echo '<table>';
?>
</div>
</body>
<center>
<ul class = "pagination">
<?php
	mysqli_close($dbc);
	if($pages > 1) //Set up pages if necessary
	{
		$link = 'search_by_key.php?keyNum=' . $key_num . '&p=' . $pages . '&mailbox=' .$mailbox . '&bedroom_a=' . $bedroom_a . '&bedroom_b=' . $bedroom_b . '&bedroom_c=' . $bedroom_c . '&bedroom_d=' . $bedroom_d;
		echo paginate($pages, $start, $display, $link);
	}
	
	include ('includes/footer.html');
?>
</ul>
</center>