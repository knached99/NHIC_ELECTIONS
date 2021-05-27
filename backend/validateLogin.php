<?php

if(isset($_POST['login'])){
  require('dbConfig.php');
  $email = $_POST['email'];
  $password = $_POST['password'];

// check if the fields are empty
  if(empty($email) && empty($password)){
    header('Location: ../login.php?error=emptyfields');
    exit();
  }
  else if(!empty($email) && empty($password)){
    header('Location: ../login.php?passwordRequired');
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('Location: ../login.php?invalidEmail');
    exit();
    }
  else{
    $query = 'SELECT * FROM nhicVoting WHERE email=?';
    // initialize the prepared statement
    $preparedStmt = mysqli_stmt_init($dbConn);

    // run the SQL and prepared statement
    // runs query string in the DB and checks for errors
    if(!mysqli_stmt_prepare($preparedStmt, $query)){
      header('Location: ../login.php?error=sqlerror');
      exit();
    }
    else{
      // if no errors in the SQL query
      mysqli_stmt_bind_param($preparedStmt, "s", $email);
      // now execute the binded prepared statement
      mysqli_stmt_execute($preparedStmt);

      // get results from the DB
      $results = mysqli_stmt_get_result($preparedStmt);
      // check to see if we got results from the DB

      // fetch data from the result and place results in an ASSOCIATIVE ARRAY
      // which is the format that can be worked with in PHP
      if($row = mysqli_fetch_assoc($results)){
        $verified = $row['verified'];
        if($verified == 1){


        // grab the password from the user, hash it and see if
        //it matches with the pwd that the user tried to login with
        $checkPwd = password_verify($password, $row['password']);
        if($checkPwd == false){
          header('Location: ../login.php?error=wrongpassword');
          exit();
        }
        else if($checkPwd == true){
          // CHECK IF THE USER'S NAME IS ALSO IN ADMIN TABLE.

          // IF IT IS THEN GO TO ADMIN PAGE, OTHERWISE START SESSION AS CUSTOMER USER
          session_start(); // start a session to remember the user on the SERVER
          $_SESSION['email']=$row['email'];
          header('Location: ../memberDashboard.php?success=userLoggedin');
          exit();
        }
        else{
          // if the user entered a password that is not a string
          header('Location: ../login.php?error=wrongpassword&email='.$email.'');
          exit();
        }
      }
      else{
        header('Location: ../login.php?acctNotValid');
      }
    }
      else{
        // if no results were matched in the DB
        header('Location: ../login.php?error=nouser');
        exit();
      }

    }
  }
}
else{
  header('Location: ../homepage.php');
  exit();
}


?>
