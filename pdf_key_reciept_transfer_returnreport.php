
<?php
//This page prints to a pdf or excel file of a bulk selection using the check boxes from the key databse
// the idividual reciepts from key-details are printed from the individual pages (keyreciept.php, key_return_report.php, key_transfer_reciept.php)
session_start(); // Start the session.
require('includes/fpdf181/fpdf.php');
require('includes/PHPExcel-1.8/Classes/PHPExcel.php');

require ('includes/mysqli_connect.php');

	$print = false;
	$return = false;
	$excel = false;
	$transfer = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$id = $_POST['checklist'];
}
else{
	$id = $_GET['id'];
	$type = $_GET['w'];
	switch ($type){
		case p: $print = true;
		break;
		case r: $return = true;
		break;
		case e: $excel = true;
		break;
		case t: $transfer = true;
	}
}
if (!isset($_POST['submit-checked-excel']) && $excel==false){
$formtype=$_SESSION['button'];
$txt= "70 Campbell Drive- MA 106 \nHighland Heights KY, 41017 \nPhone:859.572.5660 \nFax:859.572.6083 \nEmail: workcontroloffice@nku.edu";
$txt1="Note:It is unlawful to duplicate University keys without the written permission of the University. All University issued key(s) and tag(s) are property of the University and should be returned to Operations and Maintenance Key Control upon separation from the Unuversity. There is a fee for each key not returned. Schedule of fees available from Operations and Maintenance Key Control Office";
$pdf = new FPDF();

//Key reciept ========================================================================================================
 if (isset($_POST["submit-checked"])|| $print){
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
		
		$lname .= $row["lastname"];
		$fname .= $row["firstname"];
		
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
		$pdf->Multicell(70,5,"\n ",'R','L',0);

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


 }


 //key transfer =============================================================================================
  if (isset($_POST["submit-checked-transfer"]) || $transfer){
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf-> Image('images/nkulogo.png',125,12,70,0);
$pdf->MultiCell( 75, 5, $txt, 0);
$pdf-> SetFont("Arial","B",16);
//$txt2 = "Operations and Maintenance Key ";

	$txt2="Transfer Reciept";

$pdf->Cell( 200, 17, "Operations and Maintenance Key ".$txt2, 0, 0,"C");

$counter=0;
if (empty($id)){
	$pdf-> Ln(20);
	$pdf->Cell(50,5,"Select a key.",0,0,'L',0);
}
foreach ($id as $val){
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',12);

	$query = "SELECT * FROM key_database WHERE dataid = $val";
	$result = @mysqli_query($dbc, $query);

	while($row = $result->fetch_assoc()) {
		$pdf->SetFont('Arial','',12);
		$enum = $row['employeenum'];
		//Employee Info
		if ($counter==0){// only prints out the headings once
		$pdf-> Ln(20);
		$pdf->Cell(120,5,$row["lastname"]. " , ".$row['firstname'],0,0,'L',0);
		$pdf->Cell(30,5,"Tag # ".$row["tag"],0,0,'L',0);

		$pdf->Ln(10);
		$pdf->Cell(50,5,"Employee #: " . $row["employeenum"],0,0,'L',0);
		$pdf->Cell(70,5,$row['department'],0,0,'L',0);

		$pdf->Ln(10);
		$pdf->Cell(50,5,"Dept. Building: " . $row["empbld"],0,0,'L',0);
		$pdf->Cell(70,5,"Room #: " . $row['emprm'],0,0,'L',0);

		//th
		$pdf-> Ln(15);
		$pdf->Cell(40,5,'Key',0,0,'L',0);
		$pdf->Cell(50,5,'Series #',0,0,'L',0);
		$pdf->Cell(50,5,'Key Room',0,0,'L',0);
		$pdf->Cell(50,5,'Key Building',0,0,'L',0);

		$pdf->Ln(5);

		}
		//td
		$pdf->Ln(5);
		$pdf->Cell(40,5,"\t".$row["keyname"],0,0,'L',0);
		$pdf->Cell(50,5,"\t#".$row["series"],0,0,'L',0);
		$pdf->Cell(50,5,"\t".$row["keyrm"],0,0,'L',0);
		$pdf->MultiCell(50,5,"\t".$row["keybld"],0,'L');
		$counter++;
	}

}
if ($counter <=2){
$pdf->MultiCell( 200, 110,"", 0);
}
else if ($counter>2&& $counter<=6){
$pdf->MultiCell( 200, 70,"", 0);
}
else{
$pdf->MultiCell( 200, 70,"", 0);
}
$pdf->Cell( 200, 17, ""."Signature____________________ Date:____________           "."\n\n", 0, 0,"R");
$pdf->MultiCell( 200, 5,"$txt1", 0);
$pdf->MultiCell( 185, 5,"$txt1", "");
 }



 //Key Return report ======================================================================================================
  if (isset($_POST["submit-checked-report"])|| $return){
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
		$pdf->Cell(20,5,"Employee #: " ,'B',0,'L',0);
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
		$z = $pdf -> GetPageHeight();

		if($counter % 2 == 0){
			$pdf -> SetFillColor(227,228,229);
			$pdf->Cell(20,10,$row["employeenum"],0,0,'L','true');
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
			$pdf->Cell(20,10,$row["employeenum"],0,0,'L',0);
			$pdf->Cell(20,10,$row["tag"],0,0,'L',0);
			$pdf->Cell(20,10,$row["keyname"],0,0,'L',0);
			$pdf->Cell(20,10,$row["series"],0,0,'L',0);
			$pdf->Cell(40,10,$row["disposition"],0,0,'L',0);
			$pdf->Cell(30,10,$row["issuedate"],0,0,'L',0);
			$pdf->Cell(30,10,$row["dispositiondate"],0,0,'L',0);
			$pdf->Cell(50,10,$row["keyrm"],0,0,'L',0);
			$pdf->MultiCell(40,5,$row["keybld"],0,'L');
		}
		if($y+10 > 180){
			$pdf->AddPage("L");
			$y = 0;
		}
		$pdf -> SetXY($x,$y+10);
		$counter++;
    }
}
  }
