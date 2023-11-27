<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['otp'], $_POST["otp"]) && $_POST["otp"] == $_SESSION['otp']) {
        $_SESSION["otpOK"] = "da";
        header("location: index.php");
        exit;
    } else {
        header("location: otp.php?error=invalid");
        exit;
    }
}

?>
