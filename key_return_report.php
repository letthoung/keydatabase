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
	
	$id[] = $_GET['id'];	
	$query = "SELECT * FROM key_database WHERE dataid = $id";
	$result = @mysqli_query($dbc, $query);
	//$row = mysqli_fetch_array($result);
	

$pdf = new FPDF();
	$pdf->AddPage("L");
	$pdf->SetFont('Arial','',12);
	$pdf-> Image('images/nkulogo.png',225,12,70,0);
	$pdf->MultiCell( 75, 5, '', 0);
	$pdf-> SetFont("Times",'B',18);
	$pdf -> SetTextColor(105,105,105);
	$pdf->Cell( 50, 17, "Key Return Report", 0, 0,"C");
	$pdf -> SetTextColor(0);
 $counter=0;
if (empty($id)){
	$pdf-> Ln(20);
	$pdf->Cell(50,5,"Select a key.",0,0,'L',0);
}
foreach ($id as $val){
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',12);

	$query = "SELECT * FROM key_database WHERE dataid = $val";
	$result = @mysqli_query($dbc, $query);

  while($row = $result->fetch_assoc()) {


        $pdf->SetFont('Arial','',10);
		$line1 = "\n\n"."" . $row["lastname"]. " , ".$row['firstname']."                             Tag # ". $row["tag"]."\n\n";
		$line2= "Employee #: " . $row["employeenum"]. "              ".$row['department']."\n\n";

		//Employee Info
		if ($counter == 0){
		$pdf-> Ln(20);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(120,5,$row["lastname"]. " , ".$row['firstname'],0,0,'L',0);
		$pdf->SetFont('Arial','',14);
		$pdf-> Ln(10);
		$pdf->Cell(120,5,"".$row["department"],0,0,'L',0);
		$pdf-> Ln(10);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,5,"Employee #: " ,'B',0,'L',0);
		$pdf->Cell(20,5,"Tag # ",'B',0,'L',0);
		$pdf->Cell(20,5,'Key','B',0,'L',0);
		$pdf->Cell(20,5,'Series #','B',0,'L',0);
		$pdf->Cell(40,5,'Key Disposition','B',0,'L',0);
		$pdf->Cell(30,5,'Issue date','B',0,'L',0);
		$pdf->Cell(30,5,'Disposition Date','B',0,'L',0);
		$pdf->Cell(50,5,'Key Room','B',0,'L',0);
		$pdf->Cell(40,5,'Key Building','B',0,'L',0);

		$pdf-> Ln(5.5);
  }
		//td
		$x = $pdf -> GetX();
		$y = $pdf -> GetY();


		if($counter % 2 == 0){
			$pdf -> SetFillColor(227,228,229);
			$pdf->Cell(30,10,$row["employeenum"],0,0,'L','true');
			$pdf->Cell(20,10,$row["tag"],0,0,'L','true');
			$pdf->Cell(20,10,$row["keyname"],0,0,'L','true');
			$pdf->Cell(20,10,$row["series"],0,0,'L','true');
			$pdf->Cell(40,10,$row["disposition"],0,0,'L','true');
			$pdf->Cell(30,10,$row["issuedate"],0,0,'L','true');
			$pdf->Cell(30,10,$row["dispositiondate"],0,0,'L','true');
			$pdf->Cell(50,10,$row["keyrm"],0,0,'L','true');

			$h0 = $pdf ->GetY();
			$x0 = $pdf ->GetX();
			$pdf->MultiCell(40,5,$row["keybld"],0,'L','true');
			$h1 = $pdf ->GetY();
			$height = $h1 - $h0;
			if($height == 5) {
				$pdf -> SetXY($x0,$h1);
				$pdf->MultiCell(40,5," ",0,'L','true');
			}else{

			}
		}
		else{
			$pdf->Cell(30,10,$row["employeenum"],0,0,'L',0);
			$pdf->Cell(20,10,$row["tag"],0,0,'L',0);
			$pdf->Cell(20,10,$row["keyname"],0,0,'L',0);
			$pdf->Cell(20,10,$row["series"],0,0,'L',0);
			$pdf->Cell(40,10,$row["disposition"],0,0,'L',0);
			$pdf->Cell(30,10,$row["issuedate"],0,0,'L',0);
			$pdf->Cell(30,10,$row["dispositiondate"],0,0,'L',0);
			$pdf->Cell(50,10,$row["keyrm"],0,0,'L',0);
			$pdf->MultiCell(40,5,$row["keybld"],0,'L');
		}

		$pdf -> SetXY($x,$y+10);
		$counter++;
    }
}
ob_end_clean(); //if Fatal error: Uncaught exception 'Exception' with message 'FPDF error: Some data has already been output, can't send PDF file'
$pdf->Output();
?>