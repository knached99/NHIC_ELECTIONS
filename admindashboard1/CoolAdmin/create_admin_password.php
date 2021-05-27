<?php
$email = $_GET['email'];
$reset_key = $_GET['reset_key'];
$auth_token = $_GET['auth_token'];
// check if the tokens in the URL were meessed with
if(empty($reset_key) || empty($auth_token) || empty($email)){
  echo '<p class="alert alert-danger" style="width: 20%;">Could not authenticate you</p>';
}
else if(empty($email)){
  echo '<p class="alert alert-success" style="width: 20%;">We have authenticated your reset tokens <b>but could not determine your email.</b> Please fill out all fields to reset your password</p>';
}
else if(isset($_GET['email']) && isset($_GET['reset_key']) && isset($_GET['auth_token'])){
  require('../../backend/dbConfig.php');
  $get_auth_status = $dbConn->query('SELECT * FROM adminUsers WHERE reset_status = 0 AND reset_key='.$reset_key.' AND auth_token='.$update_auth_status.' AND email='.$email.'');
    if($get_auth_status -> num_rows ==1){
    $update_auth_status = $dbConn->query('UPDATE adminUsers SET reset_key=1 WHERE reset_key='.$reset_key.' AND auth_token='.$auth_token.' AND email='.$email.'');
    if($update_auth_status){
      echo 'You will need to submit another password reset request as you cannot use the same auth tokens to reset your password.';
    }
  }
}
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <!-- Title Page-->
        <title>Update Password</title>

        <!-- Fontfaces CSS-->
        <link href="css/font-face.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="css/theme.css" rel="stylesheet" media="all">
        <style>
        .circle-icon {
    background: #fff;
    padding:10px;
    border-radius: 50%;
}
        </style>

    </head>
    <body class="animsition bg-dark">

        <div class="page-wrapper bg-dark">

            <div class="page-content--bge5 bg-dark">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content bg-light text-dark">
                          <h2 class="font-weight-bold text-success mb-5">NHIC Admin Password Reset</h2>
                            <div class="login-logo">

                                  <!-- ../../assets/images/nhic_logo.jpg-->
                                    <img src="https://images.unsplash.com/photo-1426604966848-d7adac402bff?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHlvc2VtaXRlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60" alt="NHICAdmin">

                            </div>
                            <div class="login-form">
                                <form action="backend/create_new_pwd.php?email='<?php echo $email;?>&reset_key='<?php echo $reset_key;?>&auth_token='<?php echo $auth_token;?>''" method="post">
                                  <?php
                                  $url = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                                  if(strpos($url, 'emptyFields') == TRUE){
                                    echo '<p class="alert alert-danger">All fields are required</p>';
                                  }
                                  else if(strpos($url, "invalidEmail") == TRUE){
                                    echo '<p class="alert alert-danger">Email entered is not valid</p>';
                                  }
                                  else if(strpos($url, "invalidPwd") == TRUE){
                                    echo '<ul class="bg-dark text-danger font-weight-bold">
                                    <li>Must be at least 8 characters in length</li>
                                    <li>Must have at least one uppercase letter</li>
                                    <li>Must have at least one number</li>
                                    <li>Must have at least one special character</li>
                                    </ul>
                                    ';
                                  }
                                  else if(strpos($url, "passwordsNotMatched") ==TRUE){
                                    echo '<p class="alert alert-danger">Both passwords must match</p>';
                                  }
                                  else if(strpos($url, "sqlError") == TRUE){
                                    echo '<p class="alert alert-primary">An unknown database error has occurred. Please try again later.</p>';

                                  }
                                  else if(strpos($url, "sqlErrorTwo") == TRUE){
                                    echo '<p class="alert alert-primary">Another error has occurred in our system</p>';
                                  }
                                  else if(strpos($url, "deletion_error") == TRUE){
                                    echo '<p class="alert alert-danger">Unable to delete old password</p>';
                                  }
                                  ?>

                                  <input type="hidden" name="reset_key" value="<?php echo $reset_key;?>">
                                  <input type="hidden" name="auth_token" value="<?php echo $auth_token;?>">
                                    <!--<div class="form-group">
                                      <label class="font-weight-bold">Enter your email <i class="fa fa-envelope" style="color: white;"></i></label>
                                      <input class="au-input au-input--full" type="text" name="email" placeholder="Enter your email">
                                    </div>-->
                                    <input type="hidden" name="email" value="<?php echo $email;?>">
                                    <div class="form-group">
                                        <label class="font-weight-bold">New Password <i class="fa fa-lock" style="color: white;"></i></label>
                                        <input class="au-input au-input--full" type="password" name="newPwd" placeholder="Create a new password">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Retype Password <i class="fa fa-lock" style="color:white;"></i></label>
                                        <input class="au-input au-input--full" type="password" name="retypePwd" placeholder="Retype that new password">
                                    </div>
                                    <button class="au-btn au-btn--block au-btn--green m-b-20 font-weight-bold" name="updatePwd" type="submit">Reset Password</button>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>


        <!-- Jquery JS-->
        <script src="vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="vendor/slick/slick.min.js">
        </script>
        <script src="vendor/wow/wow.min.js"></script>
        <script src="vendor/animsition/animsition.min.js"></script>
        <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="vendor/counter-up/jquery.counterup.min.js">
        </script>
        <script src="vendor/circle-progress/circle-progress.min.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="vendor/select2/select2.min.js">
        </script>

        <!-- Main JS-->
        <script src="js/main.js"></script>

    </body>

    </html>
