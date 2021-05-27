<?php
session_start();
$userEmail = $_SESSION['email'];
require('dbConfig.php');
if(isset($_POST['update'])){
   $email = $_POST['email'];
   $phoneNum = $_POST['phoneNum'];

   // REGEX PATTERNS
   $phonePattern = '/^(\({1}\d{3}\){1}|\d{3})(\s|-|.)\d{3}(\s|-|.)\d{4}$/';
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
     header('Location: ../editProfile.php?invalidEmail');
     exit();
   }
   else if(!preg_match($phonePattern, $phoneNum)){
     header('Location: ../editProfile.php?numberInvalid');
     exit();
   }
   $get_curr_user = 'SELECT * FROM nhicVoting WHERE email=?';
   $stmt = mysqli_stmt_init($dbConn);
   if(!mysqli_stmt_prepare($stmt, $get_curr_user)){
     header('Location: ../editProfile.php?sqlError');
     exit();
   }
   else{
     mysqli_stmt_bind_param($stmt, "s", $userEmail);
     mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);
     if($row = mysqli_fetch_assoc($results)){
       $update_user_information = 'UPDATE nhicVoting SET email=?, phoneNum =? WHERE email=?';
       $stmt = mysqli_stmt_init($dbConn);
       if(!mysqli_stmt_prepare($stmt, $update_user_information)){
         header('Location: ../editProfile.php?queryError');
         exit();
       }
       else{
         mysqli_stmt_bind_param($stmt, "sss", $email, $phoneNum, $userEmail);
         if(!mysqli_stmt_execute($stmt)){
           header('Location: ../editProfile.php?updateFailed');
           exit();
         }
         else{
           header('Location: ../editProfile.php?updateSuccess');
           exit();
         }
       }
     }
   }
}
?>
