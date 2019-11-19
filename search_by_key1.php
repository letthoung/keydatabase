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
	}
	else
	{		
		$key_num = (isset($_GET['keyNum']))? $_GET['keyNum']:'';
		$mailbox = (isset($_GET['mailbox']))? $_GET['mailbox']:'';
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
	$subQuery = '';
	$c = 0;
	
	if($key_num != '' || $mailbox != '')
	{
		if($mailbox != '')
		{
			if($mailbox !== '0')
			{
				if($c == 0)
				{
					$subQuery = "mailbox = '$mailbox'";
					$c++;
				}
				else
				{
					$subQuery .= " AND mailbox = '$mailbox'";
				}
			}
			//$query = "SELECT * FROM doors WHERE mailbox = '$mailbox' ORDER BY door_id LIMIT $start,$display";
			//$query2 = "SELECT * FROM doors WHERE mailbox = '$mailbox'";
		}
		if($key_num != '')
		{
			if($key_num !== '0')
			{
				if($c == 0)
				{
					$subQuery = "key_id = '$key_num'";
					$c++;
				}
				else
				{
					$subQuery .= " AND key_id = '$key_num'";
				}
			}
			
		}
		if($c != 0)
		{
			$query = "SELECT door_key.*, doors.* FROM doors WHERE $subQuery ORDER BY door_id LIMIT $start,$display";
			$query2 = "SELECT door_key.*, doors.* FROM doors WHERE $subQuery";
		}
		else
		{
			$query = "SELECT door_key.*, doors.* FROM doors  ORDER BY door_id LIMIT $start,$display";
			$query2 = "SELECT * FROM doors";
		}
	/*	if($key_num != '')
		{
			$query = "SELECT * FROM door_key WHERE key_id = '$key_num' ORDER BY door_id LIMIT $start,$display";
			$query2 = "SELECT * FROM door_key WHERE key_id = '$key_num'";
		}
		else
		{
			$query = "SELECT * FROM door_key ORDER BY key_id LIMIT $start,$display";
			$query2 = "SELECT * FROM door_key";
		}
	*/
	}
	else
	{
		$query = "SELECT * FROM door_key ORDER BY key_id LIMIT $start,$display";
			$query2 = "SELECT * FROM door_key";
	}
	
		
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
	};
	
	

	$display = 10;
	
	
	$result = @mysqli_query($dbc, $query);

	$rscount = @mysqli_query($dbc, $query2);
	$records = mysqli_num_rows($rscount);
		

	

	$page_title = 'Search by keys';
	include ('includes/header.html');
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
	<p><a href = "locksmith.php" target = "_self"><b>Back</b></a></p><br>
	<form action="search_by_key.php" method="post">
    			<select name = "key_id" id = "key_id">
			<option value = '' <?php if($key_num ==''){echo 'selected';}?>>All Keys</option>
			<?php
				$q = "SELECT DISTINCT key_id FROM door_key WHERE key_id != '' ORDER BY key_id";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['key_id'] . '" ';
					if($key_num != '' && $key_num == $row['key_id'])
					{
						echo ' selected ';
					}
					echo '>' . $row['key_id'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>	
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
	
		
		
		<input type = 'Submit' value = 'Search'>
		<a href = "search_by_key.php">Clear Search</a>
	</form>
	
<?php
	echo '<p><b>Number of records: ' . $records . '</b></p>';
	echo '<table class = "t01">'; //Display table, allowing sort to be done based on user selection
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

<?php
	mysqli_close($dbc);
	if($pages > 1) //Set up pages if necessary
	{
		$link = 'search_by_key.php?keyNum=' . $key_num . '&p=' . $pages . '&mailbox=' .$mailbox;
		echo paginate($pages, $start, $display, $link);
	}
	
	include ('includes/footer.html');
?>