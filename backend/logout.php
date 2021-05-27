<?php
session_start();

// takes variables that were created upon login
// and it deletes the values inside the session variables
session_unset();

// destroy the currently running sessions
session_destroy();

// take user back to front page
header('Location: ../login.php?message=loggedout');
exit();



?>

<html>
<head>
  <link rel ="stylesheet" type="text/css" href="logout.css">
</head>
<body>

    <h1>You have been successfully logged out!</h1> <br><br>

  <p>Click here to go back to the login page <a href="login.php"></a></p>
</body>
</html>
