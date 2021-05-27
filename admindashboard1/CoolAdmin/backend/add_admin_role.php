<?php
session_start();
if(!isset($_SESSION['username'])){
  session_unset();
  session_destroy();
  header('Location: ../../../adminLogin.php');
  exit();
}
if(isset($_POST['addAdmin'])){
  require('../../../backend/dbConfig.php');
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $phoneNum = $_POST['phoneNum'];
  $admin_role = $_POST['admin_role'];
  $password = $_POST['password'];
  $retypePassword = $_POST['retypePassword'];
  // REGEX PATTERNS
  $pwdPattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
$phonePattern = '/^(\({1}\d{3}\){1}|\d{3})(\s|-|.)\d{3}(\s|-|.)\d{4}$/';



  // check if the fields are empty
  if(empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($phoneNum) || empty($password)|| empty($retypePassword)){
    header('Location: ../register.php?emptyFields');
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../register.php?invalidEmail");
    exit();
      }
  else if(!preg_match($phonePattern, $phoneNum)){
    header('Location: ../register.php?invalidNum');
    exit();
  }
  else if($admin_role == '0'){
    header('Location: ../register.php?selectRole');
    exit();
  }
  else if(!preg_match($pwdPattern, $password)){
    header('Location: ../register.php?invalidPassword');
    exit();
  }
  else if($retypePassword !== $password){
    header('location: ../register.php?passwordsNotMatched');
    exit();
  }
  else{
    require('../../../backend/dbConfig.php');
    $query = 'SELECT *  FROM adminUsers WHERE email=? OR phone_num=? OR username=?';
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      header('Location: ../register.php?sqlError');
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "sss", $email, $phoneNum, $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      // check for query results
      $checkQuery = mysqli_stmt_num_rows($stmt);

    }
    if($checkQuery > 0){
      header('Location: ../register.php?userExists');
      exit();

    }
    // 1. Write the email script here
    //Call the PHPMailer function
    else{
      $insert_user_data = 'INSERT INTO adminUsers(username, firstName, lastName, email, phone_num, password, permissions) VALUES(?,?,?,?,?,?,?)';
      //$six_digit_key = random_int(100000, 999999); // generate random six digit verification code
      //mt_rand()  Generate a random value via the Mersenne Twister Random Number Generator
      // but random_int() is more secure because it generates cryptographically secure values
      $stmt_prepared =mysqli_stmt_init($dbConn);
      if(!mysqli_stmt_prepare($stmt_prepared, $insert_user_data)){
        header('Location: ../register.php?sqlError');
        exit();
      }
      else{
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt_prepared, "ssssssi", $username, $first_name, $last_name, $email, $phoneNum, $hashedPwd, $admin_role);
        if(mysqli_stmt_execute($stmt_prepared)){
          header('Location: ../register.php?signupSuccess');
          exit();
        }

      }
    }
    }
  }
?>
