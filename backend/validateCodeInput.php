<?php
if(isset($_POST['verifyButton'])){
  require('dbConfig.php');
  include('acctCreation.php');
  $verificationCode = $_POST['verificationCode'];
  $getMail = $_GET['email'];
  $fakeFirstName = 'Alif';
  $fakeLastName = 'Albiruni';
  $fakeEmail = 'alif.albiruni@gmail.com';
  $fakePhoneNumber = '203-747-2578';
  $fakePassword = 'MarioKart8!';

  if(empty($verificationCode)){
    header('Location: ../verifyCode.php?email='.$getMail.'&error=emptyFields');
    exit();
  }
  $verifyKey = 'SELECT * FROM temporary_keys WHERE email = "'.$_GET['email'].'"';
  if($verifyKey = mysqli_query($dbConn, $verifyKey)){
    if($row = mysqli_fetch_assoc($verifyKey)){
      $key = $row['six_digit_key'];
      $email = $row['email'];
      if($verificationCode !== $key){
        header('Location: ../verifyCode.php?email='.$getMail.'&error=invalidKey');
        exit();
      }
      else{
        $insert_user_data = 'INSERT INTO nhicVoting (firstName, lastName, email, phoneNum, password) VALUES(?,?,?,?,?)';
        $stmt_prepared = mysqli_stmt_init($dbConn);
        if(!mysqli_stmt_prepare($stmt_prepared, $insert_user_data)){
          header('Location: ../verifyCode.php?email='.$getMail.'&error=sqlError');
          exit(mysqli_error($stmt_prepared));
        }
        else{
          //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          $fakeFirstName = 'Alif';
          $fakeLastName = 'Albiruni';
          $fakeEmail = 'alif.albiruni@gmail.com';
          $fakePhoneNumber = '203-747-2578';
          $fakePassword = 'MarioKart8!';
          $fakeHashedPassword = password_hash($fakePassword, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt_prepared, "sssss", $fakeFirstName, $fakeLastName, $fakeEmail, $fakePhoneNumber, $fakeHashedPassword);
          if(!mysqli_stmt_execute($stmt_prepared)){
            header('Location: ../verifyCode.php?email='.$getMail.'&error=sqlError2');
          }
          else{
            header('Location: ../createAccount.php?signupSuccessful');
            exit();
          }
        }
      }
    }
  }
  mysqli_stmt_close($stmt_prepared);
  mysqli_close($dbConn);
}
else{
  header('Location: ../createAccount.php?codeSendError');
  exit();
}

?>
