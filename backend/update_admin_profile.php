<?php
session_start();
$usernameSess = $_SESSION['username'];
if(isset($_POST['updateProfile'])){
  require('dbConfig.php');
  $newusername = $_POST['username'];
  $email = $_POST['email'];
  $phone_num =$_POST['phone_num'];
  $phonePattern = '/^(\({1}\d{3}\){1}|\d{3})(\s|-|.)\d{3}(\s|-|.)\d{4}$/';

  if(strlen((string)$newusername)> 15 || strlen((string)$newusername) ==0){
    header('Location: ../edit_admin_profile.php?usernameLen');
    exit();
  }
   else if(!preg_match($phonePattern, $phone_num)){
    header('Location: ../edit_admin_profile.php?numberInvalid');
    exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      header('Location: ../edit_admin_profile.php?invalidEmail');
      exit();
    }
  else{
    $query = 'SELECT * FROM adminUsers WHERE username=?';
    // initialize the prepared statement
    $preparedStmt = mysqli_stmt_init($dbConn);

    // run the SQL and prepared statement
    // runs query string in the DB and checks for errors
    if(!mysqli_stmt_prepare($preparedStmt, $query)){
      header('Location: ../edit_admin_profile.php?queryError');
      exit();
    }
    else{
      // if no errors in the SQL query
      mysqli_stmt_bind_param($preparedStmt, "s", $usernameSess);
      // now execute the binded prepared statement
      mysqli_stmt_execute($preparedStmt);

      // get results from the DB
      $results = mysqli_stmt_get_result($preparedStmt);
      // check to see if we got results from the DB

      // fetch data from the result and place results in an ASSOCIATIVE ARRAY
      // which is the format that can be worked with in PHP
      if($row = mysqli_fetch_assoc($results)){




          $update_curr_pwd = "UPDATE adminUsers SET username=?, email=?, phone_num=? WHERE username=?";
          $stmt = mysqli_stmt_init($dbConn);
          if(!mysqli_stmt_prepare($stmt, $update_curr_pwd)){
            header('Location: ../edit_admin_profile.php?queryErrorTwo');
            exit();
          }
          else{
            mysqli_stmt_bind_param($stmt, "ssss", $newusername, $email, $phone_num, $usernameSess);
            if(!mysqli_stmt_execute($stmt)){
              header('Location: ../edit_admin_profile.php?updateFailed');
              exit();
            }
            else{
              header('Location: ../edit_admin_profile.php?updateSuccess');
              exit();
            }
          }
        }

    }
  }
}

        ?>
