<?php 
require('includes/fpdf181/fpdf.php'); 
session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) ) 
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	//This page will be used to edit exterior light records. If the user is of a sufficient admin level it makes the changes to the exterior_lights table.
	//If they are not it submits the edits to be made so that an admin can look at them and either accept or deny them.
	
	require ('includes/mysqli_connect.php');
	
	$id = $_GET['id'];	
	$txt= "70 Campbell Drive- MA 106 \nHighland Heights KY, 41017 \nPhone:859.572.5660 \nFax:859.572.6083 \nEmail: workcontroloffice@nku.edu";
	$txt1="Note:It is unlawful to duplicate University keys without the written permission of the University. All University issued key(s) and tag(s) are property of the University and should be returned to Operations and Maintenance Key Control upon separation from the Unuversity. There is a fee for each key not returned. Schedule of fees available from Operations and Maintenace Key Control Office";
	$query = "SELECT * FROM key_database WHERE dataid = $id";
	$result = @mysqli_query($dbc, $query);
	//$row = mysqli_fetch_array($result);
	

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf-> Image('images/nkulogo.png',125,12,70,0);
$pdf->MultiCell( 75, 5, $txt, 0);
$pdf-> SetFont("Arial","B",16);
$pdf->Cell( 200, 17, "Operations and Maintenance Key Transfer Receipt"."\n\n", 0, 0,"C");
if ($result->num_rows > 0) {
    
    $row_cnt = $result->num_rows;

    while($row = $result->fetch_assoc()) {
		$pdf->SetFont('Arial','',12);
		
		//Employee Info
		$pdf-> Ln(20);
		$pdf->Cell(120,5,$row['lastname']. " , ".$row['firstname'],0,0,'L',0);
		$pdf->Cell(30,5,"Tag # ".$row["tag"],0,0,'L',0);
		
		$pdf->Ln(10);
		$pdf->Cell(50,5,"Employee #: " . $row["employeenum"],0,0,'L',0);
		$pdf->Cell(70,5,$row['department'],0,0,'L',0);
		
		//th
		$pdf-> Ln(15);
		$pdf->Cell(40,5,'Key',0,0,'L',0);
		$pdf->Cell(50,5,'Series #',0,0,'L',0);
		$pdf->Cell(50,5,'Key Room',0,0,'L',0);
		$pdf->Cell(50,5,'Key Building',0,0,'L',0);
		
		//td
		$pdf->Ln(10);
		$pdf->Cell(40,5,"\t".$row["keyname"],0,0,'L',0);
		$pdf->Cell(50,5,"\t#".$row["series"],0,0,'L',0);
		$pdf->Cell(50,5,"\t".$row["keyrm"],0,0,'L',0);
		$pdf->MultiCell(50,5,"\t".$row["keybld"],0,'L');
		
    } 
}
$pdf->MultiCell( 200, 130,"", 0);
$pdf->Cell( 200, 17, ""."Signature____________________ Date:____________           "."\n\n", 0, 0,"R");
$pdf->MultiCell( 200, 5,"$txt1", 0);
$pdf->MultiCell( 185, 5,"$txt1", "");
ob_end_clean(); //if Fatal error: Uncaught exception 'Exception' with message 'FPDF error: Some data has already been output, can't send PDF file'
$pdf->Output();
?>