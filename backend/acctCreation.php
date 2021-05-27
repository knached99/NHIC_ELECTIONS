<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('../vendor/autoload.php');
require('../vendor/phpmailer/phpmailer/src/Exception.php');
require('../vendor/phpmailer/phpmailer/src/SMTP.php');
require('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
// Load Composer's autoloader
//function sendCode($six_digit_key, $email){
  // Instantiation and passing `true` enables exceptions
  //header('Location: ../createAccount.php?pageNotReached');


//}
if(isset($_POST['createAcct'])){
  require('dbConfig.php');
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $phoneNum = $_POST['phoneNum'];
  $password = $_POST['password'];
  $retypePassword = $_POST['retypePassword'];
  // REGEX PATTERNS
  $pwdPattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
$phonePattern = '/^(\({1}\d{3}\){1}|\d{3})(\s|-|.)\d{3}(\s|-|.)\d{4}$/';



  // check if the fields are empty
  if(empty($firstName) || empty($lastName) || empty($email) || empty($phoneNum) || empty($password) || empty($retypePassword)){
    header('Location: ../createAccount.php?emptyFields&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
    exit();
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../createAccount.php?invalidEmail&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'");
    exit();
      }
  else if(!preg_match($phonePattern, $phoneNum)){
    header('Location: ../createAccount.php?invalidNum&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
    exit();
  }
  else if(!preg_match($pwdPattern, $password)){
    header('Location: ../createAccount.php?invalidPassword&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
    exit();
  }
  else if($retypePassword !== $password){
    header('location: ../createAccount.php?passwordsNotMatched&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
    exit();
  }
  else{
    require('dbConfig.php');
    $query = 'SELECT firstName, lastName, email, phoneNum FROM nhicVoting WHERE email=? OR phoneNum=?';
    $stmt = mysqli_stmt_init($dbConn);
    if(!mysqli_stmt_prepare($stmt, $query)){
      header('Location: ../createAccount.php?sqlError&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $email, $phoneNum);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      // check for query results
      $checkQuery = mysqli_stmt_num_rows($stmt);

    }
    if($checkQuery > 0){
      header('Location: ../createAccount.php?userExists');
      exit();

    }
    // 1. Write the email script here
    //Call the PHPMailer function
    else{
      $verifyKey = md5(time(). $password);
      $vKey = $_POST['verifyKey'];
      $insert_user_data = 'INSERT INTO nhicVoting(firstName, lastName, email, phoneNum, password, vkey) VALUES(?,?,?,?,?,?)';
      //$six_digit_key = random_int(100000, 999999); // generate random six digit verification code
      //mt_rand()  Generate a random value via the Mersenne Twister Random Number Generator
      // but random_int() is more secure because it generates cryptographically secure values
      $stmt_prepared =mysqli_stmt_init($dbConn);
      if(!mysqli_stmt_prepare($stmt_prepared, $insert_user_data)){
        header('Location: ../createAccount.php?sqlError&firstName='.$firstName.'&lastName='.$lastName.'&email='.$email.'&phoneNum='.$phoneNum.'');
        exit();
      }
      else{
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt_prepared, "ssssss", $firstName, $lastName, $email, $phoneNum, $hashedPwd, $verifyKey);
        mysqli_stmt_execute($stmt_prepared);
      }

      try {
        $mail = new PHPMailer(true);

          //Server settings
          $mail->SMTPDebug = 0; //Setting debug to 0 to prevent
          // verbose debug output from displaying to client                      //SMTP::DEBUG_SERVER; // Enable verbose debug output
          $mail->isSMTP(true);                                            // Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through Gmail
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'nhicvoting@gmail.com';                     // SMTP username
          $mail->Password   = 'ClubPenguin99!';                               // SMTP password
          $mail->SMTPSecure = ssl;//PHPMailer::ENCRYPTION_STMPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = 465; //PREVIOUSLY 587                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

          //Recipients
          $mail->setFrom('nhicvoting@gmail.com', 'NHIC Admin');
          $mail->addAddress($email);     // Add a recipient
          //$mail->addAddress('ellen@example.com');               // Name is optional
          //$mail->addReplyTo('info@example.com', 'Information');
          //$mail->addCC('cc@example.com');
          //$mail->addBCC('bcc@example.com');

          // Attachments
        //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
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
                              New Haven Islamic Center Voter Account Setup
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                            <div class="mktEditable" id="intro_title">
                              Follow the instructions to setup your account
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
                              Hi '.$firstName. ' '. $lastName.',<br><br>
                              We are sending you this email in order to complete the final step of the account setup, which is validating your email,
                              please click on "verify account" to continue. Once verified, you will be able to log in
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
           <a style="color:#ffffff; background-color: #5cb85c;  border: 10px solid #5cb85c; border-radius: 3px; text-decoration:none;" href="http://localhost:8888/nhicElections/verify.php?vKey='.$verifyKey.'">Verify Account</a>                          </div>
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
                              <b>New Haven Islamic Center</b><br>
                                    254 Bull Hill Ln, Orange, CT 06516<br>
                                      <a style="color: #00a5b5;" href="mailto:nhicvoting@gmail.com">Contact Us</a>
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
          // Content
          $mail->Subject = 'NHIC Account Creation Verification Link';
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Body    = $body;
          $mail->AltBody = 'Hi '.$firstName.', please click on <a href="http://localhost:888/nhicElections/verify.php?vKey='.$verifyKey.'"> this link</a> to verify your account';

          if(!$mail->send()){
            echo 'You are not connected to the internet so therefore we could not send you a verification link to verify your account. Once you are connected to the internet, refresh your browser and try again.';
            //header('Location: ../createAccount.php?pageNotReached');
            exit();
          }

          else {

            $mail->smtpClose(); // close smtp connection
            //echo 'Verification code sent to '.$email;
            // insert the six_digit_key and user's email into the database to validate later on
            /*$insertKey = 'INSERT INTO temporary_keys (email, six_digit_key) VALUES(?,?)';
            $preparedStmt = mysqli_stmt_init($dbConn);
            if(!mysqli_stmt_prepare($preparedStmt, $insertKey)){
              header('Location: ../createAccount.php?sqlError');
              exit();
                }
              else{
                mysqli_stmt_bind_param($preparedStmt, 'ss', $email, $six_digit_key);
                mysqli_stmt_execute($preparedStmt);
                header('Location: ../verifyCode.php?email='.$email.'&firstName='.$firstName.'&lastName='.$lastName.'&phoneNum='.$phoneNum.'&password='.password_hash($password, PASSWORD_DEFAULT),'');
                exit();
              }*/
              header('Location: ../thankyou.php?email='.$email.'');
              exit();



          }


      } catch (phpmailerException $e) {
          echo "Message could not be sent. Mailer Error: $mail->getMessage()";
          return false;
      }
      //sendCode($six_digit_key, $email);

    }

    // end of email script
    // 2. Redirect to php file for entering code
    // 3. In the new php file, if the code is correct, insert account into table and go back to createAccount
    /*
    else{




  $insertQuery = 'INSERT INTO nhicVoting (firstName, lastName, email, phoneNum, password) VALUES(?,?,?,?,?)';
  $stmt = mysqli_stmt_init($dbConn);
  if(!mysqli_stmt_prepare($stmt, $insertQuery)){
    header('Location: ../createAccount.php?secondSqlError');
    exit();
  }
  else{
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $phoneNum, $hashedPwd);
    mysqli_stmt_execute($stmt);
    header('Location: ../createAccount.php?signupSuccess');
    exit();
  }
}
*/



    // close out prepared statement and database for faster execution
    mysqli_stmt_close($stmt);
    mysqli_close($dbConn);
  }
  exit();
}
else{
  header('Location: ../createAccount.php');
}
 ?>
