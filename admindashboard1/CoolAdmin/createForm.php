<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head>
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
  <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"> -->
  <style>
  body{
    padding:0;
    margin: 10px 0;
    background: #f2f2f2;
  }
  .form-wrapper-div{
    padding: 20px;
  }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand text-success font-weight-bold" style="font-size: 20px;" href="http://www.nhicct.org/">NHIC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" style="font-size: 20px;" href="adminDash2.php">Home <i class="fa fa-home"></i></a>
        <a class="nav-item nav-link active" style="font-size: 20px;" href="createForm.php">Create Form <i class="fa fa-edit"></i></a>
        <?php
        if($_SESSION['permissions'] == 3){
        echo '<a class="nav-item nav-link" style="font-size: 20px;" href="#" id="open">Add Admin Role <i class="fa fa-user-plus"></i></a>';

        }
        else if($_SESSION['permissions'] == 1 || $_SESSION['permissions'] == 2){
          echo '<a class="nav-item nav-link" style="font-size: 20px;" href="register.php">Add Admin Role <i class="fa fa-user-plus"></i></a>';
        }
        ?>
        <a class="nav-item nav-link" style="font-size: 20px;" href="forget-pass.php">Update My Password <i class="fa fa-lock"></i></a>
        <a class="nav-item nav-link" style="font-size: 20px;" href="backend/adminLogout.php">Logout <i class="fas fa-sign-out-alt"></i></a>

      </div>
    </div>
  </nav>



    <div id="fb-editor"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<div class="container"><br>
<div class="build-wrap"></div>
</div>
<script>
jQuery($ => {
  $('.build-wrap').formBuilder()
})

jQuery($ => {
  const fbEditor = document.getElementById("build-wrap");
  const formBuilder = $(fbEditor).formBuilder();


});

// inside the tinymce control class this is available as this.classConfig.paste_data_images


</script>
<script>
$("#open").on("click", function() {
  alert('Sorry but you do not have permission to access to this page');
});
</script>
</body>
</html>
