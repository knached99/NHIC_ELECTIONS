
<?php
session_start();
require('backend/dbConfig.php');
if(isset($_SESSION['email'])){
  //
}
else{
  header('Location: login.php');
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit();
}

$getUser = 'SELECT * FROM nhicVoting WHERE email="'.$_SESSION['email'].'"';
$profile_img = '';
$wallpaper_img = '';
$getQueryResults = mysqli_query($dbConn, $getUser);
if(mysqli_num_rows($getQueryResults) > 0){
  while($row = mysqli_fetch_assoc($getQueryResults)){
    $firstName = $_SESSION['firstName'] = $row['firstName'];
    $lastName = $_SESSION['lastName'] = $row['lastName'];
    $email = $_SESSION['email'] = $row['email'];
    $phoneNum = $_SESSION['phoneNum'] = $row['phoneNum'];
    $profile_img = $_SESSION['profile_img'] = $row['profile_img'];
    $profile_img_status = $_SESSION['profile_img_status'] =$row['profile_img_status'];
    $member_since = $_SESSION['member_since'] = $row['member_since'];
    date_default_timezone_set('America/New_York');
    if($profile_img_status == 0){
      $profile_img = 'https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg';
    }
    else{
      $profile_img = 'https://gossipgist.com/uploads/28006/chase-hudson-fanjoy.jpg';
    }


  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Member Dashboard</title>
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="<?php echo $profile_img?>" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo 'Hi, '.$firstName;?></h2><span><?php echo $email;?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="memberDashboard.php" class="brand-small text-center"> <strong class="text-success">M</strong><strong class="text-success">B</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Dash Menu</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">
            <li><a href="memberDashboard.php"> <i class="fa fa-home"></i>Home</a></li>
            <li><a href="editProfile.php"> <i class="fa fa-user"></i>Edit Profile                             </a></li>
            <li><a href="votingHistory.php"> <i class="fa fa-history"></i>My Voting History                             </a></li>
            <li><a href="message_admin.php"><i class="fa fa-comment"></i>Message Admin</a></li>
          </ul>
        </div>

      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars fa-2x"> </i></a><a href="memberDashboard.php" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>My </span><strong class="text-success">Dashboard</strong></div></a></div>
                  <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <!-- Notifications dropdown-->
                    <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-info">0</span></a>
                      <ul aria-labelledby="notifications" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item">
                            <div class="notification d-flex justify-content-between">
                              <div class="notification-content"><i class="fa fa-envelope"></i>You have 0 new messages </div>
                            </div></a></li>

                      </ul>
                    </li>
                    <!-- Messages dropdown-->
                    <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge badge-danger">0</span></a>
                      <ul aria-labelledby="notifications" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                            <div class="msg-profile"> <i class="fa fa-user fa-lg text-secondary"></i></div>
                            <div class="msg-body">
                              <h3 class="h5">You have no new messages</h3>
                            </div></a></li>
                      </ul>
                    </li>
                <!-- Languages dropdown    -->

                <!-- Log out-->
                <li class="nav-item"><a href="backend/logout.php" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Counts Section -->
      <!--
      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            <!-- Count item widget-->

            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name"><strong class="text-uppercase">New Clients</strong><span>Last 7 days</span>
                  <div class="count-number">25</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Work Orders</strong><span>Last 5 days</span>
                  <div class="count-number">400</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name"><strong class="text-uppercase">New Quotes</strong><span>Last 2 months</span>
                  <div class="count-number">342</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-bill"></i></div>
                <div class="name"><strong class="text-uppercase">New Invoices</strong><span>Last 2 days</span>
                  <div class="count-number">123</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list"></i></div>
                <div class="name"><strong class="text-uppercase">Open Cases</strong><span>Last 3 months</span>
                  <div class="count-number">92</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <!--
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list-1"></i></div>
                <div class="name"><strong class="text-uppercase">New Cases</strong><span>Last 7 days</span>
                  <div class="count-number">70</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    -->
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            <!--
            <div class="col-lg-3 col-md-6">
              <div class="card to-do">
                <h2 class="display h4">To do List</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <ul class="check-lists list-unstyled">
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-1" name="list-1" class="form-control-custom">
                    <label for="list-1">Similique sunt in culpa qui officia</label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-2" name="list-2" class="form-control-custom">
                    <label for="list-2">Ed ut perspiciatis unde omnis iste</label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-3" name="list-3" class="form-control-custom">
                    <label for="list-3">At vero eos et accusamus et iusto </label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-4" name="list-4" class="form-control-custom">
                    <label for="list-4">Explicabo Nemo ipsam voluptatem</label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-5" name="list-5" class="form-control-custom">
                    <label for="list-5">Similique sunt in culpa qui officia</label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-6" name="list-6" class="form-control-custom">
                    <label for="list-6">At vero eos et accusamus et iusto </label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-7" name="list-7" class="form-control-custom">
                    <label for="list-7">Similique sunt in culpa qui officia</label>
                  </li>
                  <li class="d-flex align-items-center">
                    <input type="checkbox" id="list-8" name="list-8" class="form-control-custom">
                    <label for="list-8">Ed ut perspiciatis unde omnis iste</label>
                  </li>
                </ul>
              </div>
            </div>
          -->
            <!-- Pie Chart-->
            <!--
            <div class="col-lg-3 col-md-6">
              <div class="card project-progress">
                <h2 class="display h4">Project Beta progress</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <div class="pie-chart">
                  <canvas id="pieChart" width="300" height="300"> </canvas>
                </div>
              </div>
            </div>
          -->
            <!-- Line Chart -->
            <!--
            <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
              <div class="card sales-report">
                <h2 class="display h4">You Have not voted yet</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet officiis</p>
                <div class="line-chart">
                  <canvas id="lineCahrt"></canvas>
                </div>
              </div>
            </div>
          -->

          </div>
        </div>
      </section>
      <!-- Statistics Section-->
      <section class="statistics">
        <div class="container-fluid">
          <div class="row d-flex">
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center bg-light shadow-lg p-3 mb-5 bg-light rounded">
                <div class="icon"><i class="fa fa-user text-primary"></i></div>
                <div class="number" style="font-weight:700;"><?php echo $firstName . ' '. $lastName;?></div><strong class="text-primary"><?php echo $email;?></strong>
                <p style="color: #000;"><?php echo $phoneNum;?></p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center bg-light shadow-lg p-3 mb-5 bg-light rounded">
                <div class="icon"><i class="fa fa-calendar text-primary"></i></div>
                <div class="number text-dark" style="font-weight: 700;">Member Since</div><strong class="text-success"><?php echo date("F jS, Y", strtotime($member_since));?></strong>
              </div>
            </div>
            <!--
            <div class="col-lg-4">
              <!-- Monthly Usage-->
              <!--
              <div class="card income text-center">
                <h2 class="display h4">Member Since</h2>
                <div class="row d-flex align-items-center">
                  <i class="fa fa-calendar fa-3x" style="position: relative; left: 40px;"></i>
                  <!--
                  <div class="col-sm-6">
                    <div id="progress-circle" class="d-flex align-items-center justify-content-center"></div>
                  </div> -->
                  <!--
                  <div class="col-sm-6"><strong class="text-dark" style="text-align: center; align-items: center; align-content: center; position: absolute; left: 40px;"><?php echo $member_since;?></strong></div>
                </div>
              </div>
            </div>
          -->
            <div class="col-lg-4">
              <!-- User Actibity-->
              <div class="card user-activity bg-light shadow-lg p-3 mb-5 bg-light rounded">
                <h2 class="display h4">Voting History</h2>
                <div class="number"></div>
                  <i class="fa fa-history fa-3x text-primary"></i>
                <h3 class="h4 display text-dark">To view voting history, click on the <b style="text-decoration: none; color: #ff4c05;">my voting history</b> tab</h3>
                <!--<div class="progress">
                  <div role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>-->

              </div>
            </div>
          </div>
        </div>
      </section>

      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p class="text-success">NHIC &copy; 1983-<?php echo DATE('Y');?></p>
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
    <!-- Main File-->
    <script src="JavaScript/front.js"></script>
    <!-- Tooltip jQuery JS-->
    <script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

     </script>
  </body>
</html>
