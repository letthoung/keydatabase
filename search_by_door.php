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
		$bld = $_POST['bld'];
		$door_num = $_POST['door_num'];
	}
	else
	{
		$bld = (isset($_GET['b']))? $_GET['b']:'';
		$door_num = (isset($_GET['doorNum']))? $_GET['doorNum']:'';
	}
	
	if (isset($_GET['s']) && is_numeric($_GET['s'])) //Find the starting point or initialize to zero
	{
		$start = $_GET['s'];
	}
	else 
	{
		$start = 0;
	}
	
	$sort = (isset($_GET['sort']))? $_GET['sort'] : 'dn'; //Get the sort parameter
	
	switch ($sort) // Set up sort ascending or descending
	{
		case 'bld':
			$order_by = 'bld_name DESC';	
			break;
		case 'bl':
			$order_by = 'bld_name ASC';	
			break;
		case 'dnd':
			$order_by = 'door_number DESC';	
			break;
		case 'dn':
			$order_by = 'door_number ASC';	
			break;
		case 'tp':
			$order_by = 'type ASC';	
			break;
		case 'tpd':
			$order_by = 'type DESC';	
			break;
		case 'de':
			$order_by = 'description ASC';	
			break;
		case 'ded':
			$order_by = 'description DESC';	
			break;
		case 'uf':
			$order_by = 'used_for ASC';	
			break;
		case 'ufd':
			$order_by = 'used_for DESC';	
			break;
		case 'bd':
			$order_by = 'brand ASC';	
			break;
		case 'bdd':
			$order_by = 'brand DESC';	
			break;
		case 'fu':
			$order_by = 'function ASC';	
			break;
		case 'fud':
			$order_by = 'function DESC';	
			break;
		case 'mi':
			$order_by = 'misc ASC';	
			break;
		case 'mid':
			$order_by = 'misc DESC';	
			break;
		case 'mb':
			$order_by = 'mailbox ASC';	
			break;
		case 'mbd':
			$order_by = 'mailbox DESC';	
			break;
		case 'ba':
			$order_by = 'bedroom_a ASC';	
			break;
		case 'bad':
			$order_by = 'bedroom_a DESC';	
			break;
		case 'bb':
			$order_by = 'bedroom_b ASC';	
			break;
		case 'bbd':
			$order_by = 'bedroom_b DESC';	
			break;
		case 'bc':
			$order_by = 'bedroom_c ASC';	
			break;
		case 'bcd':
			$order_by = 'bedroom_c DESC';	
			break;
		case 'brd':
			$order_by = 'bedroom_d ASC';	
			break;
		case 'brdd':
			$order_by = 'bedroom_d DESC';	
			break;
		default:
			$order_by = 'door_number ASC';
			$sort = 'dn';
			break;
	}
	
	
	$display = 10;
	$subQuery = '';
	$c = 0;
	
	if($bld !== '' || $door_num !== '')
	{
		if($bld !== '')
		{
			if($bld !== '0')
			{
				if($c == 0)
				{
					$subQuery = "building = '$bld'";
					$c++;
				}
				else
				{
					$subQuery .= " AND building = '$bld'";
				}
			}
		}
		if($door_num !== '')
		{
			if($c == 0)
			{
				$subQuery = "door_number LIKE '%$door_num%' OR mailbox LIKE '%$door_num%' OR bedroom_a LIKE '%$door_num%' OR bedroom_b LIKE '%$door_num%' OR bedroom_c LIKE '%$door_num%' OR bedroom_d LIKE '%$door_num%'";
				$c++;
			}
			else
			{
				$subQuery .= " AND (door_number LIKE '%$door_num%' OR mailbox LIKE '%$door_num%' OR bedroom_a LIKE '%$door_num%' OR bedroom_b LIKE '%$door_num%' OR bedroom_c LIKE '%$door_num%' OR bedroom_d LIKE '%$door_num%')";
			}
		}
		if($c != 0)
		{
			$query = "SELECT doors.*, lock_buildings.bld_name FROM doors LEFT JOIN lock_buildings ON doors.building = lock_buildings.bld_no WHERE $subQuery ORDER BY $order_by LIMIT $start, $display";
			$query2 = "SELECT doors.*, lock_buildings.bld_name FROM doors LEFT JOIN lock_buildings ON doors.building = lock_buildings.bld_no WHERE $subQuery";
		}
		else
		{
			$query = "SELECT doors.*, lock_buildings.bld_name FROM doors LEFT JOIN lock_buildings ON doors.building = lock_buildings.bld_no ORDER BY $order_by LIMIT $start, $display";
			$query2 = "SELECT * FROM doors";
		}
	}
	else
	{
		$query = "SELECT doors.*, lock_buildings.bld_name FROM doors LEFT JOIN lock_buildings ON doors.building = lock_buildings.bld_no ORDER BY $order_by LIMIT $start, $display";
		$query2 = "SELECT * FROM doors";
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
	
	$page_title = 'Search by doors';
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
<script>
	function deleteDoor(ind)
	{
		var xmlhttp;
		if(confirmAction())
		{
			xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
			xmlhttp.onreadystatechange = function()//Function called when there is a change of state for the server
			{                                      //request
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//when request is complete and no issues
				{
					location.reload();
				}
			};
			xmlhttp.open("GET","delete_door.php?id="+ind,true);
			xmlhttp.send();
		}
	}

</script>
<body>
   <div>
	<img src="norse.jpeg" style="width:150px; position: absolute; right: 3.5%; top: 3.5%;"> 
	</div>
   <div class="container"> 
	<p><a href = "locksmith.php" target = "_self"><b>Back</b></a></p><br>
	<form action="search_by_door.php" method="post">
    
		<select name = "bld" id = "bld">
        
        
			<option value = '' <?php if($bld==''){echo 'selected';}?>>All Buildings</option>
			<?php
				$q = "SELECT * FROM lock_buildings ORDER BY bld_name";
				$rs = @mysqli_query($dbc, $q);
				while($row = mysqli_fetch_array($rs))
				{
					echo '<option value = "' . $row['bld_no'] . '" ';
					if($bld != '' && $bld == $row['bld_no'])
					{
						echo ' selected ';
					}
					echo '>' . $row['bld_name'] . '</option>';
				}
				mysqli_free_result($rs);
			?>
		</select>
		<input type = 'text' name = 'door_num' id = 'door_num' placeholder = 'Search' value = '<?php if($door_num !== ''){echo $door_num;}?>'>
		<input type = 'Submit' class="btn btn-default" value = 'Search'>
		<a href = "search_by_door.php" class="btn btn-default">Clear Search</a>
	</form>

<?php
	if(!empty($errors))
	{
		echo '<p class = "error">Errors:</p>';			
		foreach($errors as $value) 
		{
			echo '<p class = "error">' . $value . '</p>';
		}
	}
	
	$link = 'search_by_door.php?s=' . $start . '&p=' . $pages . '&b=' . $bld . '&doorNum=' . $door_num;
	echo '<p><b>Number of records: ' . $records . '</b></p>';
	echo '<table class = "table table-striped table-bordered table-hover table-condensed">'; //Display table, allowing sort to be done based on user selection
		echo '<tr>';
		$s = ($sort == 'dn')? 'dnd':'dn';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Door Number</a></b></th>';
		$s = ($sort == 'bl')? 'bld':'bl';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Building</a></b></th>';
		$s = ($sort == 'uf')? 'ufd':'uf';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Used For</a></b></th>';
		$s = ($sort == 'bd')? 'bdd':'bd';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Brand</a></b></th>';
		$s = ($sort == 'tp')? 'tpd':'tp';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Type</a></b></th>';
		$s = ($sort == 'fu')? 'fud':'fu';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Function</a></b></th>';
		$s = ($sort == 'de')? 'ded':'de';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Description</a></b></th>';
		$s = ($sort == 'mi')? 'mid':'mi';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Miscellaneous</a></b></th>';
		$s = ($sort == 'mb')? 'mbd':'mb';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Mailbox</a></b></th>';
		$s = ($sort == 'ba')? 'bad':'ba';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Bedroom A</a></b></th>';
		$s = ($sort == 'bb')? 'bbd':'bb';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Bedroom B</a></b></th>';
		$s = ($sort == 'bc')? 'bcd':'bc';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Bedroom C</a></b></th>';
		$s = ($sort == 'brd')? 'brdd':'brd';
        echo '<th><b><a href="' . $link . '&sort=' . $s . '">Bedroom D</a></b></th>';
		echo '</tr>';
		while ($row = mysqli_fetch_array($result)) 
		{
			$rId = $row['door_id'];
			echo '<tr>';		
			echo '<td><a href = "edit_door.php?id=' . $rId . '" target = "_blank">' . $row['door_number'] . '</a><br><br><span style = "float:center;text-decoration:underline;" onclick = "deleteDoor(' . $rId . ')">Delete</span></td>';			
			echo '<td>' . $row['bld_name'] . '</td>';
			echo '<td>' . $row['used_for'] . '</td>';
			echo '<td>' . $row['brand'] . '</td>';
			echo '<td>' . $row['type'] . '</td>';
			echo '<td>' . $row['function'] . '</td>';
			echo '<td>' . $row['description'] . '</td>';
			echo '<td>' . $row['misc'] . '</td>';			
			echo '<td>' . $row['mailbox'] . '</td>';
			echo '<td>' . $row['bedroom_a'] . '</td>';
			echo '<td>' . $row['bedroom_b'] . '</td>';
			echo '<td>' . $row['bedroom_c'] . '</td>';
			echo '<td>' . $row['bedroom_d'] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<th>Keys: </th>';
			echo '<td colspan="12">';
			$q = "SELECT * FROM door_key WHERE door_id = $rId";
			$rs = @mysqli_query($dbc, $q);
			$keys = '';
			while($row2 = mysqli_fetch_array($rs))
			{
				if($keys == '')
				{
					$keys .= $row2['key_id'];
				}
				else
				{
					$keys .= ' X ' . $row2['key_id'];
				}
			}
			echo $keys;
			echo '</td>';
			echo '</tr>';
		}
	echo '</table>'
?>
</div>
</body>
<center>
<ul class = "pagination">
<?php
	mysqli_close($dbc);
	
	if($pages > 1) //Set up pages if necessary
	{
		$link = 'search_by_door.php?sort=' . $sort . '&p=' . $pages . '&b=' . $bld . '&doorNum=' . $door_num;
		echo paginate($pages, $start, $display, $link);
	}
	include ('includes/footer.html');
?>
</ul>
</center>