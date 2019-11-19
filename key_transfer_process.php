<?php
session_start(); // Start the session.

// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
require ('includes/login_functions.inc.php');
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) ))
{
  redirect_user('index.php');
}

require ('includes/mysqli_connect.php');

	$page_title = 'Key Transfer process';
	include ('includes/header.html');

if (isset($_POST['transfer'])){
  $orignname = $_POST['orignname'];
  $o = explode(" ", $orignname);
  $firstarr = array();
  for ($i = 0; $i <= count($o)-2; $i++){
      $firstarr[] = $o[$i];
  }
  $olastname = $o[count($o)-1];
  $ofirstname = join(" ", $firstarr);
  if ($o[0]=="Master" && $o[1]== "Ring"){
    $ofirstname = 'Master Ring';
    $lastarr=[];
    for($i = 2; $i < count($o); $i++){
      $lastarr[]= $o[$i];
    }
    $olastname = join(" ", $lastarr);
  }

  $key = $_POST['keyname'];
  $series = $_POST['keyseries'];
  $bld = $_POST['keybld'];
  $keyrm = $_POST['keyrm'];
  $rfirstname = $_POST['firstname'];
  $rlastname = $_POST['lastname'];
  $empnum = $_POST['empnum'];
  $dep = $_POST['dep'];
  $tag = $_POST['tag'];
  $group = $_POST['campusgroup'];
  $disposition= 'No Receipt';
  $dispositiondate = date("Y-m-d");

  // escape special characters in names.
  $rlastname = addslashes($rlastname);
	$rfirstname = addslashes($rfirstname);
  $olastname = addslashes($olastname);
  $ofirstname = addslashes($ofirstname);

  $rs0 = mysqli_query($dbc, "SELECT costcenter From department where dep ='$dep'");

  $row = mysqli_fetch_array($rs0);
  $costcenter = $row['costcenter'];
  $issuedate = date('Y-m-d');
  if ($series ==  'No Series' || $series == 'Select Series'){
    $series = '';
  }

  $SQL = "INSERT INTO key_database (lastname, firstname, employeenum, disposition, dispositiondate, costcenter, tag,keyname,series,keybld,keyrm,issuedate,department,status)";
  $SQL .= "VALUES('$rlastname', '$rfirstname', '$empnum','$disposition','$dispositiondate','$costcenter','$tag','$key', '$series', '$bld', '$keyrm', '$issuedate','$dep','$group') ";


  $SQL2 = "UPDATE key_database SET disposition = 'Returned', dispositiondate = '$dispositiondate' WHERE lastname ='$olastname'AND firstname= '$ofirstname'AND keyname = '$key' AND series = '$series'";
  //echo $SQL2;
  // Records timestamp and user information
  $userfirstname = $_SESSION['first_name'];
  $userlastname = $_SESSION['last_name'];
  $userlastname = addslashes($userlastname);
  $userfirstname = addslashes($userfirstname);
  date_default_timezone_set("America/Kentucky/Louisville");
  $current_time =  date ('Y-m-d H:i:s');
  echo $current_time;
  $action = 'Key Transfer from '.$ofirstname.' '.$olastname.' to '.$rfirstname.' '.$rlastname;
  $timestamp_query = "INSERT INTO activity_timestamps(firstname, lastname, date, action) VALUES ('$userfirstname', '$userlastname', '$current_time', '$action')";
  mysqli_query($dbc, $timestamp_query);
    //date ('D M-d-Y H:i:s T')

  echo '<h1 style = "color: green">Transfer Complete</h1>';

  mysqli_query($dbc, $SQL);
  mysqli_query($dbc, $SQL2);

}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .myInput {
      border-box: box-sizing;
      background-image: url('images/search-icon.png');
      background-position: 14px 12px;
      background-repeat: no-repeat;
      font-size: 16px;
      padding: 14px 20px 12px 45px;
      border: none;
      border-bottom: 1px solid #ddd;
      width: 100%;
    }
  #origin a{
    color: black;
    padding; 12;
    text-decoration: none;
    display:block;
  }
  #origin a:hover{
    background-color: #ddd;
  }
  #recipient a{
    color: black;
    padding; 12;
    text-decoration: none;
    display:block;
  }
  #recipient a:hover{
    background-color: #ddd;
  }
  </style>
  </head>
  <body>
  <form class="" action="key_transfer_process.php" method="post">
   <a href = "keydatabase.php" class = "btn btn-primary" text-align = "left">Back</a>
    <h1>Key Transfer Process</h1>
