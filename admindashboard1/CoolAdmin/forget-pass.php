<?php
session_start();


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

</head>

<body class="animsition">
  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <a class="text-white" href="adminDash2.php">Dash Home <i class="fa fa-home"></i></a><br><br>
        <?php
        if($_SESSION['permissions'] == 1 || $_SESSION['permissions'] == 2){
          echo '        <a class="text-white" href="register.php">Add Admin Role <i class="fa fa-user-plus"></i></a><br><br>';
        }
        else if($_SESSION['permissions'] == 3){
          echo '        <a class="text-white" id="open"href="#">Add Admin Role <i class="fa fa-user-plus"></i></a><br><br>';

        }
        ?>
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
                                  <li class="list-inline-item">Update My Password</li>

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
                      <!--  <div class="login-logo">
                            <a href="#">
                                <img src="../../assets/images/nhic_logo.jpg" alt="CoolAdmin">
                            </a>
                        </div> -->
                        <div class="login-form">
                            <form action="backend/updatePwd.php" method="post">
                              <?php  $url = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                               if(strpos($url, "emptyFields")== TRUE){
                                echo '<p class="alert alert-danger">Please fill out the fields <i class="fa fa-exclamation-circle"></i></p>';
                              }
                              else if(strpos($url, "invalidPwd")== TRUE){
                                echo '<p class="alert alert-danger">The current password must be the current password you are using now <i class="fa fa-exclamation-circle"></i></p>';
                              }
                              else if(strpos($url, "pwdRequirementsNotMet")==TRUE){
                                echo '<p class="alert alert-danger">Password must meet the following criteria: <i class="fa fa-exclamation-circle"></i>
                                <ul style="word-spacing: 4px; font-weight:bold; list-style:none;" class="bg-dark text-danger">
                                <li>(1) Must be at least 8 characters long</li><br>
                                <li>(2) Must have at least 1 UPPERCASE letter</li><br>
                                <li>(3) Must have at least 1 number</li><br>
                                <li>(4) Must have at least 1 special character</li>
                                </ul>
                                </p>';

                              }
                              else if(strpos($url, "passwordsNotMatched")== TRUE){
                                  echo '<p class="alert alert-danger">Both passwords must match <i class="fa fa-exclamation-circle"></i></p>';


                                }
                                else if(strpos($url, "queryError")== TRUE){
                                  echo '<p class="alert alert-info">Something went wrong while trying to verify your current password <i class="fa fa-exclamation-circle"></i></p>';

                                }
                                else if(strpos($url, "queryErrorTwo")== TRUE){
                                  echo '<p class="alert alert-info">Something went wrong while trying to update your current password <i class="fa fa-exclamation-circle"></i></p>';

                                }

                                  else if(strpos($url, "updateFailed")== TRUE){
                                      echo '<p class="alert alert-info">Unable to update new password <i class="fa fa-exclamation-circle"></i></p>';
                                    }
                                    else if(strpos($url, "cannotHashPwd")== TRUE){
                                        echo '<p class="alert alert-info">Unable to hash password <i class="fa fa-exclamation-circle"></i></p>';
                                      }
                                    else if(strpos($url, "updateSuccess")== TRUE){
                                        echo '<p class="alert alert-success">Password has been updated <i class="fa fa-check-circle"></i>
                                        </p>
                                        ';
                                      }
                              ?>

                                <div class="form-group">
                                    <label class="font-weight-bold">Current Password <i class="fa fa-lock" style="color:grey;"><i class="fa fa-key" style="color:grey;"></i></i></label>
                                    <input class="au-input au-input--full" type="password" name="currPassword" placeholder="Enter your current password">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">New Password <i class="fa fa-lock" style="color:grey;"></i></label>
                                    <input class="au-input au-input--full" type="password" name="newPwd" placeholder="Create a new password">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Retype Password <i class="fa fa-lock" style="color:grey;"></i></label>
                                    <input class="au-input au-input--full" type="password" name="retypePwd" placeholder="Retype that new password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" name="updatePwd" type="submit">Update Password</button>
                            </form>
                            <p style="font-weight:bolder;">Copyright © <?php echo DATE('Y');?>    NHIC All rights reserved. <!--Template by <a href="https://colorlib.com">Colorlib</a>.--></p>

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
    <script>
    $("#open").on("click", function() {
      alert('Sorry but you do not have permission to access to this page');
   });
   </script>
    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
