<?php

//session_start(); // Start the session.

// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!

require("includes/mysqli_connect.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

      <?php

      $query   = "SELECT DISTINCT * FROM department ORDER BY dep";
      $result0 = mysqli_query($dbc, $query);
      while ($row0 = mysqli_fetch_assoc($result0)) {
          $idlink = $row0['idlink'];
          echo '<a href = "departmentAudit.php?c='. $idlink .'">'.$row0["dep"].'</a><br><br>';
          }
      ?>

  </body>
</html>
