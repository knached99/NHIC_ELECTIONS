<?php
if(isset($_POST['updatePwd'])){
  $email = $_GET['email'];
  $reset_key=$_GET['reset_key'];
  $auth_token = $_GET['auth_token'];
  $newPwd = $_POST['newPwd'];
  $retypePwd = $_POST['retypePwd'];
  $pwdPattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
  if( empty($newPwd) || empty($retypePwd)){
    header('Location: ../create_admin_password.php?emptyFields&reset_key='.$reset_key.'&auth_token='.$auth_token.'&email='.$email.'');

  }

  else if(!preg_match($pwdPattern, $newPwd)){
    header('Location: ../create_admin_password.php?invalidPwd&reset_key='.$reset_key.'&auth_token='.$auth_token.'&email='.$email.'');
    exit();
  }
  else if($retypePwd !== $newPwd){
    header('Location: ../create_admin_password.php?passwordsNotMatched&reset_key='.$reset_key.'&auth_token='.$auth_token.'&email='.$email.'');
    exit();
}
else{
  require('../../../backend/dbConfig.php');
  $reset_pwd = "UPDATE adminUsers SET password=? WHERE email=?";
  $stmt = mysqli_stmt_init($dbConn);
  if(!mysqli_stmt_prepare($stmt, $reset_pwd)){
    header('Location: ../create_admin_password.php?sqlError&reset_key='.$reset_key.'&auth_token='.$auth_token.'&email='.$email.'');
    exit();
  }
  else{
    $hashed_pwd = password_hash($newPwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ss", $hashed_pwd, $email);
    if(!mysqli_stmt_execute($stmt)){
      header('Location: ../create_admin_password.php?reset_error&reset_key='.$reset_key.'&auth_token='.$auth_token.'&email='.$email.'');
      exit();
    }
    else{
      header('Location: ../../../adminLogin.php?password_reset');
      exit();
    }
  }
}

}
?>
