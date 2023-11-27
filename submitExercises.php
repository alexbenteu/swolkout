<?php
echo "<pre>";
var_dump($_POST);
echo "</pre>";

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);
$mysqli = require __DIR__ . "/database.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $exercises = $_POST['exercises'];
    $values = $_POST['values'];

    $id = $_SESSION["user_id"];
    $date = date("Y-m-d");

    for ($i = 0; $i < count($exercises); $i++) {
        $exercise = $mysqli->real_escape_string($exercises[$i]);
        $value = $mysqli->real_escape_string($values[$i]);
        $sql = "INSERT INTO `$exercise` (`id`, `values`, `date`)
        VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if(!$stmt) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }
        $stmt->bind_param("iss", $id, $value, $date);
                    
        if(!$stmt->execute()) {
            echo $stmt->error;
        }
        
    }
    header("location: index.php");
}

?>