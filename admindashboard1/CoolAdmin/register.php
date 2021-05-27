<?php
session_start();
if(isset($_SESSION['username'])){
  //
}
else{
  session_unset();
  session_destroy();
  header('Location: ../../../adminLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Add Admin</title>

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

</head>

<body class="animsition">

  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <a class="text-white" href="adminDash2.php">Dash Home <i class="fa fa-home"></i></a><br><br>
        <a class="text-white" href="forget-pass.php">Update My Password <i class="fa fa-lock"></i></a><br><br>
        <a class="text-white" href="createForm.php">Create Form <i class="fa fa-edit"></i></a><br><br>
        <a class="text-white" href="backend/adminLogout.php">Logout <i class="fas fa-sign-out-alt"></i></a>

      </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
  </div>
    <div class="page-wrapper">
      <section class="au-breadcrumb2">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <div class="au-breadcrumb-content">
                          <div class="au-breadcrumb-left">
                              <span class="au-breadcrumb-span">You are here:</span>
                              <ul class="list-unstyled list-inline au-breadcrumb__list">
                                  <li class="list-inline-item active">
                                      <a href="#">Home</a>
                                  </li>
                                  <li class="list-inline-item seprate">
                                      <span>/</span>
                                  </li>
                                  <li class="list-inline-item">Dashboard</li>
                                  <li class="list-inline-item seprate">
                                      <span>/</span>
                                  </li>
                                  <li class="list-inline-item">Add Admin Role</li>

                              </ul>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </section>
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <!--<div class="login-logo">
                            <a href="#">
                                <img src="../../assets/images/nhic_logo.jpg" alt="CoolAdmin">
                            </a>
                        </div> -->
                        <div class="login-form">
                            <form action="backend/add_admin_role.php" method="post">
                              <?php  $url = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                                if(strpos($url, "emptyFields") == TRUE){
                                  echo '<p class="alert alert-danger">You must fill out the fields <i class="fa fa-exclamation-circle"></i></p>';
                                }
                                else if(strpos($url, "invalidEmail") == TRUE){
                                  echo '<p class="alert alert-danger">The email entered is not valid <i class="fa fa-exclamation-circle"></i></p>';
                                }
                                else if(strpos($url, "invalidNum") == TRUE){
                                  echo '<p class="alert alert-danger">You must enter the phone number in this format: xxx-xxx-xxxx <i class="fa fa-exclamation-circle"></i></p>';
                                }
                                else if(strpos($url, "emptyFields") == TRUE){
                                  echo '<p class="alert alert-danger">Password must meet the following criteria: <i class="fa fa-exclamation-circle"></i>
                                  <ul style="word-spacing: 4px; font-weight:bold; list-style:none;" class="bg-dark text-danger">
                                  <li>(1) Must be at least 8 characters long</li><br>
                                  <li>(2) Must have at least 1 UPPERCASE letter</li><br>
                                  <li>(3) Must have at least 1 number</li><br>
                                  <li>(4) Must have at least 1 special character</li>
                                  </ul>
                                  </p>';
                                }
                                else if(strpos($url, "passwordsNotMatched") == TRUE){
                                  echo '<p class="alert alert-danger">Both passwords entered must match <i class="fa fa-exclamation-circle"></i></p>';
                                }
                                else if(strpos($url, "sqlError") == TRUE){
                                  echo '<p class="alert alert-warning">Something went wrong. If this continues, reach out to the developer <i class="fa fa-exclamation-circle"></i></p>';
                                }
                                else if(strpos($url, "selectRole") == TRUE){
                                  echo '<p class="alert alert-danger">You must select an admin role <i class="fa fa-exclamation-circle"></i></p>';

                                }
                                else if(strpos($url, "userExists") == TRUE){
                                  echo '<p class="alert alert-warning">This admin already exists <i class="fa fa-exclamation-circle"></i></p>';

                                }
                                else if(strpos($url, "signupSuccess") == TRUE){
                                  echo '<p class="alert alert-success">Successfully added new admin role <i class="fa fa-check-circle"></i></p>';

                                }

                              ?>

                              <div class="row">
                                <div class="form-group">
                                    <label class="font-weight-bold">First Name <i class="fa fa-user" style="color: grey;"></i></label>
                                    <input class="au-input au-input--full" type="text" name="first_name" placeholder="Enter first name">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Last Name <i class="fa fa-user" style="color: grey;"></i></label>
                                    <input class="au-input au-input--full" type="text" name="last_name" placeholder="Enter last name">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Username <i class="fa fa-user" style="color: grey;"></i></label>
                                    <input class="au-input au-input--full" type="text" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Phonenumber <i class="fa fa-phone" style="color: grey;"></i></label>
                                    <input class="au-input au-input--full form-control" type="text" name="phoneNum" placeholder="format: xxx-xxx-xxxx">
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Address <i class="fa fa-envelope" style="color:grey;"></i></label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Select Role <i class="fa fa-user-plus" style="color:grey;"></i></label>
                                    <select class="btn btn-dark dropdown-toggle"name="admin_role">
                                      <option value="0">Choose a role</option>
                                      <option value="1">Board of Trustees</option>
                                      <option value="2">Executive Committee</option>
                                    <option value="3">Elections Committee</option>
                                    </select>
                                </div>
                              </div>
                                <div class="row">
                                <div class="form-group">
                                    <label class="font-weight-bold">Password <i class="fa fa-lock" style="color:grey;"></i></label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>


                                <div class="form-group">
                                    <label class="font-weight-bold">Retype Password <i class="fa fa-lock" style="color:grey;"></i></label>
                                    <input class="au-input au-input--full" type="password" name="retypePassword" placeholder="Password">
                                </div>
                              </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" name="addAdmin"type="submit">Add Admin</button>
                                <p style="font-weight:bolder;">Copyright © <?php echo DATE('Y');?> NHIC All rights reserved. <!--Template by <a href="https://colorlib.com">Colorlib</a>.--></p>

                              </div>
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
<!-- end document-->
