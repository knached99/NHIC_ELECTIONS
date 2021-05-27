"
<!DOCTYPE HTML>
<html lang ='en' dir="ltr">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<?php
if(isset($_GET['reset_key'])){
  $reset_key = $_GET['reset_key'];
  require('backend/dbConfig.php');
  $verifyAccount = $dbConn->query('SELECT reset_verified, reset_key FROM adminUsers WHERE reset_verified =0 AND vKey="'.$vKey.'"');
  if($verifyAccount -> num_rows == 1){
    $updateAccount = $dbConn->query('UPDATE adminUsers SET reset_verified=1 WHERE reset_key="'.$reset_key.'"');
    if($updateAccount){
      header('Location: ../../adminLogin.php?password_reset_success');
    }
    else{
      echo $dbConn->error;
    }
  }
  else{
    echo '
    <html>
<head>
	<meta charset="UTF-8">
  <title>Account Verification</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic&subset=latin,cyrillic" rel="stylesheet" type="text/css" />
	<link href="/404.css" media="all" rel="stylesheet" type="text/css" />
  <link href="/favicon.png" rel="shortcut icon" type="image/vnd.microsoft.icon">
  <style>

html, body{
  height: 100%;
}

body {
	background: #2f4256 url("http://freelansim.ru/images/service_pattern.png")repeat 0 0;
	text-align: center;
	font-family: "PT Sans", Verdana, sans-serif;
	margin: 0;
	padding:0;
  overflow: hidden;
  display: table;
  min-width: 100%;
}
a:hover{
  text-decoration: none;
  font-weight: 900;
  color: #fff;
}
.layout{
	width: 400px;
	margin: 0 auto;
  margin: 0;
  display: table-cell;
  vertical-align: middle;
  height: 100%;
}

.logo{
	background: url("http://freelansim.ru/images/logo.png");
	width: 70px;
	height: 70px;
  overflow: hidden;
  text-indent: -999px;
	margin: auto;
	display: block;
  position: absolute;
  top: 20px;
  left: 20px;
}


.icon_user_locked{
	background: url("http://freelansim.ru/user_locked.png");
	width: 374px;
	height: 115px;
	margin: 65px auto 60px;
}

.icon403{
	background: url("http://freelansim.ru/403.png");
	width: 391px;
	height: 162px;
	margin: 65px auto 0px;
}

.icon500{
	background: url("http://freelansim.ru/500.png");
	width: 395px;
	height: 162px;
	margin: 65px auto 0px;
}

.icon000{
	background: url("http://freelansim.ru/000.png") no-repeat;
	width: 410px;
	height: 162px;
	margin: 65px auto 0px;
}

.text{
	font-size: 36px;
	color: #fff;
	font-weight: normal;
	margin: 0 auto;
  line-height: 1;
}

.title{
  font-size: 120px;
  color: #fff;
  font-weight: 700;
  margin: 0 auto 20px;
  line-height: 1;
  font-family: Arial, Verdana, sans-serif;
}

.icon_404:after, .icon_500:after{
  content: "";
  display: block;
  width: 202px;
  height: 202px;
  margin: 40px auto;
  background-repeat: no-repeat;
  background-position: 0 0;
}

.icon_404:after{
  background-image: url("http://freelansim.ru/images/404_icon.png");
}

.icon_500:after{
  border-radius: 50%;
  background-image: url("data:image/png;base64,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");
}

.buttons{
	text-align: center;
	display:inline-block;
	margin:auto;
	position: relative;
  border-top: 3px solid #667c93;
  width: 100%;
  text-align: center;
  width: 400px;
}

.buttons_wrap{
  padding-top: 35px;
}

.text_buttons_intro{
  font-size: 20px;
  font-weight: normal;
  color: #748ca5;
  line-height: 1.5em;
  padding: 0;
  margin: 0;
  width: 100%;
  padding: 35px 0 0;
  text-align: center;
}

a.button{
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	color: #fff !important;
	background: #5bb3ee;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
  height: 40px;
  line-height: 40px;
	padding: 0 15px;
  text-align: center;
	vertical-align: middle;
	cursor: pointer;
  margin-right: 10px;
  text-decoration: none;
}

.button + .button{
  margin-left: -4px;
}

.button:last-child{
  margin-right: 0;
}

.button_tasks:before, .button_fl:before, .button_services:before{
  content: "";
  display: inline-block;
  vertical-align: middle;
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

.button_tasks:before{
  background: url("http://freelansim.ru/images/buttons_icons_404.png")no-repeat 0 0;
}

.button_fl:before{
  background: url("http://freelansim.ru/images/buttons_icons_404.png")no-repeat -31px 0;
}

.button_services:before{
  background: url("http://freelansim.ru/images/buttons_icons_404.png")no-repeat -60px 0;
}


a.button:hover{
	text-decoration: none;
}

.footer{
	color:#7e8186;
	font-size: 13px;
	margin: 45px auto 0;
}
  </style>
</head>

<body>
  <div class="layout" style="position: relative; left: -650px;">
		<div class="title">Account Verified <i class="fas fa-check-circle fa-sm text-success"></i></div>
		<div class="text icon_500">No further action is necessary</div>
		<div class="buttons">
      <a class="text_buttons_intro text-light" href="login.php" style="text-decoration: none; font-weight: 900;">Go to login</a>
		</div>
  </div>
</body>
</html>

    ';
  }
}
else{

  header('Location: ../../adminLogin.php');
  exit();
}

?>
</body>
</html>
