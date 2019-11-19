<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
</head>
<body>
<?php
// This page processes the login form submission.
// The script now stores the HTTP_USER_AGENT value for added security.

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{


	// Need two helper files:
	require ('includes/mysqli_connect.php');
	require ('includes/login_functions.inc2.php');


	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['userId'], $_POST['pass']);

	if ($check)
	{ // OK!

		// Set the session data:
		session_start();

		$_SESSION['admin_level'] = $data['admin_level'];
		$_SESSION['user_id'] = $data['uId'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		$_SESSION['user_number'] = $data['user_id'];
		$_SESSION['sec_question'] = ($data['sec_question'] == null)? 1:2;

		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		redirect_user('loggedin.php');
	}
	else
	{ // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;

	}

	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include ('login_page.inc2.php');
?>
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:'addkey.php',

		});

	});
</script> -->
</body>