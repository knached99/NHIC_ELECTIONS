<?php

require('backend/dbConfig.php');
if(isset($_POST['createAcct'])){
$firstName = $_GET['firstName'];
$lastName = $_GET['lastName'];
$email = $_GET['email'];
$phoneNum = $_GET['phoneNum'];
$password = $_GET['password'];
}
?>
<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
  .codeInput:focus{
    background-color: #000;
    color: #fff;
    font-weight:bold;
  }
  .codeInput::placeholder{
    color: #5bc0de;
    font-weight:bold;
  }
</style>
</head>
<body>
  <div class="card card-outline-secondary">
     <div class="card-header">
       <h3 class="mb-0 text-primary" style="font-weight:bolder;">Enter the six digit verification code we sent to your email</h3>
     </div>
     <div class="card-body bg-light">
       <form autocomplete="off" class="form" role="form" action="backend/validateCodeInput.php<?php echo '?email='.$_GET['email'].'&firstName='.$_POST['firstName'];'&lastName='.$lastName;'&phoneNum='.$_POST[$phoneNum].'&password='.$_POST['password'].''?>" method="POST">
         <div class="form-group">
           <input type="text" style="font-weight: bolder; margin-bottom: 20px; cursor: default;"readonly value="Verification code was sent to <?php echo $_GET['email'];?>" class="form-control text-success">
           <label for="verificationCode" class="text-dark" style="font-weight:bolder;">Enter Verification Code <i class="fa fa-user-secret text-primary fa-2x"></i></label>
           <input class="form-control col-md-4 codeInput" name="verificationCode" placeholder="Type the verification code in here" maxlength="6"type="text">
         </div>
         <?php
         $webUrl = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
         if(strpos($webUrl,'error=emptyFields' )==TRUE){
           echo '<p class="alert alert-danger">You must enter the verification code <i class="fa fa-exclamation-circle"></i></p>';
         }
         else if(strpos($webUrl, "error=invalidKey")==TRUE){
           echo '<p class="alert alert-danger">The code entered is not valid, check your email and try again <i class="fa fa-times-circle"></i></p>';

         }
         else if(strpos($webUrl, "error=sqlError")==TRUE){
           echo '<p class="alert alert-warning">Unable to insert the data <i class="fa fa-exclamation-circle"></i></p>';

         }
         else if(strpos($webUrl, "error=sqlError2")==TRUE){
           echo '<p class="alert alert-warning">Unable to bind the paramters <i class="fa fa-exclamation-circle"></i></p>';

         }

         else if(strpos($webUrl, "error=emptyRows")==TRUE){
           echo '<p class="alert alert-danger">Your email is not in our system, please go back and create your account again <i class="fa fa-exclamation-circle"></i></p>';

         }
         ?>
         <div class="form-group">
           <button class="btn btn-success btn-lg float-left" name="verifyButton" type="submit">Verify Code</button>
           <a class="btn btn-primary btn-lg float-right" href="createAccount.php" type="button">Go Back</a>

         </div>
       </form>
     </div>
   </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<!-- DELETE ALL OF THIS CODE BENEATH ONCE FINISHED COMPARING-->
