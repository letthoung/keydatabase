<?php
	session_start(); // Start the session.

	// If no session value is present, redirect the user:
	// Also validate the HTTP_USER_AGENT!
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) ))
	{
		require ('includes/login_functions.inc.php');
		redirect_user('index.php');
	}
	require("includes/mysqli_connect.php");

if(isset($_GET['name'])){
  $name = $_GET['name'];
	//echo $name;
  $arr = explode(" ", $name);

	$firstarr = array();
	for ($i = 0; $i<= count($arr)-2; $i++){
		$firstarr[]= $arr[$i];
	}
	$firstname = join(" ", $firstarr);
  $lastname = $arr[count($arr)-1];
	if($arr[0]=='Master'&& $arr[1]=='Ring'){
		$firstname = 'Master Ring';
		$lastarr = array();
		for ($j = 2; $j<count($arr); $j++){
			$lastarr[] = $arr[$j];
		}
		$lastname = join(" ", $lastarr);
	}
	$lastname = addslashes($lastname);
	$firstname = addslashes($firstname);

	if(isset($_GET['s'])){
		$series = array();
		$bld = array();
		$room = array();
		$key = array();
		$tag = array();
		 if($_GET['s']==1){
			 //$result = mysqli_query($dbc, "SELECT * FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname'");

			 // while ($row = mysqli_fetch_array($result)){
				//  		$series[] = $row['series'];
			 // 	}
			//$jsonSeries = json_encode($series);
		/*	$sql = "SELECT DISTINCT keybld FROM key_database WHERE series IN (SELECT series FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname') AND lastname = '$lastname' AND firstname = '$firstname'";
			$rs1 = mysqli_query($dbc, $sql);
			while($row = mysqli_fetch_array($rs1)){
				if($row['keybld'] != ''){
					$bld[] = $row['keybld'];
				}
			}
			//$jsonBld = json_encode($bld);

			$sql2 = "SELECT DISTINCT keyrm FROM key_database WHERE series IN (SELECT series FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname') AND lastname = '$lastname' AND firstname = '$firstname'";
			$rs2 = mysqli_query($dbc, $sql2);
			while($row = mysqli_fetch_array($rs2)){
				if($row['keyrm'] != ''){
					$room[] = $row['keyrm'];
				}
			}*/
			//$jsonRoom = json_encode($room);
//			$sql3 = "SELECT DISTINCT keyname FROM key_database WHERE series IN (SELECT series FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname') AND lastname = '$lastname' AND firstname = '$firstname' AND disposition = 'Assigned'";

			$sql3 = "SELECT DISTINCT tag FROM key_database WHERE series IN (SELECT series FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname') AND lastname = '$lastname' AND firstname = '$firstname' AND (disposition = 'Assigned' OR disposition = 'No Receipt')";
			//echo $sql3;
			$rs3 = mysqli_query($dbc, $sql3);
			while($row = mysqli_fetch_array($rs3)){

					$tag[] = $row['tag'];

			}
			// while($row = mysqli_fetch_array($rs3)){
			// 	if($row['keyname'] != ''){
			// 		$key[] = $row['keyname'];
			// 	}
			// }

			//echo $jsonRoom;
			//echo $jsonBld;
			//echo $jsonSeries;

			$general = array();
			$general["tag"] = $tag;
			//$general["series"] = $series;
		//	$general["bld"] = $bld;
		//	$general["room"] = $room;
			$jsonArr = json_encode($general);
			echo $jsonArr;
			//echo $sql3;
		 }

		 else{
			 $jsonArr = array();
       $result = mysqli_query($dbc, "SELECT * FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' ORDER BY dataid DESC");
			 $row = mysqli_fetch_array($result);
			 $emp = $row['employeenum'];
			 $jsonArr["empnum"] = $row['employeenum'];
			 $jsonArr["group"] = $row['status'];
			 $idlink = $row["idlink"];
			 //echo "SELECT dep FROM department WHERE costcenter = '$cc'";
			 $r2 = mysqli_query($dbc, "SELECT dep FROM department WHERE idlink = '$idlink'");
			 $row2 = mysqli_fetch_array($r2);
			 $jsonArr["department"] = $row2['dep'];

			 $res1 = mysqli_query($dbc,"SELECT DISTINCT tag FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' ORDER BY dataid DESC ");
			 if(mysqli_num_rows($res1)>1){
				 $tagarr = array();
				 while ($r1 = mysqli_fetch_assoc($res1)){
					 $tagarr[] = $r1['tag'];
				 }
				 $jsonArr['tag'] = $tagarr;
			 }
			 else if(mysqli_num_rows($res1)==1){
				 $jsonArr['tag']=$row['tag'];
			 }


			 $jsonArr= json_encode($jsonArr);
			 echo $jsonArr;

     }
   }
}
else if(isset($_GET['series'])){
	$key= $_GET['key'];
	$firstname = $_GET['fname'];
	$lastname = $_GET['lname'];
	$series = $_GET['series'];
if ($series == "No Series"){
	$sql = "SELECT keybld, keyrm FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' AND keyname = '$key' AND series = ''";
	$sql12 = "SELECT tag FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' AND keyname = '$key' AND series = ''";
	$rs12 = mysqli_query($dbc, $sql12);
	$tags = array();
	while ($r12 = mysqli_fetch_assoc($rs12)){
		$tags[] = $r12['tag'];
	}
}else{
	$sql = "SELECT keybld, keyrm FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' AND keyname = '$key' AND series = '$series'";
	$sql12 = "SELECT tag FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' AND keyname = '$key' AND series = '$series'";
	$rs12 = mysqli_query($dbc, $sql12);
	$tags = array();
	while ($r12 = mysqli_fetch_assoc($rs12)){
		$tags[] = $r12['tag'];
	}
	}
	$result = mysqli_query($dbc,$sql);
	$row = mysqli_fetch_assoc($result);
	$arr = [$row["keybld"], $row["keyrm"], $tags];
	echo json_encode($arr);
}
else if (isset($_GET['key'])){
	$key= $_GET['key'];
	$firstname = $_GET['fname'];
	$lastname = $_GET['lname'];
	$sql = "SELECT series FROM key_database WHERE lastname = '$lastname' AND firstname = '$firstname' AND keyname = '$key' AND (disposition = 'Assigned' OR disposition = 'No Receipt')";
	$rs = mysqli_query ($dbc, $sql);
	$arr = [];
	while ($row = mysqli_fetch_assoc($rs)){
		$arr [] = $row['series'];
	}
	echo json_encode($arr);
}else if (isset ($_GET['tag'])){
		$tag = $_GET['tag'];
		$firstname = $_GET['fname'];
		$lastname = $_GET['lname'];
		$sql= "SELECT DISTINCT keyname FROM key_database WHERE tag = '$tag' AND lastname = '$lastname' AND firstname = '$firstname' AND (disposition = 'Assigned' OR disposition = 'No Receipt')";
		$rs = mysqli_query ($dbc, $sql);
		$arr = [];
		while ($row = mysqli_fetch_assoc($rs)){
			$arr [] = $row['keyname'];
		}
		echo json_encode($arr);
}

  ?>
