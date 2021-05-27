<?php
session_start();
require('backend/dbConfig.php');
if(isset($_SESSION['username'])){
  if(isset($_POST['upload_pic'])){
    //$profile_pic = $_POST['profile_pic'];
    $file = $_FILES['profile_pic']; // name variable for file
    $file_name = $_FILES['profile_pic']['name']; // name of the file
    $temp_file_name = $_FILES['profile_pic']['tmp_name']; // temporary name of file
    $file_size = $_FILES['profile_pic']['file']; // upload size
    $file_upload_error =$_FILES['profile_pic']['error']; // error for file upload
    $file_type = $_FILES['profile_pic']['type']; // file type
    $file_extension = explode('.', $file_name);
    $actual_file_extension = strtolower(end($file_extension));
  }
}
else{
  //header('Location: login.php');
  session_unset();
  session_destroy();
  header('Location: adminLogin.php');
  exit();
}
?>