ob_end_clean(); //if Fatal error: Uncaught exception 'Exception' with message 'FPDF error: Some data has already been output, can't send PDF file'
$pdf->output('I', ''. $lname . ',' . $fname .'_' . date("m-d-Y") . '.pdf');


}
else
{
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('Keys');

	$styleArray = array(
		'font' => array(
			'bold'=> true,
			'size' => 12,
			'name' => 'Times New Roman'
		)
	);

	$objPHPExcel->getActiveSheet()->setCellValue('A1','Status');

	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

	$objPHPExcel->getActiveSheet()->setCellValue('B1','Last Name');
	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('C1','First Name');
	$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('D1','Employee Number');
	$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('E1','iso');
	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('F1','Department');
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('G1','Cost Center');
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('H1','Employee Building');
	$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('I1','Employee Room');
	$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('J1','Tag Number');
	$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('K1','Key');
	$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('L1','Series #');
	$objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('M1','Key Building');
	$objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('N1','Key Room');
	$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('O1','Disposition');
	$objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('P1','Disposition Date');
	$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('Q1','Reciept Date');
	$objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->setCellValue('R1','Issue Date');
	$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($styleArray);

//	$id = $_POST['checklist'];
	$r=2;
	foreach ($id as $val){

	$query = "SELECT * FROM key_database WHERE dataid = $val";
	$result = @mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_assoc($result)){

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$r,$row["status"]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$r,$row["lastname"]);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$r,$row["firstname"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$r,$row["employeenum"]);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$r,$row["iso"]);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$r,$row['department']);
	/*$objPHPExcel->getActiveSheet()->setCellValue('G'.$r,$row["costcenter"]);*/
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$r,$row["empbld"]);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$r,$row["emprm"]);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$r,$row["tag"]);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$r,$row["keyname"]);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$r,$row["series"]);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$r,$row["keybld"]);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$r,$row["keyrm"]);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$r,$row["disposition"]);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$r,$row["dispositiondate"]);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$r,$row["receiptdate"]);
	$objPHPExcel->getActiveSheet()->setCellValue('R'.$r,$row["issuedate"]);
		}
	$r++;
	}

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="KeyDatabase.xlsx"');
	header('Cache-Control: max-age = 0');
	ob_end_clean();
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');


}
?>
