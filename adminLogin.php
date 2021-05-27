<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
  <a class="navbar-brand font-weight-bold text-white" href="https://nhicct.org/">NHIC</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse font-weight-bold" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto font-weight-bold">
    <li class="nav-item">
      <a class="nav-link text-white font-weight-bold" href="https://nhicct.org/">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white font-weight-bold" href="createAccount.php">Sign Up</a>
    </li>
  	<li class="nav-item">
      <a class="nav-link text-white font-weight-bold" href="adminLogin.php">Admin Login</a>
    </li>
  </div>
  </nav>
		<div class="container-login100 bg-light">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url('https://images.unsplash.com/photo-1465447142348-e9952c393450?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fGNpdHl8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60');">
          <span class="login100-form-title-1">
						NHIC
          </span>
					<span class="login100-form-title-1">
					 Admin Login
					</span>
				</div>

				<form class="login100-form validate-form" action="backend/validateAdminlogin.php" method="POST">

							<?php
							if(isset($_GET['username'])){
								$username = $_GET['username'];
								echo '
								<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
									<span class="zmdi-hc-stack zmdi-hc-lg">
										<i class="zmdi zmdi-circle-o zmdi-hc-stack-2x"></i>
										<i class="zmdi zmdi-account zmdi-hc-stack-1x"></i>
										</span>
								<input class="input100" type="text" name="username" placeholder="Enter username" value="'.$username.'" autocomplete="off">
								<span class="focus-input100"></span>
								</div>
								';
							}
							else{
								echo '
								<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
									<span class="zmdi-hc-stack zmdi-hc-lg">
										<i class="zmdi zmdi-circle-o zmdi-hc-stack-2x"></i>
										<i class="zmdi zmdi-account zmdi-hc-stack-1x"></i>
										</span>
								<input class="input100" type="text" name="username" placeholder="Enter username" autocomplete="off">
								<span class="focus-input100"></span>
								</div>

								';
							}
							if(isset($_GET['password'])){
								$password = $_GET['password'];
								echo '
								<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
									<span class="zmdi-hc-stack zmdi-hc-lg">
										<i class="zmdi zmdi-circle-o zmdi-hc-stack-2x"></i>
										<i class="zmdi zmdi-lock zmdi-hc-stack-1x"></i>
										</span>
									<input class="input100" type="password" name="password" value="'.$password.'" placeholder="Enter password">
									<span class="focus-input100"></span>
								</div>
								';
							}
							else{
								echo '
								<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
									<span class="zmdi-hc-stack zmdi-hc-lg">
										<i class="zmdi zmdi-circle-o zmdi-hc-stack-2x"></i>
										<i class="zmdi zmdi-lock zmdi-hc-stack-1x"></i>
										</span>
									<input class="input100" type="password" name="password" placeholder="Enter password">
									<span class="focus-input100"></span>
								</div>
								';
							}
							?>
          <?php
          $websiteUrl = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
          if(strpos($websiteUrl, "error=emptyfields")==true){
            echo '<p class="alert alert-danger" style="width: 100%; font-weight:bolder;">You\'ve left both fields empty <i class="fa fa-exclamation-circle"></i></p>';
          }
					else if(strpos($websiteUrl, "error=passwordRequired")==TRUE){
						echo '<p class="alert alert-danger" style="width: 100%; font-weight:bolder;">You forgot to enter your password <i class="fa fa-exclamation-circle"></i></p>';

					}
					else if(strpos($websiteUrl, "usernameisEmail")==TRUE){
						echo '<p class="alert alert-danger" style="width: 100%; font-weight:bolder;">You need to enter a username, not an email for the username field <i class="fa fa-exclamation-circle"></i></p>';

					}
          else if(strpos($websiteUrl, "error=sqlerror")==true){
            echo '<p class="alert alert-danger" style="width:100%; font-weight:bolder;">Error in SQL script <i class="fa fa-exclamation-circle"></i></p>';
          }

          else if(strpos($websiteUrl, "error=wrongpassword")){
            echo '<p class="alert alert-danger" style="font-weight:bolder; width:100%;">Password is incorrect <i class="fa fa-exclamation-circle"></i></p>';
          }
          else if(strpos($websiteUrl, "error=nouser")){
            echo '<p class="alert alert-warning" style="width:100%; font-weight:bolder;">The username entered does not exist, please enter the correct username or contact the main admin for help <i class="fa fa-exclamation-circle"></i></p>';
          }
					else if(strpos($websiteUrl, "pwdUpdateSuccess")){
						echo '<p class="alert alert-success" style="width:100%; font-weight:bolder;">Your password has been updated and you can now log in. <i class="fa fa-check-circle"></i></p>';

					}
          else if(strpos($websiteUrl, 'message=loggedout')){
            echo '<p class="alert alert-success" style="width:100%; font-weight:bolder;">You are Logged Out <i class="fa fa-check-circle"></i></p>';
          }
          else if(strpos($websiteUrl, 'sessionTimeout')){
            echo '<p class="alert alert-warning">You have been logged out due to inactivity <i class="fa fa-warning"></i></p>';
          }
					else if(strpos($websiteUrl, "password_reset") == TRUE){
						echo '<p class="alert alert-success">We have successfully reset your password! Go ahead and login now</p>';
					}


          ?>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">
              <!-- Nothing to show here-->
						</div>

						<div>
							<a href="admindashboard1/coolAdmin/reset_admin_pwd.php" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" name="adminLogin">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<!--	<script src="js/main.js"></script> -->

</body>
</html>
