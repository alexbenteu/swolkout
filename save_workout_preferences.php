<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['days'])) {
    $userId = $_SESSION['user_id'];
    $days = $_POST['days'];

    $mysqli = require __DIR__ . "/database.php";
    
    $deleteStmt = $mysqli->prepare("DELETE FROM workout_days WHERE id = ?");
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();

    foreach ($days as $day) {  
        $sql = "INSERT INTO workout_days (id, day) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $userId, $day);       
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }
    header("location: index.php");
    exit;
}
?>
