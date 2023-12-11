<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}elseif ($_SESSION["email"] == "admin@example.com") {
    header('Location: admin.php');
    exit;
}

require 'vendor/autoload.php';

$email = $_SESSION["email"];
$mail = new PHPMailer(true);

try {
    $otp = rand(100000,999999);
    $_SESSION['otp'] = $otp;

    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alex.benteu@gmail.com'; // SMTP username
    $mail->Password = 'omdexqhgsdpjphee'; //   xsmtpsib-5aa6440d1a251775ce23c4610c9488b8fecba37967534e12aaee7fc20c28e6d6-z62NMvShWVUBtHAO
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
                    
    $mail->setFrom('swolkout@benzone.work', 'SwolKout');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for SwolKout';
    $mail->Body = 'Your OTP is: ' . $otp;

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>OTP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="contents">
            <form method="post" action="verify-otp.php">
                <table>
                    <tr>
                        <td colspan="2"><h1>OTP</h1></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                         <td style="text-align: center;"><label for="otp">enter otp: </label></td>  
                         <td style="text-align: center;"><input type="text" id="otp" name="otp" required></td>  
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                         <td style="text-align: center;"><button type="submit">verify</button></td>  
                         <td style="text-align: center;"><button type="button" onclick="window.location.reload();">resend</button></td>  
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
