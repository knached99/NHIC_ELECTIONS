<?php
// Require PHP Mailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('../../../vendor/autoload.php');
require('../../../vendor/phpmailer/phpmailer/src/Exception.php');
require('../../../vendor/phpmailer/phpmailer/src/SMTP.php');
require('../../../vendor/phpmailer/phpmailer/src/PHPMailer.php');
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
if(isset($_POST['resetPwd'])){
  require('../../../backend/dbConfig.php');
  $email = $_POST['email'];
  if(empty($email)){
    header('Location: ../reset_admin_pwd.php?emptyFields');
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('Location: ../reset_admin_pwd.php?invalidEmail');
    exit();
  }
  else{
    require('../../../backend/dbConfig.php');
    $get_admin_email = 'SELECT * FROM adminUsers WHERE email=?';
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $get_admin_email)){
      header('Location: ../reset_admin_pwd.php?sqlError');
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $results = mysqli_stmt_num_rows($stmt);
      if($results == 0){
        header('Location: ../reset_admin_pwd.php?email_not_on_file');
        exit();
      }
      else{
        require('../../../backend/dbConfig.php');
        $reset_key = md5($email).time();
        $auth_token = md5(uniqid(rand()));
        $url = 'http://localhost:8888/nhicElections/admindashboard1/coolAdmin/create_admin_password.php?reset_key= '.$reset_key.' &auth_token= '.$auth_token.'&email='.$email.'';
        // Insert auth token and reset key into the adminUsers
        // Table for the specified user
        $insert_auth_token = "UPDATE adminUsers SET reset_key=?, auth_token=? WHERE email=?";
        $stmt = mysqli_stmt_init($dbConn);
        if(!mysqli_stmt_prepare($stmt, $insert_auth_token)){
          header('Location: ../reset_admin_pwd.php?sqlErrorTwo');
          exit();
        }
        else{
          mysqli_stmt_bind_param($stmt, "sss", $reset_key, $auth_token, $email);
          mysqli_stmt_execute($stmt);
        }

        // Write email script to send verification link
        try{
          $mail = new PHPMailer(true);
          $mail ->SMTPDebug = 0; // disable verbose debug output to client
          $mail ->isSMTP(true); // enable SMTP authentication
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username   = 'nhicvoting@gmail.com';                     // SMTP username
          $mail->Password   = 'ClubPenguin99!';                               // SMTP password
          $mail->SMTPSecure = ssl;//PHPMailer::ENCRYPTION_STMPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = 465; //PREVIOUSLY 587                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
          $mail->setFrom('nhicvoting@gmail.com', 'NHIC Admin Password Manager');
          $mail->addAddress($email);
          $mail->isHTML(TRUE);

          $mail->Subject = 'Password Reset Request';
          $body = '  <!DOCTYPE HTML>
            <html lang="en" dir="ltr">
            <head>
            <link rel="stylsheet" href="http://localhost/nhicElections/styling/mail.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

                    </head>
            <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">

            <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
              <tr>
                <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                  <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                    <tr>
                      <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #5cb85c">
                        <a href="http://www.nhicct.org/"><img class="top-image" src="../assets/images/nhic_logo.jpg" style="line-height: 1;width: 600px;" alt="NHIC Logo"></a>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #5cb85c; font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td class="head-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 28px;line-height: 34px;font-weight: bold; text-align: center;">
                              <div class="mktEditable" id="main_title">
                              NHIC Admin Password Reset Request
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                            <div class="mktEditable" id="intro_title">
                              Follow the instructions to reset your password
                            </div></td>
                          </tr>
                          <tr>
                            <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
                          </tr>

                          <tr>
                            <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 15px 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 21px;">
                              <hr size="1" color="#eeeff0">
                            </td>
                          </tr>
                          <tr>
                            <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                            <div class="mktEditable" id="main_text">
                              '.$displayMessage.',<br><br>
                              You have request to reset your password since you forgot it.
                              Please click on the "reset password" button in order to reset it
                            </div>

                            </td>
                          </tr>
                          <tr>
                            <td style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
                             &nbsp;<br>
                            </td>
                          </tr>
                          <tr>
                            <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
                            <div class="mktEditable" id="download_button" style="text-align: center;">
                            <a style="color:#ffffff; background-color: #5cb85c;  border: 10px solid #5cb85c; border-radius: 3px; text-decoration:none;" href="'.$url.'">Reset Password</a>
                            </div>
                            </td>
                          </tr>

                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:20px; font-family: Arial, sans-serif; -webkit-text-size-adjust: none;" align="center">

                      </div>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #5cb85c;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #5cb85c;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
                              <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                                <tr>

                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr bgcolor="#fff" style="border-top: 4px solid #5cb85c;">
                      <td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
            <div id="address" class="mktEditable">
                              <b>NHIC</b><br>
                                    254 Bull Hill Ln, Orange, CT 06516<br>
                                      <a style="color: #00a5b5;" href="mailto:nhicvoting@gmail.com">Contact the developer</a>
            </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </body>
            </html>
            ';
          $mail->Body = $body;
          if(!$mail->send()){
            echo 'Unable to send email because'.$mail->ErrorInfo;
          }
          else{
            header('Location: ../thank_you.php');
          }
        }
        catch(phpmailerException $e){
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          return FALSE;
        }
      }
    }
  }
}

?>
