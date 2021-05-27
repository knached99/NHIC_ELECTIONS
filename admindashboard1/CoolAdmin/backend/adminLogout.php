<?php
session_start();

// takes variables that were created upon login
// and it deletes the values inside the session variables
session_unset();

// destroy the currently running sessions
session_destroy();

// take user back to Admin Login page
header('Location: ../../../adminLogin.php?message=loggedout');
exit();



?>

<html>
<head>
  <link rel ="stylesheet" type="text/css" href="logout.css">
</head>
<body>
</body>
</html>