<div class="row">
  <h3 class=" col-xs-6">From: </h3>
  <h3 class=" col-xs-6">To: </h3>

</div>
<div class="row">
      <div class="col-xs-6">
          <select class="search" name="orignname" id = 'osearch' onchange="ochange()">
            <option>Key Originator</option>
            <?php
              $sql = "SELECT DISTINCT firstname, lastname From key_database";
              echo '';
              $res = mysqli_query($dbc, $sql);
              while ($row = mysqli_fetch_array($res)){
                echo "<option  >".$row['firstname']." ".$row['lastname']."</option>";
              }
             ?>
           </select>
      </div>

      <div class="col-xs-6">
        <select class="search" name="" id = 'rsearch' onchange="rchange()">
          <option>Key Reciever</option>
          <?php
            $sql = "SELECT DISTINCT firstname, lastname From key_database";
            $res = mysqli_query($dbc, $sql);
            while ($row = mysqli_fetch_array($res)){
              echo "<option  >".$row['firstname']." ".$row['lastname']."</option>";
            }
           ?>
        </select>
      </div>
    </div>

<div class="row">



      <div class="col-xs-6" style = "margin-top: 10px">
        <select class="search" id = 'tag' name="tag" onchange="tagChange()" style = "width: 250px">
          <option value=" ">Select tag</option>
        </select>
      </div>
      <div class="col-xs-6" style = "margin-top: 10px">
        <label for="">Name</label><br>
        <input type="text"  id = "firstname" class ="col-xs-6 form-control" style = "width: 180px" name="firstname" value="" placeholder="Firstname">
        <input type="text"  id = "lastname" class ="col-xs-6 form-control" style = "width: 180px" name="lastname" value="" placeholder = "Lastname">
      </div>

</div>
<div class="row">
  <div class="col-xs-6" style = "margin-top: 10px">
    <select class="search" id = 'keysearch' name="keyname" onchange="kchange()" style = "width: 250px" >
      <option value=" ">Select Key</option>
    </select>
  </div>


      <div class="col-xs-6" style = "margin-top: 10px">
        <label for="">Employee #: </label><br>
        <input type="text" id = "empnum" class ="form-control" name="empnum" value="">
      </div>
      <div class="col-xs-6" style = "margin-top: 10px">
        <select class="search" id = 'keyseries' name="keyseries" onchange="schange()" style = "width: 250px">
          <option value=" ">Select Series</option>
        </select>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-6" style = "margin-top: 10px">
        <input class="" id = 'keybld' name="keybld" style = "display: none">

      </div>
      <div class="col-xs-6" style = "margin-top: 10px">
        <label for="">Department: </label><br>
