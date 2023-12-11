<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_POST["name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user_credintials (name, email, password)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
$_POST["name"],
$_POST["email"],
$password_hash);
                  
if ($stmt->execute()) {
    session_start();       
    session_regenerate_id();
    $email = $_POST["email"];
    $sql2 = "SELECT id FROM user_credintials WHERE email = ?";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $stmt2->bind_result($id);
    $stmt2->fetch();

    $_SESSION["user_id"] = $id;
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["otpOK"] = "nu";
    header("Location: otp.php");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?>