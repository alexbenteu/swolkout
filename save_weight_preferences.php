<?php
session_start();

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['days'])) {
    $userId = $_SESSION['user_id'];
    $days = $_POST['days'];

    $mysqli = require __DIR__ . "/database.php";
    
    $deleteStmt = $mysqli->prepare("DELETE FROM weight_days WHERE id = ?");
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();
    if (!empty($days)) {
    foreach ($days as $day) {  
        $sql = "INSERT INTO weight_days (id, day) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $userId, $day);       
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }}
    header("location: home.php");
    exit;
}
?>
