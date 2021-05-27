
<?php
session_start();
require('backend/dbConfig.php');
if(isset($_SESSION['username'])){
  //
}
else{
  header('Location: adminLogin.php');
  session_unset();
  session_destroy();
  header('Location: adminLogin.php');
  exit();
}
$getUser = 'SELECT * FROM adminUsers WHERE username="'.$_SESSION['username'].'"';
$getQueryResults = mysqli_query($dbConn, $getUser);
if(mysqli_num_rows($getQueryResults) > 0){
  while($row = mysqli_fetch_assoc($getQueryResults)){
    $username = $_SESSION['username'] =$row['username'];
    $firstName = $_SESSION['firstName'] = $row['firstName'];
    $lastName = $_SESSION['lastName'] = $row['lastName'];
    $profile_pic = $_SESSION['profile_pic'] = $row['profile_pic'];
    $wallpaper_pic =$_SESSION['wallpaper_pic'] = $row['wallpaper_pic'];
    $profile_pic_status = $_SESSION['profile_pic_status'] =$row['profile_pic_status'];
    $wallpaper_pic_status = $_SESSION['wallpaper_pic_status'] =$row['wallpaper_pic_status'];
    $permissions = $_SESSION['permissions'] = $row['permissions'];
    if($profile_pic_status == 0){
      // if the status of the image is 0, meaning if the user did not yet upload an image
      $profile_img = "assets/images/adminProfile.jpg";
    }
    else{
      $profile_img = 'https://go.southernct.edu/homecoming/images/homecoming2020-bg-mobile.jpg';
    }
    if($wallpaper_pic_status ==0){
      $wallpaper_img ='assets/photos/victor-ene-1301123-unsplash.jpg';
    }
    else{
      $wallpaper_img = 'https://wallpaperaccess.com/full/225463.jpg';
    }


    date_default_timezone_set('America/New_York');

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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="styling/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="styling/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="styling/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="styling/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="styling/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="styling/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="styling/memberDashboard.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="assets/nhicLogoFavicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="font-awesome.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Data tables CDN Link -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style>

    i.fa-calendar{
      color: #000;
    }
    i.fa-envelope:hover{
      color: #3abffc;
    }
    i.fa-bell:hover{
      color: #ffd21f;
    }

    </style>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- Side Navbar -->
    <nav class="side-navbar bg-dark">
      <div class="side-navbar-wrapper bg-dark">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center bg-dark">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center bg-dark"><img src="<?php echo $profile_img;?>" alt="Admin" class="img-fluid rounded-circle">
            <p class="h5"><?php echo $displayMessage .' , '.$firstName;?></p><span class="text-light"><?php echo $username;?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="adminDash.php" class="brand-small text-center"> <strong class="text-success">M</strong><strong class="text-success">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading text-light">Dash Menu</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">
            <li><a href="adminDash.php"> <i class="fa fa-home"></i>Home</a></li>
            <li><a href="edit_admin_profile.php"> <i class="fa fa-user"></i>My Profile</a></li>
            <li><a href="nhicMembers.php"><i class="fa fa-database"></i>All NHIC Members</a></li>
          </ul>
        </div>

      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar bg-dark">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" class="menu-btn"><i class="fa fa-bars fa-2x"></i></a><a href="adminDash.php" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>My </span><strong class="text-success">Dashboard</strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Notifications dropdown-->
                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning">12</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item">
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-envelope"></i>You have 6 new messages </div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item">
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item">
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-upload"></i>Server Rebooted</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item">
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>10 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a></li>
                  </ul>
                </li>
                <!-- Messages dropdown-->
                <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge badge-info">10</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                        <div class="msg-profile"> <img src="assets/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Jason Doe</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                        <div class="msg-profile"> <img src="assets/avatar-2.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Frank Williams</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                        <div class="msg-profile"> <img src="assets/avatar-3.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Ashley Wood</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-envelope"></i>Read all messages    </strong></a></li>
                  </ul>
                </li>
                <!-- Languages dropdown    -->

                <!-- Log out-->
                <li class="nav-item"><a href="backend/adminLogout.php" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Data Tables Start -->
      <div class="container mb-5 mt-3">
        <?php
        require_once('backend/dbConfig.php');
        $query = 'SELECT * FROM nhicVoting';
        if($queryResult = mysqli_query($dbConn, $query)){
          if(mysqli_num_rows($queryResult) > 0){
            echo "<div class ='table-responsive'>";
            echo '<h1 class="h3 mb-2 text-gray-900" style="font-weight:700;">NHIC Members Database</h1>';
            echo '<div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success">Currently Active NHIC Voters</h6>
            </div>';
            echo '<table class="table table-bordered" id="dataTable" width="100%%" cellspacing="0">';
            echo '<thead class="text-light bg-primary">';
            echo '<tr>';
            echo '<th>First Name</th>';
            echo '<th>Last Name</th>';
            echo '<th>Email</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Account Verified</th>';
            echo '<th>Account Created On</th>';
            //echo "<button type='submit' class='btn btn-success' name='updateCustInfo.php'>Update information</button>";
            //echo '<button type="submit" class="btn btn-danger" name="deleteCustomer.php">Delete this customer</button>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row  = mysqli_fetch_array($queryResult)){
              $member_since = $row['member_since'];
              $verified = $row['verified'];
              if($verified == 1){
                $is_verified ='<p class="text-success">Yes <i class="fa fa-check-circle text-success"></i></p>';
              }
              else{
                $is_verified = '<p class="text-danger">No <i class="fa fa-exclamation-circle text-danger"></i> (user needs to verify via their email)</p>';
              }
              echo '<tr>';
              echo "<td>".$row['firstName']."</td>";
              echo "<td>".$row['lastName']."</td>";
              echo "<td>".$row['email']."</td>";
              echo "<td>".$row['phoneNum']."</td>";
              echo "<td>".$is_verified."</td>";
              echo "<td>". date("m/d/Y", strtotime($member_since));
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
        mysqli_close($connectToDb);

        ?>
      </div>
      <!-- Data Tables End-->
      <footer class="main-footer bg-light" style="width: 100%;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p class="text-dark">New Haven Islamic Center &copy; 1983-<?php echo DATE('Y');?></p>
            </div>
            <div class="col-sm-6 text-right">
              <!--
              <p>Design by <a href="https://bootstrapious.com/p/bootstrap-4-dashboard" class="external">Bootstrapious</a></p> -->
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions and it helps me to run Bootstrapious. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- JavaScript files-->
    <script src="JavaScript/jquery.min.js"></script>
    <script src="JavaScript/bootstrap.bundle.min.js"></script>
    <script src="JavaScript/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="JavaScript/jquery.cookie.js"> </script>
    <script src="JavaScript/Chart.min.js"></script>
    <script src="JavaScript/jquery.validate.min.js"></script>
    <script src="JavaScript/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="JavaScript/charts-home.js"></script>
    <!-- BOOTSTRAP Files -->

    <!-- DataTables Files -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Main File-->
    <script src="JavaScript/front.js"></script>
    <!-- Tooltip jQuery JS-->
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
    searching: true
  });
});

     </script>
  </body>
</html>
