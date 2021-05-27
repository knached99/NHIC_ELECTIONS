<!-- DATABASE CONFIGURATION FILE-->
<?php
$server = 'localhost';
$user = 'root';
$pwd ='root';
$dbName = 'nhicVotingDb';
$dbConn = mysqli_connect($server, $user, $pwd, $dbName);
if(!$dbConn){
  die('Cannot connect to the server due to: '.mysqli_connect_error().'. Error code: '.mysqli_connect_errno());
  exit();
}

?>
