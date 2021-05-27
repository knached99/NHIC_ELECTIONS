<?php
if(isset($_POST['adminLogin'])){
  require('dbConfig.php');
  $username = $_POST['username'];
  $password = $_POST['password'];
  $pwdHash = password_hash($password, PASSWORD_DEFAULT);
// check if the fields are empty
  if(empty($username) && empty($password)){
    header('Location: ../adminLogin.php?error=emptyfields&username='.$username.'');
    exit();
  }
  else if(!empty($username) && empty($password)){
    header('Location: ../adminLogin.php?error=passwordRequired&username='.$username.'');
    exit();
  }
  else if(filter_var($username, FILTER_VALIDATE_EMAIL)){
    header('Location: ../adminLogin.php?usernameisEmail&username='.$username.'');
    exit();
  }
  else{
    $query = 'SELECT * FROM adminUsers WHERE username=?';
    // initialize the prepared statement
    $preparedStmt = mysqli_stmt_init($dbConn);


    // run the SQL and prepared statement
    // runs query string in the DB and checks for errors
    if(!mysqli_stmt_prepare($preparedStmt, $query)){
      header('Location: ../adminLogin.php?error=sqlerror&username='.$username.'');
      exit();
    }
    else{
      // if no errors in the SQL query
      mysqli_stmt_bind_param($preparedStmt, "s", $username);
      // now execute the binded prepared statement
      mysqli_stmt_execute($preparedStmt);

      // get results from the DB
      $results = mysqli_stmt_get_result($preparedStmt);
      // check to see if we got results from the DB

      // fetch data from the result and place results in an ASSOCIATIVE ARRAY
      // which is the format that can be worked with in PHP
      if($row = mysqli_fetch_assoc($results)){
        // grab the password from the user, hash it and see if it matches with the pwd that the user tried to login with
        $checkPwd = password_verify($password, $row['password']);

        if($checkPwd == false){
          header('Location: ../adminLogin.php?error=wrongpassword&username='.$username.'');
          exit();
        }
        else if($checkPwd == true){
          // CHECK IF THE USER'S NAME IS ALSO IN ADMIN TABLE.

          // IF IT IS THEN GO TO ADMIN PAGE, OTHERWISE START SESSION AS CUSTOMER USER
          session_start(); // start a session to remember the user on the SERVER
          $_SESSION['username']=$row['username'];
          header('Location: ../admindashboard1/coolAdmin/adminDash2.php');
          exit();
        }
        else{
          // if the user entered a password that is not a string
          header('Location: ../adminLogin.php?error=wrongpassword&username='.$username.'');
          exit();
        }
      }
      else{
        // if no results were matched in the DB
        header('Location: ../adminLogin.php?error=nouser');
        exit();
      }

    }
  }
}
else{
  header('Location: ../adminLogin.php');
  exit();
}


?>
