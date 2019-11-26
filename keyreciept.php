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


	require ('includes/mysqli_connect.php');

	$id[] = $_GET['id'];

	$txt= "70 Campbell Drive- MA 106 \nHighland Heights KY, 41017 \nPhone:859.572.5660 \nFax:859.572.6083 \nEmail: workcontroloffice@nku.edu";
	$txt1="Note:It is unlawful to duplicate University keys without the written permission of the University. All University issued key(s) and tag(s) are property of the University and should be returned to Operations and Maintenance Key Control upon separation from the Unuversity. There is a fee for each key not returned. Schedule of fees available from Operations and Maintenace Key Control Office";
	$query = "SELECT * FROM key_database WHERE dataid = $id";
	$result = @mysqli_query($dbc, $query);
	//$row = mysqli_fetch_array($result);


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf-> Image('images/nkulogo.png',125,12,70,0);
$pdf->MultiCell( 75, 5, $txt,'L,B,T,R', 'L',0);
$pdf-> SetFont("Arial","B",16);
//$txt2 = "Operations and Maintenance Key ";


$pdf->Cell( 200, 17, "Key Assignment Agreement", 0, 0,"C");

$counter = 0;
if (empty($id)){
	$pdf-> Ln(20);
	$pdf->Cell(50,5,"Select a key.",0,0,'L',0);
}
foreach ($id as $val){
	//$pdf->Ln(10);
	$pdf->SetFont('Arial','',12);

	$query = "SELECT * FROM key_database WHERE dataid = $val";
	$result = @mysqli_query($dbc, $query);

	while($row = $result->fetch_assoc()) {
		$idlink= $row["idlink"];
		$sql = "SELECT * FROM department WHERE idlink = $idlink";
		$res = mysqli_query($dbc, $sql);
		$row2 = mysqli_fetch_assoc($res);

		$pdf->SetFont('Arial','',12);
		$enum = $row['employeenum'];
		//Employee Info
		if ($counter==0){// only prints out the headings once
		$pdf-> Ln(12);
		$x = $pdf -> GetX();
		$y = $pdf -> GetY();
		$pdf->Multicell(120,5,"\nKey Holder: ".$row["lastname"]. " , ".$row['firstname']."\n ",'L,T','L',0);
		$pdf-> SetXY($x+120,$y);
		$pdf->Multicell(70,5,"\nTag # ".$row["tag"]."\n ",'R,T','L',0);
		$pdf-> SetXY($x,$y+15);
		$pdf->Multicell(50,5,"Employee #: " . $row["employeenum"]."\n ",'L','L',0);
		$pdf-> SetXY($x+120,$y+15);
		$pdf->Multicell(70,5,"ISO: " . $row['iso']."\n ",'R','L',0);

		$pdf-> SetXY($x,$y+25);
		$pdf->Multicell(120,5,"Department: " . $row['department']."\n ",'L','L',0);
		$pdf-> SetXY($x+120,$y+25);
		/*$pdf->Multicell(70,5,"Cost Center: ".$row["costcenter"]."\n ",'R','L',0);*/

		$pdf-> SetXY($x,$y+35);
		$pdf->Multicell(120,5,"Dept. Building: " . $row2["empbld"]."\n ",'L, B','L',0);
		$pdf-> SetXY($x+120,$y+35);
		$pdf->Multicell(70,5,"Room #: " . $row2['emprm']."\n ",'R, B','L',0);

		//th
		$pdf-> Ln(1);
		$pdf->Cell(40,5,'Key',0,0,'L',0);
		$pdf->Cell(50,5,'Series #',0,0,'L',0);
		$pdf->Cell(50,5,'Key Room',0,0,'L',0);
		$pdf->Cell(50,5,'Key Building',0,0,'L',0);
		$pdf-> Ln(2);
		$y = $pdf -> GetY();
		$pdf -> Line ($x,$y+5, $x+190, $y+5 );

		$pdf->Ln(3);

		}
		$pdf->Ln(3);

		//td
		if($counter % 2 == 0){

			$pdf->Cell(40,5,"\t".$row["keyname"],0,0,'L',0);
			$pdf->Cell(50,5,"\t#".$row["series"],0,0,'L',0);
			$pdf->Cell(50,5,"\t".$row["keyrm"],0,0,'L',0);
			$pdf->MultiCell(50,5,"\t".$row["keybld"],0,'L',0);

		}
		else{
			$pdf -> SetFillColor(227, 228,229);
			$pdf->Cell(40,10,"\t".$row["keyname"],0,0,'L','true');
			$pdf->Cell(50,10,"\t#".$row["series"],0,0,'L','true');
			$pdf->Cell(50,10,"\t".$row["keyrm"],0,0,'L','true');
			$h0 = $pdf ->GetY();
			$x0 = $pdf ->GetX();
			$pdf->MultiCell(50,5,"\t".$row["keybld"],0,'L','true');
			$h1 = $pdf ->GetY();
			$height = $h1 - $h0;
			if($height == 5) {
				$pdf -> SetXY($x0,$h1);
				$pdf->MultiCell(50,5," ",0,'L','true');
			}else{

			}
		}


		$counter++;
	}

}

if ($counter <=3){
$pdf->MultiCell( 200, 80,"", 0);
}
else{
$pdf->Ln(10);
}

$xa = $pdf -> GetX();
$ya = $pdf -> GetY();
$pdf -> Rect($xa, $ya, 190,55);
$pdf -> Cell(10, 5,"Key Control:",0);
$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(190,5,"NKU issued keys must stay attached to the key tag they were assigned to.",0,0,'L');

$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(190,5,"Replacement Change keys and tags cost $10.",0,0,'L');

$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(190,5,"Replacement Sub-master and Master keys  cost $50.",0,0,'L');

$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(190,5,"No NKU key may ever be copied.",0,0,'L');

$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(190,5,"Lending out NKU issued keys is strictly prohibited.",0,0,'L');


$pdf -> Ln(5);
$pdf -> SetFont('ZapfDingbats', '', 10);
$pdf -> SetX(20);
$pdf -> Cell(10, 5,4,0);
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(170,5,"Tags and all assigned keys must be returned when an employee separates from their department.",0,0,'L');


$pdf -> Ln(10);

$sign = "Signing this form indicates you agree to the reciept & custodianship of the keys listed here and to abide by the key control protocols outlined above.";
$pdf -> MultiCell(170, 5,"$sign", 0);
$pdf->Cell( 190, 5, "Signature____________________ Date:____________           "."\n\n", 0, 0,"R");


ob_end_clean(); //if Fatal error: Uncaught exception 'Exception' with message 'FPDF error: Some data has already been output, can't send PDF file'
$pdf->Output();
?>
