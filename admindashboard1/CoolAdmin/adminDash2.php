<?php
session_start();
require('../../backend/dbConfig.php');
if(isset($_SESSION['username'])){
  //
}
else{
  session_unset();
  session_destroy();
  header('Location: ../../adminLogin.php');
  exit();
}
$getUser = 'SELECT * FROM adminUsers WHERE username="'.$_SESSION['username'].'"';
$getQueryResults = mysqli_query($dbConn, $getUser);
if(mysqli_num_rows($getQueryResults) > 0){
  while($row = mysqli_fetch_assoc($getQueryResults)){
    $username = $_SESSION['username'] =$row['username'];
    $firstName = $_SESSION['firstName'] = $row['firstName'];
    $lastName = $_SESSION['lastName'] = $row['lastName'];
    $email = $_SESSION['email'] = $row['email'];
    $profile_pic = $_SESSION['profile_pic'] = $row['profile_pic'];
    $wallpaper_pic =$_SESSION['wallpaper_pic'] = $row['wallpaper_pic'];
    $profile_pic_status = $_SESSION['profile_pic_status'] =$row['profile_pic_status'];
    $wallpaper_pic_status = $_SESSION['wallpaper_pic_status'] =$row['wallpaper_pic_status'];
    $permissions = $_SESSION['permissions'] = $row['permissions'];
    switch($permissions){
      case 1:
      $admin_role = 'Board of Trustees';
      break;
      case 2:
      $admin_role = 'Executive Committee';
      break;
      case 3:
      $admin_role = 'Elections Committee';
      break;
      default:
      $admin_role = 'No admin role assigned';
      break;
    }
    if($profile_pic_status == 0){
      // if the status of the image is 0, meaning if the user did not yet upload an image
      $profile_img = "images/adminProfile.jpg";
    }
    else{
      $profile_img = 'https://img.wattpad.com/e63c8d607cd587671d6bbd7ae763f331aa7715be/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f44355f3632696d6a7675777664673d3d2d3734393534393434332e313561623438613662343061356630373437303030303134343937332e6a7067?s=fit&w=720&h=720';
    }
    if($wallpaper_pic_status ==0){
      $wallpaper_img ='assets/photos/victor-ene-1301123-unsplash.jpg';
    }
    else{
      $wallpaper_img = 'https://wallpaperaccess.com/full/225463.jpg';
    }



  }
}
$displayMessage= ''; // Greet user depending on time of day
// set timezone to be the current time zone of the NE region and display greeting based on that
date_default_timezone_set("America/New_York");

$currTime = date('H');

//Calculate the current time based on the date/time region that was set
// REMINDER TO UPDATE CODE FOR DAYLIGHT SAVINGS TIME
switch($currTime){
  case $currTime >=5 && $currTime <=11:
  $displayMessage ='<i class="fa fa-sun fa-2x text-warning"></i> <br> <p>Good Morning</p>';
  break;
  case $currTime >=12 && $currTime <=18:
  $displayMessage = '<i class="fas fa-cloud fa-2x" style="color:grey;"></i> <br> <p>Good Afternoon</p>';
  break;
  case $currTime >=19 || $currTime <=4:
  $displayMessage = '<i class="fa fa-moon fa-flip-horizontal text-dark fa-2x"></i> <br> <p>Good Evening</p>';
  break;
  default:
  $displayMessage = 'No timezone was set';
  break;


}
// get number of nhic members
$getNumMembers = 'SELECT * FROM nhicVoting WHERE verified=0';
$getResults = mysqli_query($dbConn, $getNumMembers);
$numMembers = mysqli_num_rows($getResults);

// Get the number of messages sent by members
$get_num_msgs = 'SELECT * FROM user_messages ORDER BY date_sent';
$results = mysqli_query($dbConn, $get_num_msgs);
$num_msgs = mysqli_num_rows($results);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Admin Dash</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
<!-- DataTables CSS-->
<link rel="stylesheet" media="all" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

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
.popup-overlay {
  /*Hides pop-up when there is no "active" class*/
  visibility: hidden;
  position: absolute;
  background: #ffffff;
  border: 3px solid #666666;
  width: 50%;
  height: 50%;
  left: 25%;
}

.popup-overlay.active {
  /*displays pop-up when "active" class is present*/
  visibility: visible;
  text-align: center;
}

.popup-content {
  /*Hides pop-up content when there is no "active" class */
  visibility: hidden;
}

