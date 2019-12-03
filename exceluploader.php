<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
</head>
<br>

<?php 
require('includes/PHPExcel-1.8/Classes/PHPExcel.php'); 
require ('includes/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) 
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}

	
	require ('includes/mysqli_connect.php');
	$id = $_GET['id'];
	$output ='';
	if (isset($_POST['submit'])){
	$extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
	$allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
	if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
	{
	$file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
	$objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
	$output .= "<label class='text-success'><h2>Records Changed</h2></label><br /><table class='table table-bordered'>";
   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	{
		
		// update common fields
	for ($r = 1; $r<=19; $r++){
	$output .= "<tr>";
	$field =  mysqli_real_escape_string($dbc, $worksheet->getCellByColumnAndRow(0, $r)->getValue());
	$value = mysqli_real_escape_string($dbc, $worksheet->getCellByColumnAndRow(1, $r)->getValue());

// building 
    if ($value != '' && $r == 2){
	
		$query1 = "UPDATE tblAssets SET Building = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//floor
    if ($value != '' && $r == 3){
	
		$query1 = "UPDATE tblAssets SET Floor = '$value' WHERE UniqueId ='$id'";
        
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//room
    if ($value != '' && $r == 4){
	
		$query1 = "UPDATE tblAssets SET Room = '$value' WHERE UniqueId ='$id'";
        
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//device name
    if ($value != '' && $r == 5){
	
		$query1 = "UPDATE tblAssets SET DeviceName = '$value' WHERE UniqueId ='$id'";
        
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
// manufacturer
    if ($value != '' && $r == 6){
	
		$query1 = "UPDATE tblAssets SET Manufacturer = '$value' WHERE UniqueId ='$id'";
        
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//model
    if ($value != '' && $r == 7){
	
		$query1 = "UPDATE tblAssets SET Model = '$value' WHERE UniqueId ='$id'";
        
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//serial
    if ($value != '' && $r == 8){
	
		$query1 = "UPDATE tblAssets SET Serial = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	  $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//attached to 
	   if ($value != '' && $r == 9){
	
		$query1 = "UPDATE tblAssets SET Catalog = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//installdate
	   if ($value != '' && $r == 10){
	
		$query1 = "UPDATE tblAssets SET InstallDate = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
// description
	   if ($value != '' && $r == 11){
	
		$query1 = "UPDATE tblAssets SET Description = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//ommanual
	   if ($value != '' && $r == 12){
	
		$query1 = "UPDATE tblAssets SET OMManual = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//asset location
	   if ($value != '' && $r == 13){
	
		$query1 = "UPDATE tblAssets SET AssetLocation = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//manulink
	   if ($value != '' && $r == 14){
	
		$query1 = "UPDATE tblAssets SET ManufacturerLink = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//sparelink
	   if ($value != '' && $r == 15){
	
		$query1 = "UPDATE tblAssets SET SpareLink = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//compliance
	   if ($value != '' && $r == 16){
	
		$query1 = "UPDATE tblAssets SET acq = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//EHS
	   if ($value != '' && $r == 17){
	
		$query1 = "UPDATE tblAssets SET safety = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//warranty
	   if ($value != '' && $r == 18){
	
		$query1 = "UPDATE tblAssets SET  salvage = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}
//lastupdate
	   if ($value != '' && $r == 19){
	
		$query1 = "UPDATE tblAssets SET life = '$value' WHERE UniqueId ='$id'";
        mysqli_query($dbc, $query1);
        if (!mysqli_query($dbc, $query1)){
		echo "<h3 class='text-danger'>Error Updating record:".mysqli_error($dbc)." </h3>";
			}
	   $output .= '<td>'.$field.'</td>';
	  $output .= '<td>'.$value.'</td>';
	  $output .= '</tr>';
	}

	}
   		
		
		// update unique fields.
	$highestRow = $worksheet->getHighestRow();
	for($row= 22; $row<=$highestRow; $row++){
		$output .= "<tr>";
		$fieldname =  mysqli_real_escape_string($dbc, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$fieldvalue = mysqli_real_escape_string($dbc, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		if ($fieldvalue != ''){
	
       // $query = "UPDATE fgen_values SET field_value = '".$fieldvalue."' WHERE asset_id ='".$id."' AND fgen_field_id = '(SELECT fgen_field_id FROM fgen_fields WHERE field_name = ".$fieldname." LIMIT 1)'";
	
        // $query = "UPDATE fgen_values SET field_value = '$fieldvalue' FROM fgen_values INNER JOIN fgen_fields ON fgen_values.fgen_field_id = fgen_fields.fgen_field_id WHERE ";
        
        $query = "UPDATE fgen_values SET field_value = '$fieldvalue' WHERE asset_id ='$id' AND fgen_field_id IN (SELECT fgen_field_id FROM fgen_fields WHERE field_name = '$fieldname')";
        mysqli_query($dbc, $query);
        
        if (!mysqli_query($dbc, $query)){
		echo "<h3 class='text-danger'>Error Updating record: ".mysqli_error($dbc)." </h3>";
	}
	$output .= '<td>'.$fieldname.'</td>';
	$output .= '<td>'.$fieldvalue.'</td>';
	$output .= '</tr>';
	}	
}
			
	}
		$output .= '</table>';
}
		else 
		{
			$output .= '<label class="text-danger">Invalid File</label>'; //if non excel file
		}
}
else{
	echo '<h2>Not set!</h2>';
}
echo '<body>';
echo $output;
echo '</body>';
?>
</html>