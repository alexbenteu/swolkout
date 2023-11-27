<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mysqli = require __DIR__ . "/database.php";
$today = date('l');

$stmt = $mysqli->prepare("SELECT id FROM workout_days WHERE day = ?");
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
foreach ($users as $user) {
    $mail = new PHPMailer(true);
    try {
        $userId = $user['user_id'];

        $stmt1 = $mysqli->prepare("SELECT email FROM user_credintials WHERE id = ?");
        $stmt1->bind_param("i", $userId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $userData = $result1->fetch_assoc();
        
        if ($userData) {
            $email = $userData['email'];
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alex.benteu@gmail.com';
            $mail->Password = 'omdexqhgsdpjphee'; //   xsmtpsib-5aa6440d1a251775ce23c4610c9488b8fecba37967534e12aaee7fc20c28e6d6-z62NMvShWVUBtHAO
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('swolkout@benzone.work', 'SwolKout');
            $mail->addAddress($email); 
            
            $mail->isHTML(true);
            $mail->Subject = 'Workout Reminder';
            $mail->Body = 'Today you have planned to work out!';

            $mail->send();
        }
        
        $stmt1->close(); 

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }echo "reminder sent";
}

$stmt->close();
?>
