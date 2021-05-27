<?php
session_start();
$usernameSess = $_SESSION['username'];
if(isset($_POST['updatePwd'])){
  require('../../../backend/dbConfig.php');
  $currPassword = $_POST['currPassword'];
  $newPwd = $_POST['newPwd'];
  $retypePwd = $_POST['retypePwd'];
  $pwdPattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';

// check if the fields are empty
  if(empty($currPassword) || empty($newPwd) || empty($retypePwd)){
    header('Location: ../forget-pass.php?emptyFields');
    exit();
  }
  else if(!preg_match($pwdPattern, $newPwd)){
    header('Location: ../forget-pass.php?pwdRequirementsNotMet');
    exit();
    }
    else if($retypePwd !== $newPwd){
      header('Location: ../forget-pass.php?passwordsNotMatched');
      exit();
    }
  else{
    $query = 'SELECT * FROM adminUsers WHERE username=?';
    // initialize the prepared statement
    $preparedStmt = mysqli_stmt_init($dbConn);

    // run the SQL and prepared statement
    // runs query string in the DB and checks for errors
    if(!mysqli_stmt_prepare($preparedStmt, $query)){
      header('Location: ../forget-pass.php?queryError');
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


        // grab the password from the user, hash it and see if it matches with the pwd that the user tried to login with
        $checkPwd = password_verify($currPassword, $row['password']);
        if($checkPwd == false){
          header('Location: ../forget-pass.php?invalidPwd');
          exit();
        }
        else if($checkPwd == true){
          $update_curr_pwd = "UPDATE adminUsers SET password=? WHERE username=?";
          $stmt = mysqli_stmt_init($dbConn);
          if(!mysqli_stmt_prepare($stmt, $update_curr_pwd)){
            header('Location: ../forget-pass.php?queryErrorTwo');
            exit();
          }
          else{
            $new_hashed_pwd = password_hash($newPwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $new_hashed_pwd, $usernameSess);
            if(!mysqli_stmt_execute($stmt)){
              header('Location: ../forget-pass.php?updateFailed');
              exit();
            }
            else{
              header('Location: ../forget-pass.php?updateSuccess');
              exit();
            }
          }
        }

    }
  }
}
}
        ?>