.popup-content.active {
  /*Shows pop-up content when "active" class is present */
  visibility: visible;
}</style>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="section__content section__content--p35">
                <div class="header3-wrap">
                    <div class="header__logo">
                        <a href="">
                          <nav class="navbar-brand text-success" style="font-weight:700;">N H I C</nav>

                        </a>
                    </div>
                    <div class="header__navbar">
                        <ul class="list-unstyled">
                            <li class="has-sub">
                                <a href="adminDash2.php">
                                    <i class="fas fa-refresh"></i>Refresh Dashboard
                                    <span class="bot-line"></span>
                                </a>

                            </li>
                            <?php
                            if($permissions == 1 || $permissions == 2){
                              echo '
                              <li>
                                  <a href="createForm.php">
                                      <i class="fas fa-edit"></i>
                                      <span class="bot-line"></span>Create Form</a>
                              </li>
                              ';
                            }
                            else if($permissions == 3){
                              echo '
                              <li>

                                  <a id="open1" href="#">
                                      <i class="fas fa-user-plus"></i>
                                      <span class="bot-line"></span>Create Form</button>
                              </li>
                              </a>
                              ';
                            }

                             ?>
                            <?php if($permissions ==1 || $permissions == 2){
                              echo '
                              <li>
                                  <a href="register.php">
                                      <i class="fas fa-user-plus"></i>
                                      <span class="bot-line"></span>Add Admin Role</a>
                              </li>
                              ';
                            }
                            else if($permissions == 3){
                              echo '
                              <li>

                                  <a id="open2" href="#">
                                      <i class="fas fa-user-plus"></i>
                                      <span class="bot-line"></span>Add Admin Role</button>
                              </li>
                              </a>
                              ';
                            }
                            ?>

                            <li>
                                <a href="forget-pass.php">
                                    <i class="fas fa-lock"></i>
                                    <span class="bot-line"></span>Update My Password</a>
                            </li>


                        </ul>


                    </div>
                    <div class="header__tool">

                                              <div class="account-wrap">
                                                  <div class="account-item account-item--style2 clearfix js-item-menu">
                                                      <div class="image">
                                                          <img src="<?php echo $profile_img;?>" alt="Profile Image" />
                                                      </div>
                                                      <div class="content">
                                                          <a class="js-acc-btn" href="#"><?php echo $firstName. ' '. $lastName;?></a>
                                                      </div>
                                                      <div class="account-dropdown js-dropdown">
                                                          <div class="info clearfix">
                                                              <div class="image">
                                                                  <a href="#">
                                                                      <img src="<?php echo $profile_img;?>" alt="Profile Image" />
                                                                  </a>
                                                              </div>
                                                              <div class="content">
                                                                  <h5 class="name">
                                                                      <a href="#"><?php echo $firstName. ' '. $lastName;?></a>
                                                                  </h5>
                                                                  <span class="email"><?php echo $username;?></span><br>
                                                                      <span class="email"><?php echo $admin_role;?></span>
                                                              </div>
                                                          </div>
                                                          <div class="account-dropdown__body">
                                                              <div class="account-dropdown__item">
                                                                  <a href="../../edit_admin_profile.php">
                                                                      <i class="zmdi zmdi-account"></i>Account Settings</a>
                                                              </div>

                                                          </div>
                                                          <div class="account-dropdown__footer">
                                                              <a href="backend/adminLogout.php">
                                                                  <i class="zmdi zmdi-power"></i>Logout</a>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- HEADER MOBILE-->
        <header class="header-mobile header-mobile-2 d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="chart.html">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="table.html">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li>
                            <a href="calendar.html">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="login.html">Login</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="button.html">Button</a>
                                </li>
                                <li>
                                    <a href="badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="typo.html">Typography</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="sub-header-mobile-2 d-block d-lg-none">
            <div class="header__tool">
                <div class="header-button-item has-noti js-item-menu">
                    <i class="zmdi zmdi-notifications"></i>
                    <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                        <div class="notifi__title">
                            <p>You have 3 Notifications</p>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c1 img-cir img-40">
                                <i class="zmdi zmdi-email-open"></i>
                            </div>
                            <div class="content">
                                <p>You got a email notification</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c2 img-cir img-40">
                                <i class="zmdi zmdi-account-box"></i>
                            </div>
                            <div class="content">
                                <p>Your account has been blocked</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c3 img-cir img-40">
                                <i class="zmdi zmdi-file-text"></i>
                            </div>
                            <div class="content">
                                <p>You got a new file</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__footer">
                            <a href="#">All notifications</a>
                        </div>
                    </div>
                </div>
                <div class="header-button-item js-item-menu">
                    <i class="zmdi zmdi-settings"></i>
                    <div class="setting-dropdown js-dropdown">
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-account"></i>Account</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-globe"></i>Language</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-pin"></i>Location</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-email"></i>Email</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-notifications"></i>Notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="#"><?php echo $firstName. ' '. $lastName;?></a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#"><?php echo $firstName. ' '. $lastName; ?></a>
                                    </h5>
                                    <span class="email"><?php echo $email;?></span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                </div>
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="#">
                                    <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->

        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7">
            <!-- BREADCRUMB-->
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
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->

            <!-- WELCOME-->
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="title-4"><?php echo $displayMessage;?>
                                <span><?php echo $firstName; ?></span>
                            </h1>
                            <hr class="line-seprate">
                        </div>
                    </div>
                </div>
            </section>
            <!-- END WELCOME-->

            <!-- STATISTIC-->
            <section class="statistic statistic2">
                <div class="container">
                    <div class="row">
                      <?php
                      if($numMembers == 0){
                        echo '
                        <div class="col-md-6 col-lg-3">

                            <div class="statistic__item statistic__item--green">
                                <h2 class="number text-white font-weight-bold">'.$numMembers.'</h2>
                                <span class="desc font-weight-bold text-white">Unverified accounts</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>
                            </div>
                        </div>
                        ';
                      }
                      else{
                        echo '
                        <div class="col-md-6 col-lg-3">

                            <div class="statistic__item statistic__item--red">
                                <h2 class="number text-white font-weight-bold">'.$numMembers.'</h2>
                                <span class="desc font-weight-bold text-white">Unverified accounts</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>
                            </div>
                        </div>
                        ';
                      }
                      ?>

                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--orange">
                                <h2 class="number text-white font-weight-bold">0</h2>
                                <span class="desc text-white font-weight-bold">Votes In</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-border-color"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="statistic__item statistic__item--blue">
                                <h2 class="number text-white font-weight-bold"><?php echo DATE("F jS, Y");?></h2>
                                <span class="desc font-weight-bold text-white">Today's Date</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                          <div class="statistic__item statistic__item-- bg-dark">
                             <span class="desc text-white font-weight-bold">Voting Poll Actions</span><br>
                             <a class="btn btn-success text-center" href="">Turn on poll</a><br><br>
                             <a class="btn btn-danger text-center" href="">Turn off poll</a>

                             <div class="icon">
                                 <i class="fa fa-poll"></i>
                             </div>
                         </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <!-- STATISTIC CHART-->
            <section class="statistic-chart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title-5 m-b-35">Voting Statistics</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <!-- CHART-->
                            <div class="statistic-chart-1">
                                <h3 class="title-3 m-b-30">Bar Chart</h3>
                                <div class="container">
                                <div id="curve_chart"></div>
                              </div>
                                <div class="statistic-chart-1-note">
                                    <span class="big">300</span>
                                    <span>/ 500 people voted</span>
                                </div>
                            </div>
                            <!-- END CHART-->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- TOP CAMPAIGN-->
                            <div class="top-campaign">
                                <h3 class="title-3 m-b-30">Top Winners</h3>
                                <div class="table-responsive">
                                    <table class="table table-top-campaign">
                                        <tbody>
                                          <tr>
                                                    <td>1. Mike Charleson</td>
                                                    <td class="text-success">65 votes</td>
                                                </tr>
                                                <tr>
                                                    <td>2. Aiden Legend</td>
                                                    <td class="text-success">55 votes</td>
                                                </tr>
                                                <tr>
                                                    <td>3. Zack Forestall</td>
                                                    <td class="text-success"> 40 votes</td>
                                                </tr>
                                                <tr>
                                                    <td>4. Adam wuberger</td>
                                                    <td class="text-danger">30 votes</td>
                                                </tr>
                                                <tr>
                                                    <td>5. James Chadwick</td>
                                                    <td class="text-danger">25 votes</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END TOP CAMPAIGN-->
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <!-- CHART PERCENT-->
                            <div class="chart-percent-2">
                                <h3 class="title-3 m-b-30">Winners by %</h3>
                                <div class="chart-wrap">
                                  <div id="piechart" style="width: 350px; height: 300px;"></div>
                                    <div id="chartjs-tooltip">
                                        <table></table>
                                    </div>
                                </div>
                                <div class="chart-info">
                                    <div class="chart-note">
                                        <span class="dot dot--blue"></span>
                                        <span>President</span>
                                    </div>
                                    <div class="chart-note">
                                        <span class="dot dot--red"></span>
                                        <span>Vice President</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END CHART PERCENT-->
                        </div>
                    </div>
                </div>
            </section> -->
            <!-- END STATISTIC CHART-->

            <!-- DATA TABLE-->
            <section class="p-t-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <section class="p-t-20">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="table-data__tool">

                                 <div class="table-data__tool-right">
                                     <button class="au-btn au-btn-icon au-btn--blue au-btn--small" data-toggle="modal" data-target="#addUser">
                                         Add Member <i class="zmdi zmdi-plus"></i></button>
                                     <!--<div class="rs-select2--dark rs-select2--sm rs-select2--dark2">

                                         <div class="dropDownSelect2"></div>
                                     </div> -->
                                     <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary text-center" style="font-size: 35px;">Add Member <i class="far fa-user fa-lg"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <form action="backend/add_user.php" method="POST">


          <div class="form-row">
   <div class="form-group col-md-6">
     <label class="form-label font-weight-bold">First Name</label>
     <input type="text" class="form-control" name="firstName" placeholder="First Name">
   </div>
   <div class="form-group col-md-6">
     <label class="form-label font-weight-bold">Last Name</label>
     <input type="text" class="form-control" name="lastName" placeholder="Last Name">
   </div>
 </div>
 <div class="form-row">
 <div class="form-group col-md-6">
   <label class="form-label font-weight-bold">Email</label>
   <input type="text" class="form-control" name="email" placeholder="email@email.com">
 </div>
 <div class="form-group col-md-6">
   <label class="form-label font-weight-bold">Phone Number</label>
   <input type="text" class="form-control" name="phoneNum" placeholder="xxx-xxx-xxxx">
 </div>