<input type="text" id ="dep" class ="form-control" name="dep" placeholder="Department will show here" readonly value="">
        <select class="search" name="" id = "dsearch" onchange="dchange()">
          <option value="[object Object]"></option>
          <?php
            $rs = mysqli_query($dbc, "SELECT dep FROM department");
            while($row = mysqli_fetch_array($rs)){
              echo "<option id= '".$row['dep']."'>".$row['dep']."</option>";
            }
          ?>
        </select>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-6" style = "margin-top: 10px">
        <input class = "" id = 'keyrm' name="keyrm" style = "display: none">
      </div>
      <div class="col-xs-6" id = 'tagdiv' style = "margin-top: 10px">
        <label >Tag #: </label><br>
        <input type="text" id = "tag" class ="form-control" name="tag" value="">
      </div>

    </div>
    <div class="row">
      <div class="col-xs-6">

      </div>
      <div class="col-xs-6" style ="margin-top: 15px;">
        <label for="[object Object]">Campus Group</label>
        <select class="form-control" name = "campusgroup"id="campusgroup">
          <option id="Faculty">Faculty</option>
          <option id="Student">Student</option>
          <option id="Staff">Staff</option>
          <option id="Dept. Master">Dept. Master</option>
          <option id="Contractor">Contractor</option>
        </select>
      </div>
    </div>
    <input type="submit" class = "btn btn-primary" name="transfer" value="Transfer">
      </form>
  </body>
  <script type="text/javascript">
  var origin;
  var reciever ;
  var dep;
  var firstname;
  var lastname;
  var key;
  var series;
  $(document).ready(function(){
    //Select2
   $('.search').select2({
     placeholder: 'Select a Value',
     allowClear: true
   });
   $("#dsearch").select2({ width: '355px' });

  /* $("#keysearch").change(function(){
     var key = $("#keysearch").val();
     $.ajax({
       url: "keyinfo.php",
       success: function(result){

       }
     })
     console.log(key);
   });*/

  });
  function ochange(){
    origin = document.getElementById('osearch').value;
    //console.log('origin '+origin);
    var oname = origin.split(" ");
    var firstarr = [];

    for (var i =  0 ; i <= (oname.length-2); i++){
      firstarr.push(oname[i]);
    }
    //console.log(firstarr);

    firstname = firstarr.join(" ");
    lastname = oname[oname.length -1];
    if(oname[0]=='Master'&& oname[1]=='Ring'){
      firstname = 'Master Ring';
      lastarr= [];
      for (var j = 2; j<oname.length;j++){
        lastarr.push(oname[j]);
      }

      lastname = lastarr.join(' ');
    //  console.log("first "+ firstname +" last " +lastname);
    }
    console.log(origin);
   getInfo(origin,1)
  }
  function rchange(){
    reciever = document.getElementById('rsearch').value;
  //  console.log(reciever);
    var namearr = reciever.split(" ");
    var firstarr = [];

	  for (var i =  0 ; i <= (namearr.length-2); i++){
	 	 	firstarr.push(namearr[i]);
	  }
		//console.log(firstarr);
		fname = firstarr.join(" ");
	  lname = namearr[namearr.length -1];
    if(namearr[0]=='Master'&& namearr[1]=='Ring'){
      fname = 'Master Ring';
      lastarr= [];
      for (var j = 2; j<namearr.length;j++){
        lastarr.push(namearr[j]);
      }
      //console.log(lastarr);
      lname = lastarr.join(' ');
    }
    document.getElementById("firstname").value = fname;
    document.getElementById("lastname").value = lname;
    dep=""     ;
    getInfo(reciever,2);
  }
  function tagChange(){
    var tagSelected = document.getElementById('tag').value;
  //  console.log(tagSelected);
    $.ajax({
      type:"GET",
      url:"keyinfo.php",
      data:{
        tag: tagSelected,
        fname: firstname,
        lname: lastname
      },
      dataType: "JSON",
      success : function(data){
    //    console.log(data);
        document.getElementById('keysearch').innerHTML = '<option>Select Key</option>';
        for (var i = 0; i < data.length; i++)
          document.getElementById( "keysearch").innerHTML += '<option>'+data[i]+'</option>';

      }

    })
  }
  function dchange(){
     dep = document.getElementById("dsearch").value;
    document.getElementById("dep").value = dep;

  }
  function kchange(){
    key =document.getElementById("keysearch").value;
    $.ajax({
      type:"GET",
      url: "keyinfo.php?",
      data: {
        key: key,
        fname: firstname,
        lname: lastname
      },
      dataType: "JSON",
      success: function(data){
        //console.log(data);
        document.getElementById('keyseries').innerHTML = '<option>Select Series</option>';
        if (data[0]==""){
          document.getElementById('keyseries').innerHTML += '<option>No Series</option>';
        }
        for (var i = 0; i < data.length; i++)
          document.getElementById( "keyseries").innerHTML += '<option>'+data[i]+'</option>';
      }
    });
  }
  function schange(){
    series = document.getElementById("keyseries").value;
    $.ajax({
      type:"GET",
      url: "keyinfo.php?",
      data: {
        key: key,
        fname: firstname,
        lname: lastname,
        series: series
      },
      dataType: "JSON",
      success: function(data){
        console.log(data);
        document.getElementById("keybld").value= data[0];
        document.getElementById("keyrm").value= data[1];
// get multiple tags as array and show as dropdown
// if array contains a single item then select and display that item.
        var tags = data[2];
        document.getElementById('tag').innerHTML='<option></option>';
        if(tags.length == 1){
          document.getElementById('tag').innerHTML='<option selected>'+tags[0]+'</option>';
        }else{
          for (var i = 0; i < tags.length; i++){
            document.getElementById('tag').innerHTML+='<option >'+tags[i]+'</option>';
          }

        }
    }
    });
  }
