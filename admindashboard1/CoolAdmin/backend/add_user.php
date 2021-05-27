<?php
if(isset($_POST['addUser'])){
  require('../../../backend/dbConfig.php');
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $phoneNum = $_POST['phoneNum'];
  $password = $_POST['password'];
  $confirm_pass =$_POST['confirm_pass'];
  $pwdPattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
 $phonePattern = '/^(\({1}\d{3}\){1}|\d{3})(\s|-|.)\d{3}(\s|-|.)\d{4}$/';
  if(empty($firstName) || empty($lastName) || empty($email) || empty($phoneNum) || empty($password) || empty($confirm_pass)){
    echo 'All fields are required';
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo 'Email entered is not valid';
    exit();
  }
  else if(!preg_match($phonePattern, $phoneNum)){
    echo 'Phone number entered must be in this format: xxx-xxx-xxxx';
    exit();
  }
  else if(!preg_match($pwdPattern, $password)){
    echo 'Password entered is not in the correct format';
    exit();
  }
  else if($confirm_pass !==$password){
    echo 'Passwords must match';
    exit();
  }
  else{
    $check_exists = 'SELECT * FROM nhicVoting WHERE email=? OR phoneNum=?';
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $check_exists)){
      echo 'SQL ERROR';
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $email, $phoneNum);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $results = mysqli_stmt_num_rows($stmt);
      if($results > 0){
        echo 'User already exists';
        exit();
      }
      else{
        $create_user = 'INSERT INTO nhicVoting(firstName, lastName, email, phoneNum, password, vKey, verified) VALUES(?,?,?,?,?,?,?)';
        $stmt = mysqli_stmt_init($dbConn);
        if(!mysqli_stmt_prepare($stmt, $create_user)){
          echo 'SQL ERROR TWO';
          exit();
        }
        else{
          $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
          $vKey = md5(time(). $password);
          $verified = 1;
          mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $lastName, $email, $phoneNum, $hashed_pwd, $vKey, $verified);
          if(!mysqli_stmt_execute($stmt)){
            echo 'Unable to create account';
          }
          else{
            header('Location: ../adminDash2.php');
          }
        }
      }
    }
  }
}
?>