</div>
 <div class="form-row">
   <div class="form-group col-md-6">
     <label class="form-label font-weight-bold">Password</label>
     <input type="password" class="form-control" name="password">
   </div>
   <div class="form-group col-md-6">
     <label class="form-label font-weight-bold">Confirm Password</label>
     <input type="password" class="form-control" name="confirm_pass">
   </div>
 </div>

 <button type="submit" name="addUser" class="btn btn-outline-primary">Add User</button>
        </form>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

</div>
                                 </div>
                             </div>
                             <div class="container mb-5 mt-3">
                               <?php
                               $url=  "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                               if(strpos($url, "itemDeleted") == true){
                                 echo '<p class="alert alert-success">Account was deleted <i class="fa fa-check-circle"></i></p>';
                               }
                               else if(strpos($url, "deletionError") == true){
                                 echo '<p class="alert alert-danger">Error in deleting that record <i class="fa fa-exclamation-circle"></i></p>';

                               }
                               ?>

                               <?php
                               require_once('../../backend/dbConfig.php');
                               $query = 'SELECT * FROM nhicVoting';
                               if($queryResult = mysqli_query($dbConn, $query)){
                                 if(mysqli_num_rows($queryResult) > 0){
                                   echo "<div class ='table-responsive-md'>";
                                   echo '<h1 class="h3 mb-2 text-gray-900 text-center" style="font-weight:700;">NHIC Members</h1>';
                                  echo '<h6 class="m-0 font-weight-bold text-success text-center" style="font-size: 18px;"> <div class="card-header">All Elegible NHIC Voters</div></h6>';
                                   echo '<p class="text-primary" style="font-weight:bold;">Export options</p>';
                                   echo '<table class="table table-hover" style="overflow-x: auto;"id="dataTable" width="100%" cellspacing="0">';
                                   echo '<thead class="text-light bg-primary">';
                                   echo '<tr>';
                                   echo '<th>First Name</th>';
                                   echo '<th>Last Name</th>';
                                   echo '<th>Email</th>';
                                   echo '<th>Phone Number</th>';
                                   echo '<th>Account Status</th>';
                                   echo '<th>Account Created On</th>';
                                   echo '<th>Delete Account</th>';
                                   //echo "<button type='submit' class='btn btn-success' name='updateCustInfo.php'>Update information</button>";
                                   //echo '<button type="submit" class="btn btn-danger" name="deleteCustomer.php">Delete this customer</button>';
                                   echo '</tr>';
                                   echo '</thead>';
                                   echo '<tbody>';
                                   while($row  = mysqli_fetch_array($queryResult)){
                                     $member_since = $row['member_since'];
                                     $verified = $row['verified'];
                                     if($verified == 0){
                                      $is_verified ='
                                      <p class="text-danger font-weight-bold">Not yet verified <i class="fa fa-exclamation-circle text-danger"></i> (user needs to verify via their email)</p>
                                       ';
                                     }
                                     else if($verified == 1){
                                       $is_verified= '
                                       <p class="text-success font-weight-bold">Account Verified <i class="fa fa-check-circle text-success"></i></p>
                                       ';
                                     }

                                     echo '<tr>';
                                     echo "<td>".$row['firstName']."</td>";
                                     echo "<td>".$row['lastName']."</td>";
                                     echo "<td>".$row['email']."</td>";
                                     echo "<td>".$row['phoneNum']."</td>";
                                     echo "<td>".$is_verified."</td>";
                                     echo "<td>". date("m/d/Y", strtotime($member_since));
                                     echo '<td><a style="text-decoration: none; background-color: red; color: white;"href="backend/deleteMember.php?userId='.$row['userId'].'" class="btn btn-danger">Delete User <i class="far fa-trash-alt fa-lg"></i></a></td>';
                                     echo "</tr>";

                                   }
                                   echo '</tbody>';
                                   echo '</table>';


                                     mysqli_free_result($queryResult);






                                 }

                                 else{
                                   echo '<div class="card-header py-3">
                                     <h6 class="m-0 font-weight-bold text-danger">There are no active members</h6>
                                   </div>';
                                   echo "<p class='lead'><em>No voters are signed up</em></p>";
                                 }
                               }
                               mysqli_close($dbConn);

                               ?>
                             </div>
                             <!-- Data Tables End-->
                        </div>
                    </div>
                </div>
            </section>
            <!-- END DATA TABLE-->

            <!-- COPYRIGHT-->
            <section class="p-t-60 p-b-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p style="font-weight:bolder;">Copyright © <?php echo DATE('Y');?> NHIC. All rights reserved. <!--Template by <a href="https://colorlib.com">Colorlib</a>.--></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END COPYRIGHT-->
        </div>

    </div>
    <!-- Modal popup-->
    <!-- Button trigger modal -->


    <!-- Jquery JS-->
    <!--<script src="vendor/jquery-3.2.1.min.js"></script> -->
    <!-- Bootstrap JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <!--<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script> -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<!--
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script>
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
// options to set for data tables
$(function (){
  $('#dataTable').DataTable({
    scrollY: 400,
    processing: true,
    paging:true,
    searching: true,
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    dom: 'Bftlip',
    buttons: [

     'csv', 'excel', 'pdf', 'print'

    ]

  });
});
$(function(){
  $('#restrictionPopup').modal({
    keyboard: false,
    focus: true,
    show: true,
    backdrop: true
  });

});
     </script>
     <script>
     $("#open1").on("click", function() {
       alert('Sorry but you do not have permission to access to this page');
});
$("#open2").on("click", function() {
  alert('Sorry but you do not have permission to access to this page');
});
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Month', 'Profit'],
     <?php
     $server = 'localhost';
     $username = 'root';
     $password = 'root';
     $dbName = 'userInfo';
     $conn = mysqli_connect($server, $username, $password, $dbName);
     $sql = "SELECT * FROM profitTable";
     $fire = mysqli_query($conn,$sql);
      while ($result = mysqli_fetch_assoc($fire)) {
        echo"['".$result['month']."', ".$result['profit']."],";
      }

     ?>
    ]);

    var options = {
      title: 'Annual Profit',
      width: 300,
      height: 300,
      curveType: 'function',
      legend: {position: 'bottom'},
      bars: 'vertical',
      bar: {groupWidth: '90%'}
    };

    var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
  }
</script>
<!-- Donut chart JS-->
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Month', 'Profit'],
     <?php
     $server = 'localhost';
     $username = 'root';
     $password = 'root';
     $dbName = 'userInfo';
     $conn = mysqli_connect($server, $username, $password, $dbName);
     $sql = "SELECT * FROM profitTable";
     $fire = mysqli_query($conn,$sql);
      while ($result = mysqli_fetch_assoc($fire)) {
        echo"['".$result['month']."', ".$result['profit']."],";
      }

     ?>
    ]);

    var options = {
      title: 'Annual Profit by percentage',
      width: 350,
      height: 400

    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
