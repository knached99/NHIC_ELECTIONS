<!DOCTYPE html>
<html>
<head>
	<title>Member Login</title>
	<link rel="stylesheet" type="text/css" href="styling/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
<a class="navbar-brand" href="http://www.nhicct.org/">NHIC</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
  <li class="nav-item">
    <a class="nav-link" href="http://www.nhicct.org/">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="createAccount.php">Sign Up</a>
  </li>
	<li class="nav-item">
    <a class="nav-link" href="adminLogin.php">Admin Login</a>
  </li>
</div>
</nav>
	<img class="wave" src="assets/wave.png">
	<div class="container">
		<div class="img">
			<img src="assets/bg.svg">
		</div>
		<div class="login-content">
			<form action="backend/validateLogin.php" method="POST">
				<img src="assets/avatar.svg">
				<h2 class="title" style="font-weight: 700;">NHIC Member Login</h2>
      <?php  $url = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
        if(strpos($url, "error=emptyfields")==TRUE){
          echo '<p class ="alert alert-danger">You\'ve left both fields empty <i class="fa fa-exclamation-circle"></i></p>';

        }
				else if(strpos($url, "passwordRequired")==TRUE){
					echo '<p class ="alert alert-danger">You forgot to enter your password <i class="fa fa-exclamation-circle"></i></p>';

				}
				else if(strpos($url, "invalidEmail")==TRUE){
					echo '<p class ="alert alert-danger">You have not entered a valid email <i class="fa fa-exclamation-circle"></i></p>';

				}
        else if(strpos($url, "error=sqlerror")==TRUE){
          echo '<p class ="alert alert-danger">Whoops, looks like something went wrong <i class="fa fa-exclamation-circle"></i></p>';

        }
        else if(strpos($url, "error=wrongpassword")==TRUE){
          echo '<p class="alert alert-danger">You entered the wrong password <i class="fa fa-exclamation-circle"></i></p>';
        }
				else if(strpos($url, "error=invalidEmail")==TRUE){
					echo '<p class="alert alert-danger">You entered an invalid email, try again <i class="fa fa-exclamation-circle"></i></p>';

				}
        else if(strpos($url, "error=nouser")==TRUE){
          echo '<p class="alert alert-warning">The email entered does not match the one in our records. If you cannot remember the email you used to create your account, please contact the masjid\'s BOT <i class="fa fa-exclamation-circle"></i></p>';
        }
				else if(strpos($url, "message=loggedout")==true){
					echo '<p class="alert alert-success">You have been successfully logged out! <i class="fa fa-check-circle"></i></p>';
				}
				else if(strpos($url, "acctNotValid")==TRUE){
					echo '<p class="alert alert-danger">You must verify your account, please check your email <i class="fa fa-exclamation-circle"></i></p>';

				}
				else if(strpos($url, "accountVerified")==TRUE){
					echo '<p class="alert alert-success">Your account was successfully verified and you can now log in <i class="fa fa-check-circle"></i></p>';
				}
      ?>

						<div class="input-div one">
							 <div class="i">
									<i class="zmdi zmdi-email zmdi-hc-2x"></i>
							 </div>
							 <div class="div">
									<h5>Email</h5>
									<input type="text" class="input" id="email" name="email" autocomplete="off">
							 </div>
						</div>


						<div class="input-div pass">
							 <div class="i">
									<i class="zmdi zmdi-lock zmdi-hc-2x"></i>
							 </div>
							 <div class="div">
									<h5>Password</h5>
									<input type="password" class="input" id="password" name="password">
							 </div>
						</div>





            	<a href="#">Forgot Password?</a>
            	<input type="submit" class="btn" style="color: #fff;"name="login"value="Login">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </html>
   <script type="text/javascript" src="JavaScript/login.js"></script>
</body>
</html>
