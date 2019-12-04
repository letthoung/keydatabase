<?php

session_start(); // Start the session.

// If no session value is present, redirect the user
// Also validate the HTTP_USER_AGENT!

require("includes/mysqli_connect.php");
//require ('includes/login_functions.inc.php');
//$page_title = 'Department Audit';
//include ('includes/header.html');


require('includes/PHPExcel-1.8/Classes/PHPExcel.php');
?>
<?php

    $idlink = $_GET['c'];
    $sql    = "SELECT * FROM key_database WHERE idlink = $idlink AND (disposition = 'Assigned' OR disposition = 'No Receipt' OR disposition = 'Processing') ORDER BY disposition, issuedate DESC";
    $result = mysqli_query($dbc, $sql);
    if (!$result){
        die("QUERY FAILED! " . mysqli_error($dbc));
    }
    
    // Query to get he department name for the idlink
    $query = "SELECT * from department WHERE idlink = $idlink";
    $get_department_query = mysqli_query($dbc,$query);
    $row0 = mysqli_fetch_assoc($get_department_query);
    $department = $row0['dep'];

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Keys');

    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        )
    );
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Status');

    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Last Name');
    $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'First Name');
    $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Employee Number');
    $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
    //$objPHPExcel->getActiveSheet()->setCellValue('E1', 'iso');
    //$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Department');
    $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
    /*$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Cost Center');*/
    $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
    //$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Employee Building');
    //$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
    //$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Employee Room');
    //$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Tag Number');
    $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Key');
    $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Series #');
    $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Key Building');
    $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Key Room');
    $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Disposition');
    $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Disposition Date');
    $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);


    
    $r=2;
    $filename='';
     while ($row = mysqli_fetch_assoc($result)) {
        $filename = $department . ".xlsx";
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $r, $row["status"]);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $r, $row["lastname"]);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $r, $row["firstname"]);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $r, $row["employeenum"]);

        $objPHPExcel->getActiveSheet()->setCellValue('E' . $r, $department);
        /*$objPHPExcel->getActiveSheet()->setCellValue('F' . $r, $row["costcenter"]);*/

        $objPHPExcel->getActiveSheet()->setCellValue('G' . $r, $row["tag"]);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $r, $row["keyname"]);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $r, $row["series"]);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $r, $row["keybld"]);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $r, $row["keyrm"]);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $r, $row["disposition"]);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $r, $row["dispositiondate"]);

        $r++;
     }
    //
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename= $filename");
    header('Cache-Control: max-age = 0');

    ob_end_clean();
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
//}
?>
