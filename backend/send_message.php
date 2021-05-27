<?php
if(isset($_POST['sendMessage'])){
  $subject =$_POST['subject'];
  $message = $_POST['message'];
  if($subject=='no subject'){
    header('Location: ../message_admin.php?msg_err');
    exit();
  }
  else{
    require('dbConfig.php');
    $send_message = 'INSERT INTO user_messages(subject, message) VALUES(?,?)';
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $send_message)){
      header('Location: ../message_admin.php?sql_error');
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $subject, $message);
      if(!mysqli_stmt_execute($stmt)){
        header('Location: ../message_admin.php?send_error');
        exit();
      }
      else{
        header('Location: ../message_admin.php?full_sent');
        exit();
      }
    }
  }
}
?>
