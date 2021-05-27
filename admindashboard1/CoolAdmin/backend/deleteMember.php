<?php
require('../../../backend/dbConfig.php');
$userId = $_GET['userId'];
$del_user = mysqli_query($dbConn, 'DELETE from nhicVoting WHERE userId= '.$userId.'');
if($del_user){
  mysqli_close($conn);
  header('Location: ../adminDash2.php?itemDeleted');
  exit();
}
else{
  header('Location: ../adminDash2.php?deletionError');
  exit();
}

?>
