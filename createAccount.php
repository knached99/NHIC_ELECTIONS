<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Account Creation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    -->
    <!-- custom CSS-->
    <link href="styling/createAccount.css" rel="stylesheet" media="all">


</head>

<body>
  <!-- Place nav bar here-->
  <ul>
    <li><a href="http://www.nhicct.org/">Home</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="adminLogin.php">Admin Login</a></li>

  </ul>
  <!-- End of navbar -->
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                <!--  <img src="https://images.theconversation.com/files/102848/original/image-20151123-18264-j336wc.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=926&fit=clip" style="height: 100px; position: relative; left: 90px; margin-bottom:20px;" alt="nhic logo"> -->
                    <h2 class="title" style="text-align:center;">Create your account <i class="fa fa-user-circle fa-2x" style="color: #00d46a; text-align: right;"></i></h2>
                    <form method="POST" action="backend/acctCreation.php" autocomplete="off">
                      <?php
                      $webUrl = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                      if(strpos($webUrl, "emptyFields")){
                        echo '<p style="background-color: #d9534f; font-size: 25px; color: #fff; font-weight: bolder;"> All fields are required <i class="fa fa-exclamation-circle"></i></p>';
                      }
                      else if(strpos($webUrl, "invalidEmail")){
                        echo '<p style="background-color: #d9534f; font-size: 25px; color: #fff; font-weight: bolder;">Email entered is not valid <i class="fa fa-exclamation-circle"></i></p>';

                      }
                       else if(strpos($webUrl, "invalidNum")){
                         echo '<p style="background-color: #d9534f; font-size: 25px; color: #fff; font-weight: bolder;">Phonenumber must be in this format: <br> xxx-xxx-xxxx <i class="fa fa-exclamation-circle"></i></p>';

                       }
                       else if(strpos($webUrl, "invalidPassword")){
                         echo '<p style="background-color: #d9534f; font-size: 25px; color: #fff; font-weight: bolder;">Password must meet the following requirements <i class="fa fa-exclamation-circle"></i></p>
                         <ul style="background-color: #000; color: #fff; word-spacing: 4px;">
                         <li>Must be at least 8 characters long</li><br>
                         <li>Must have at least 1 UPPERCASE letter</li><br>
                         <li>Must have at least 1 number</li><br>
                         <li>Must have at least 1 special character</li>
                         </ul>
                         ';

                       }
                       else if(strpos($webUrl, "passwordsNotMatched")){
                         echo '<p style="background-color: #d9534f; font-size: 25px; color: #fff; font-weight: bolder;">Both passwords must match <i class="fa fa-exclamation-circle"></i></p>';

                       }

                       else if(strpos($webUrl, "sqlError")){
                         echo '<p style="background-color: #f0ad4e; font-size: 25px; color: #fff; font-weight: bolder;">Error in SQL connection to database <i class="fa fa-exclamation-circle"></i></p>';

                       }
                       else if(strpos($webUrl, "secondSqlError")){
                         echo '<p style="background-color: #f0ad4e; font-size: 25px; color: #fff; font-weight: bolder;">Error in SQL connection to database <i class="fa fa-exclamation-circle"></i></p>';

                       }

                       else if(strpos($webUrl, "userExists")){
                         echo '<p style="background-color: #f0ad4e; font-size: 25px; color: #fff; font-weight: bolder;">Looks like you already have an account with us. Go ahead and login or reset password if forgotten <i class="fa fa-exclamation-circle"></i></p>';

                       }
                       else if(strpos($webUrl, "codeSendError")==TRUE){
                         echo '<p style="background-color: #f0ad4e; font-size: 25px; color: #fff; font-weight: bolder;">Somehow, the verification code was not sent to you, fill out the form and try again <i class="fa fa-exclamation-circle"></i></p>';

                       }
                       else if(strpos($webUrl, "pageNotReached")==TRUE){
                         echo '<p style="background-color: #f0ad4e";>Page was not reached <i class="fa fa-exclamation-circle"></i></p>';
                       }

                       else if(strpos($webUrl, "signupSuccess")){
                         echo '<p style="background-color: #5cb85c; font-size: 25px; color: #fff; font-weight: bolder;">Successfully created account, go ahead and login <i class="fa fa-check-circle"></i></p>';

                       }


                      ?>
                        <div class="row row-space">
                          <?php
                          if(isset($_GET['firstName'])){
                            $firstName = $_GET['firstName'];
                            echo '
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">first name</label>
                                    <input class="input--style-4" type="text" name="firstName" placeholder="Enter your first name" value='.$firstName.'>
                                </div>
                            </div>
                            ';
                          }
                          else{
                            echo '
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">first name</label>
                                    <input class="input--style-4" type="text" name="firstName" placeholder="Enter your first name">
                                </div>
                            </div>
                            ';
                          }
                          if(isset($_GET['lastName'])){
                            $lastName = $_GET['lastName'];
                            echo '
                            <div class="col-2">
                            <div class="input-group">
                            <label class="label">last name</label>
                            <input class="input--style-4" type="text" name="lastName"  placeholder="Enter your last name" value='.$lastName.'>
                            </div>
                            </div>
                            ';
                          }
                          else{
                            echo '
                                                        <div class="col-2">
                                                            <div class="input-group">
                                                                <label class="label">last name</label>
                                                                <input class="input--style-4" type="text" name="lastName" placeholder="Enter your last name">
                                                            </div>
                                                        </div>';
                          }
                          if(isset($_GET['email'])){

                          }
                          ?>

                        </div>
                        <div class="row row-space">
                          <?php
                          if(isset($_GET['email'])){
                            $email = $_GET['email'];
                          echo '
                          <div class="col-2">
                              <div class="input-group">
                                  <label class="label">Email</label>
                                  <div class="input-group-icon">
                                      <input class="input--style-4 form-control" type="text" name="email" value="'.$email.'" placeholder="name@example.com">
                                  </div>
                              </div>
                          </div>
                          ';
                          }
                          else{
                            echo '
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <div class="input-group-icon">
                                        <input class="input--style-4 form-control" type="text" name="email" placeholder="name@example.com">
                                    </div>
                                </div>
                            </div>
                            ';
                          }
                          if(isset($_GET['phoneNum'])){
                            $phoneNum = $_GET['phoneNum'];
                            echo '
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone number <i class="zmdi zmdi-help-outline zmdi-hc-lg" style="color: #0275d8;" title="Phone number must be in the format listed. Do not actually type x\'s"></i></label>
                                    <input class="input--style-4" type="text" id="txtnumber" name="phoneNum" placeholder="xxx-xxx-xxxx" value='.$phoneNum.'>
                                </div>

                            </div>
                            ';
                          }
                          else{
                            echo '<div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone number <i class="zmdi zmdi-help-outline zmdi-hc-lg" style="color: #0275d8;" title="Phone number must be in the format listed. Do not actually type x\'s"></i></label>
                                    <input class="input--style-4" type="text" id="txtnumber" name="phoneNum" placeholder="xxx-xxx-xxxx">
                                </div>

                            </div>';
                          }
                          ?>

                        </div>
                        <div class="row row-space">

                            <div class="col-2">
                              <label class="label">Password <i class="zmdi zmdi-help-outline zmdi-hc-lg" style="color: #0275d8;" title="Password must be at least 8 characters long, have one capital letter, one number, and one special character"></i></label>
                              <input type="password" class="input--style-4" name="password" placeholder="Create a password">
                            </div>
                            <div class="col-2">
                              <label class="label">Retype Password</label>
                              <input type="password" class="input--style-4" placeholder="Enter same password"name="retypePassword">
                            </div>

                        </div>

                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="createAcct">Create Account!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
