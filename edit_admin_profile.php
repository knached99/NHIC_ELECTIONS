
<?php
session_start();
require('backend/dbConfig.php');
if(isset($_SESSION['username'])){
  //
}
else{
  //header('Location: login.php');
  session_unset();
  session_destroy();
  header('Location: adminLogin.php');
  exit();
}
$getUser = 'SELECT * FROM adminUsers WHERE username="'.$_SESSION['username'].'"';
$getQueryResults = mysqli_query($dbConn, $getUser);
$wallpaper_img = '';
$profile_img = '';
if(mysqli_num_rows($getQueryResults) > 0){
  while($row = mysqli_fetch_assoc($getQueryResults)){
    $firstName = $_SESSION['firstName'] = $row['firstName'];
    $lastName = $_SESSION['lastName'] = $row['lastName'];
    $email = $_SESSION['email'] = $row['email'];
    $phoneNum = $_SESSION['phone_num'] = $row['phone_num'];
    $username = $_SESSION['username'] = $row['username'];
    $profile_pic = $_SESSION['profile_pic'] = $row['profile_pic'];
    $wallpaper_pic =$_SESSION['wallpaper_pic'] = $row['wallpaper_pic'];
    $wallpaper_pic_status = $_SESSION['wallpaper_pic_status'] =$row['wallpaper_pic_status'];
    $profile_pic_status = $_SESSION['profile_pic_status'] =$row['profile_pic_status'];
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
      //check status of wallpaper image
      // if user has not uploaded an image, display default wallpaper
      // otherwise, display whatever the user uploaded
      $profile_img = "assets/images/adminProfile.jpg";
    }
    else{
      $profile_img = 'https://img.wattpad.com/e63c8d607cd587671d6bbd7ae763f331aa7715be/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f44355f3632696d6a7675777664673d3d2d3734393534393434332e313561623438613662343061356630373437303030303134343937332e6a7067?s=fit&w=720&h=720';
    }
    if($wallpaper_pic_status ==0){
      $wallpaper_img ='assets/photos/victor-ene-1301123-unsplash.jpg';
    }
    else{
      $wallpaper_img = 'https://dynaimage.cdn.cnn.com/cnn/c_fill,g_auto,w_1200,h_675,ar_16:9/https%3A%2F%2Fcdn.cnn.com%2Fcnnnext%2Fdam%2Fassets%2F200910093826-knoxville-skyline-stock.jpg';
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
  $displayMessage ='Good Morning';
  break;
  case $currTime >=12 && $currTime <=18:
  $displayMessage = 'Good Afternoon';
  break;
  case $currTime >=19 || $currTime <=4:
  $displayMessage = 'Good Evening';
  break;
  default:
  $displayMessage = 'No timezone was set';
  break;


}


?>
<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Edit Admin Profile
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="styling/lightDash/bootstrap.min.css" rel="stylesheet" />
  <link href="styling/lightDash/paper-dashboard.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="styling/lightDash/edit_admin_profile.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper bg-dark">
    <div class="sidebar" data-color="black" data-active-color="success">
      <div class="logo text-uppercase">
        <small class="simple-text font-weight-bold">
          <?php echo $displayMessage?><br>
          <?php echo $firstName;?>

        </small>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->

      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="admindashboard1/CoolAdmin/adminDash2.php">
              <i class="fa fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>


          <li class="active">
            <a href="edit_admin_profile.php">
              <i class="fa fa-user"></i>
              <p>My Profile</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <p class="navbar-brand">NHIC</p>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fa fa-search"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">

              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-cog"></i>
                  <p>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="backend/adminlogout.php">Logout <i class="fa fa-sign-out"></i></a>

                </div>
              </li>

            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="<?php echo $wallpaper_img; ?>" alt="Background Wallpaper">
              </div>
              <div class="card-body">
                <div class="author">

                    <img class="avatar border-gray" src="<?php echo $profile_img;?>" alt="Profile Pic">
                    <h5 class="title text-primary"><?php echo $firstName . ' '.$lastName;?></h5>

                  <p class="description font-weight-bold">
                    @<?php echo $username;?>
                  </p>
                </div>

              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h4 class="card-title font-weight-bold text-center text-dark">NHIC Administrators</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled team-members">

                    <?php
                    $getAdmins = 'SELECT * FROM adminUsers ORDER BY firstName';
                    $results = mysqli_query($dbConn, $getAdmins);
                    $admin_profile_pic = $row['profile_img'];
                    $admin_profile_pic_status = $row['profile_pic_status'];
                    if($admin_profile_pic_status == 0){
                      $admin_profile_img ='assets/images/adminProfile.jpg';
                    }
                    else {
                      $admin_profile_img = $admin_profile_pic;
                    }

                    if(mysqli_num_rows($results) > 0){
                      while($row = mysqli_fetch_assoc($results)){

                      echo '
                      <li>
                      <div class="row">
                      <div class="col-md-2 col-2">
                      <div clas="avatar">
                      <img src='.$admin_profile_img.' alt="Admin Profile" class="img-fluid rounded-circle img-no-padding img-responsive">
                      </div>
                      </div>
                      <div class="col-md-7 col-7">
                        '.
                        $row['firstName']. ' '. $row['lastName'].
                        '

                      </div>
                      <div class="btn btn-sm-outline-success btn-round btn-icon">
                     <a href= "mailto: '.$row['email'].'"><i class="fa fa-envelope text-success" title="Send '.$row['firstName'].' an email"></i></a>

                      </div>

                      </div>
                      </li>


                      ';
                      }
                    }

                    ?>



                </ul>
              </div>
            </div>
            <!-- Start of password update card-->
            <!--
            <div class="card pull-center">
              <div class="Card-header">
                <h4 class="card-title text-center">Update Password <i class="fa fa-lock"></i></h4>
              </div>
              <div class="card-body">
                <form action="backend/update_admin_pwd.php" method="POST">
                  <div class="row">
                    <div class="col-sm-6 pr-1">
                      <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" placeholder="*******" name="currPwd">
                      </div>
                  </div>
                  <div class="col-sm-6 pr-1">
                    <div class="form-group">
                      <label class="form-label">New Password</label>
                      <input type="password" class="form-control" placeholder="*******" name="currPwd">
                    </div>
                </div>
                <div class="col-sm-6 pr-1">
                  <div class="form-group">
                    <label class="form-label">Retype New Password</label>
                    <input type="password" class="form-control" placeholder="*******" name="currPwd">
                  </div>
              </div>
              <div class="update ml-auto mr-auto">
                  <button type="submit" class="btn btn-info btn-round" name="updatePwd">Update Profile</button>
                </div>



                  </div>
                </form>
              </div>
            </div> -->
            <!-- end of password update card -->

          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title text-dark font-weight-bold">Edit Profile <i class="fa fa-edit font-weight-bold text-dark"></i></h5>
              </div>
              <div class="card-body">
                <form action="backend/update_admin_profile.php" method="POST">
                  <?php
                  $webUrl = "http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
                  if(strpos($webUrl, "usernameLen")==TRUE){
                    echo '<p class="font-weight-bold alert alert-danger">Username length must be less than 15 characters or greater than 0 <i class = "fa fa-exclamation-circle"></i></p>';
                  }
                  else if(strpos($webUrl, "numberInvalid")==TRUE){
                    echo '<p class="font-weight-bold alert alert-danger">Phone number must be in this format:<br>xxx-xxx-xxxx <i class = "fa fa-exclamation-circle"></i></p>';

                  }
                  else if(strpos($webUrl, "invalidEmail")==TRUE){
                    echo '<p class="font-weight-bold alert alert-danger">Email is not valid <i class = "fa fa-exclamation-circle"></i></p>';

                  }
                  else if(strpos($webUrl, "queryError") == TRUE){
                    echo '<p class="font-weight-bold alert alert-warning">Unable to proccess your request at this time. Try again later <i class = "fa fa-exclamation-circle"></i></p>';

                  }
                  else if(strpos($webUrl, "queryErrorTwo") == TRUE){
                    echo '<p class="font-weight-bold alert alert-warning">Unable to proccess your request at this time. If this happens again, contact the developer <i class = "fa fa-exclamation-circle"></i></p>';

                  }
                  else if(strpos($webUrl, "updateFailed") == TRUE){
                    echo '<p class="font-weight-bold alert alert-info">Contact the developer for more info regarding why we cannot update your profile at this time <i class = "fa fa-exclamation-circle"></i></p>';

                  }
                  else if(strpos($webUrl, "updateSuccess") == TRUE){
                    echo '<p class="font-weight-bold alert alert-success"> Successfully updated your profile info <i class = "fa fa-check-circle"></i></p>';

                  }
                  ?>
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label class="font-weight-bold">Organization</label>
                        <input type="text" class="form-control bg-success text-light" style="font-weight:600;" disabled="" placeholder="Organization name" value="NHIC">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label class="font-weight-bold">Username</label>
                        <input type="text" readonly class="form-control" placeholder="Username" name="username"value="<?php echo $username;?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label class="font-weight-bold" for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" placeholder="Email" name="email"value="<?php echo $email;?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label class="font-weight-bold">First Name</label>
                        <input type="text" class="form-control" readonly placeholder="Firstname" value="<?php echo $firstName;?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label class="font-weight-bold">Last Name</label>
                        <input type="text" class="form-control" readonly placeholder="Last Name" value="<?php echo $lastName;?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="font-weight-bold">Phone Number</label>
                        <input type="text" class="form-control" placeholder="xxx-xxx-xxx" name="phone_num"value="<?php echo $phoneNum;?>">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="font-weight-bold">Position</label>
                        <input type="text" class="form-control" readonly placeholder="Admin Role" name="admin_role"value="<?php echo $admin_role;?>">
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="updateProfile"class="btn btn-info btn-round">Update Profile</button>
                    </div>


                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">

            <div class="credits ml-auto pull-left">
              <span class="copyright pull-left font-weight-bold">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, NHIC
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Custom JS script -->
  <script>

    $(document).ready(function() {

      $sidebar = $('.sidebar');
      $sidebar_img_container = $sidebar.find('.sidebar-background');

      $full_page = $('.full-page');

      $sidebar_responsive = $('body > .navbar-collapse');
      sidebar_mini_active = false;

      window_width = $(window).width();

      fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

      // if( window_width > 767 && fixed_plugin_open == 'Dashboard' ){
      //     if($('.fixed-plugin .dropdown').hasClass('show-dropdown')){
      //         $('.fixed-plugin .dropdown').addClass('show');
      //     }
      //
      // }

      $('.fixed-plugin a').click(function(event) {
        // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
        if ($(this).hasClass('switch-trigger')) {
          if (event.stopPropagation) {
            event.stopPropagation();
          } else if (window.event) {
            window.event.cancelBubble = true;
          }
        }
      });

      $('.fixed-plugin .active-color span').click(function() {
        $full_page_background = $('.full-page-background');

        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('color');

        if ($sidebar.length != 0) {
          $sidebar.attr('data-active-color', new_color);
        }

        if ($full_page.length != 0) {
          $full_page.attr('data-active-color', new_color);
        }

        if ($sidebar_responsive.length != 0) {
          $sidebar_responsive.attr('data-active-color', new_color);
        }
      });

      $('.fixed-plugin .background-color span').click(function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var new_color = $(this).data('color');

        if ($sidebar.length != 0) {
          $sidebar.attr('data-color', new_color);
        }

        if ($full_page.length != 0) {
          $full_page.attr('filter-color', new_color);
        }

        if ($sidebar_responsive.length != 0) {
          $sidebar_responsive.attr('data-color', new_color);
        }
      });

      $('.fixed-plugin .img-holder').click(function() {
        $full_page_background = $('.full-page-background');

        $(this).parent('li').siblings().removeClass('active');
        $(this).parent('li').addClass('active');


        var new_image = $(this).find("img").attr('src');

        if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
          $sidebar_img_container.fadeOut('fast', function() {
            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $sidebar_img_container.fadeIn('fast');
          });
        }

        if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
          var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

          $full_page_background.fadeOut('fast', function() {
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
            $full_page_background.fadeIn('fast');
          });
        }

        if ($('.switch-sidebar-image input:checked').length == 0) {
          var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
          var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

          $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
          $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
        }

        if ($sidebar_responsive.length != 0) {
          $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
        }
      });

      $('.switch-sidebar-image input').on("switchChange.bootstrapSwitch", function() {
        $full_page_background = $('.full-page-background');

        $input = $(this);

        if ($input.is(':checked')) {
          if ($sidebar_img_container.length != 0) {
            $sidebar_img_container.fadeIn('fast');
            $sidebar.attr('data-image', '#');
          }

          if ($full_page_background.length != 0) {
            $full_page_background.fadeIn('fast');
            $full_page.attr('data-image', '#');
          }

          background_image = true;
        } else {
          if ($sidebar_img_container.length != 0) {
            $sidebar.removeAttr('data-image');
            $sidebar_img_container.fadeOut('fast');
          }

          if ($full_page_background.length != 0) {
            $full_page.removeAttr('data-image', '#');
            $full_page_background.fadeOut('fast');
          }

          background_image = false;
        }
      });


      $('.switch-mini input').on("switchChange.bootstrapSwitch", function() {
        $body = $('body');

        $input = $(this);

        if (paperDashboard.misc.sidebar_mini_active == true) {
          $('body').removeClass('sidebar-mini');
          paperDashboard.misc.sidebar_mini_active = false;
        } else {
          $('body').addClass('sidebar-mini');
          paperDashboard.misc.sidebar_mini_active = true;
        }

        // we simulate the window Resize so the charts will get updated in realtime.
        var simulateWindowResize = setInterval(function() {
          window.dispatchEvent(new Event('resize'));
        }, 180);

        // we stop the simulation of Window Resize after the animations are completed
        setTimeout(function() {
          clearInterval(simulateWindowResize);
        }, 1000);

      });

    });

  </script>
  <!--   Core JS Files   -->
  <script src="js/lightJs/core/jquery.min.js"></script>
  <script src="js/lightJs/core/popper.min.js"></script>
  <script src="js/lightJs/core/bootstrap.min.js"></script>
  <script src="js/lightJs/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="js/lightJs/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="js/lightJs/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="js/lightJs/paper-dashboard.min.js" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="js/lightJs/edit_admin_profile.js"></script>
</body>

</html>