function getInfo(name, side){
  var xmlhttp;
  xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  xmlhttp.onreadystatechange = function()//Function called when there is a change of state for the server
  {                                      //request
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)//when request is complete and no issues
    {
      var jsonArr = JSON.parse(this.responseText);
      console.log(jsonArr);
      console.log("keyinfo.php?s="+side+"&name="+name);
      if (side == 1){
      document.getElementById('keysearch').innerHTML = '<option>Select Key</option>';
      document.getElementById('keyseries').innerHTML = '<option>Select Series</option>';
      document.getElementById('keybld').innerHTML = '<option>Select Building</option>';
      document.getElementById('keyrm').innerHTML = '<option>Select Room</option>';
      document.getElementById('tag').innerHTML = '<option>Select tag</option>';
      if(jsonArr.tag.length ==1){
        document.getElementById('tag').innerHTML ='<option selected>'+jsonArr.tag[0]+'</option>';
        tagChange();
        console.log('function tag change called');
      }else{
      for (var i = 0; i< jsonArr.tag.length;i++ )
        document.getElementById('tag').innerHTML +='<option>'+jsonArr.tag[i]+'</option>';
}
      /*for (var i = 0; i< jsonArr.series.length;i++ )
        document.getElementById('keyseries').innerHTML +='<option>'+jsonArr.series[i]+'</option>';
      for (var i = 0; i< jsonArr.bld.length;i++ )
        document.getElementById('keybld').innerHTML +='<option>'+jsonArr.bld[i]+'</option>';
      for (var i = 0; i< jsonArr.room.length;i++ )
        document.getElementById('keyrm').innerHTML +='<option>'+jsonArr.room[i]+'</option>';
      */}
      else{
        document.getElementById('empnum').value = jsonArr.empnum;
        document.getElementById('dep').value = jsonArr.department;
        if(Array.isArray(jsonArr.tag)){
          var h = '<label >Tag #: </label><br><select id= "tagselect" name = "tag"><option></option></select>';
          document.getElementById('tagdiv').innerHTML=h;
          var arr = jsonArr.tag;

          for(var i = 0; i < arr.length; i++){
            document.getElementById('tagselect').innerHTML+="<option>"+arr[i]+"</option>";
          }

        }else{
        var h = '<label >Tag #: </label><br><input type="text" id = "tag" class ="form-control" name="tag" value="'+jsonArr.tag+'">';
        document.getElementById('tagdiv').innerHTML = h;
        //document.getElementById('tag').value = jsonArr.tag;
        }
        //console.log(name);
        if(jsonArr.group != "")
          document.getElementById(jsonArr.group).selected = true;
            }


    }
  };
  xmlhttp.open("GET","keyinfo.php?s="+side+"&name="+name,true);
  xmlhttp.send();
}


  </script>
</html>
