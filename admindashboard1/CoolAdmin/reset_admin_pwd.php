
<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head>
  <style>
  body {
    background-position: center;
    background-color: #eee;
    background-repeat: no-repeat;
    background-size: cover;
    color: #505050;
    font-family: "Rubik", Helvetica, Arial, sans-serif;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.5;
    text-transform: none
}

.forgot {
    background-color: #fff;
    padding: 12px;
    border: 1px solid #dfdfdf
}

.padding-bottom-3x {
    padding-bottom: 72px !important
}

.card-footer {
    background-color: #fff
}

.btn {
    font-size: 13px
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #76b7e9;
    outline: 0;
    box-shadow: 0 0 0 0px #28a745
}
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body style="background: #232526;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #414345, #232526);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
<div class="container padding-bottom-3x mb-2 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="forgot">
                <h2>Forgot your password?</h2>
                <p>Change your password in three easy steps. This will help you to secure your password!</p>
                <ol class="list-unstyled">
                    <li><span class="text-primary text-medium">(1) </span>Enter your email address below.</li>
                    <li><span class="text-primary text-medium">(2) </span>Our system will send you an email</li>
                    <li><span class="text-primary text-medium">(3) </span>Follow the instructions to reset your password</li>
                </ol>
            </div>
            <form class="card mt-4" action="backend/forgot_admin_pwd2.php" method="POST">
              <?php
              $webUrl = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
              if(strpos($webUrl, "emptyFields") == TRUE){
                echo '<p class="text-danger" style="font-weight:600;">You need to enter your email <i class="fa fa-exclamation-circle"></i></p>';

              }
              else if(strpos($webUrl, "invalidEmail") == TRUE){
                echo '<p class="text-danger" style="font-weight:600;">Email entered is not valid <i class="fa fa-exclamation-circle"></i></p>';

              }
              else if(strpos($webUrl, "sqlError") == TRUE){
                echo '<p class="text-danger" style="font-weight:600;"> Something went wrong while trying to validate your email <i class="fa fa-exclamation-circle"></i></p>';

              }
              else if(strpos($webUrl, "email_not_on_file") == TRUE){
                echo '<p class="text-danger" style="font-weight:600;">The email you entered is not on file. If you need help, contact another admin <i class="fa fa-exclamation-circle"></i></p>';

              }
              else if(strpos($webUrl, "emailSent") == TRUE){
                echo '<p class="text-success" style="font-weight:600;"> An email with instructions on how to reset your password has been sent! <i class="fa fa-check-circle"></i></p>';

              }
              ?>

                <div class="card-body">

                    <div class="form-group"> <label for="email-for-pass" class="font-weight-bold form-label">Enter your email address</label> <input class="form-control" type="text" id="email-for-pass" name="email"><small class="form-text text-muted">Enter the email address you used to create this account. Then we'll email the instructions to this address.</small> </div>
                </div>
                <div class="card-footer">

                  <button class="btn btn-success" name="resetPwd" type="submit">Send Password Reset Request</button>
                 <a class="btn btn-danger" href="../../adminLogin.php" type="submit">Back to Login</a> </div>
                 </div>

            </form>

    </div>
</div>
</body>
</html>
