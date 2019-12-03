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
	

	$id = $_GET['structureid'];
	if ($id != ''){
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle('Fields');
	
	
		
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A1','Common Fields');
	cellColor('A1', 'fce15d');
	$objPHPExcel->getActiveSheet()->setCellValue('A2','Building');
	$objPHPExcel->getActiveSheet()->setCellValue('A3','Floor');
	$objPHPExcel->getActiveSheet()->setCellValue('A4','Room');
	$objPHPExcel->getActiveSheet()->setCellValue('A5','Device Name');
	$objPHPExcel->getActiveSheet()->setCellValue('A6','Manufacturer');
	$objPHPExcel->getActiveSheet()->setCellValue('A7','Model');
	$objPHPExcel->getActiveSheet()->setCellValue('A8','Serial');
	$objPHPExcel->getActiveSheet()->setCellValue('A9','Attached to');
	$objPHPExcel->getActiveSheet()->setCellValue('A10','Installed Date');
	$objPHPExcel->getActiveSheet()->setCellValue('A11','Description');
	
	$objPHPExcel->getActiveSheet()->setCellValue('A12','O&M Manual');
	$objPHPExcel->getActiveSheet()->setCellValue('A13','Asset Location');
	$objPHPExcel->getActiveSheet()->setCellValue('A14','Manu link');
	$objPHPExcel->getActiveSheet()->setCellValue('A15','Spare Link');
	$objPHPExcel->getActiveSheet()->setCellValue('A16','Compliance');
	$objPHPExcel->getActiveSheet()->setCellValue('A17','EHS');
	$objPHPExcel->getActiveSheet()->setCellValue('A18','Warranty Exp. Date');
	$objPHPExcel->getActiveSheet()->setCellValue('A19','Last Update YYYY/MM/DD');
	

	$id = $_GET['structureid'];
	$query = "SELECT field_name FROM fgen_fields WHERE fgen_structure_id = $id";
	$result = @mysqli_query($dbc, $query);
	$arr = [];
	while ($row = mysqli_fetch_array($result)){
		$arr[] = $row['field_name'];
	}
	$s = 22;
	$objPHPExcel->getActiveSheet()->setCellValue('A20',"  ");
    $objPHPExcel->getActiveSheet()->setCellValue('A21',"UNIQUE FIELDS");
	cellColor('A21', 'fce15d');
	$objPHPExcel->getActiveSheet()->setCellValue('A22',"  ");
	$r = 0;

	
	for ($r = 0; $r < mysqli_num_rows($result); $r++){
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$s,$arr[$r]);	
	$s++;
	}
			
	$query2 = "Select device_type_name From fgen_structures WHERE fgen_structure_id = '".$id."'";
	$result2 = mysqli_query($dbc, $query2);
	$row2 = mysqli_fetch_assoc($result2);

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$row2['device_type_name'].'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	}	
	?>