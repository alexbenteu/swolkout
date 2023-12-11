<?php
echo "<pre>";
var_dump($_POST);
echo "</pre>";

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);
$mysqli = require __DIR__ . "/database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION["user_id"];
    $date = date("Y-m-d");
    if (isset($_POST['exercises'])) {
        $exerciseData = $_POST['exercises'];

        $temp_sql = "INSERT INTO workouts (`id`, `date`) VALUES (?, ?)";
        $temp_smtp = $mysqli->prepare($temp_sql);
        $temp_smtp->bind_param("is", $id, $date);
        $temp_smtp->execute();

        foreach ($exerciseData as $exerciseName => $exerciseValues) {
            if ($exerciseName != 0) {
                $value = '';
            
                if (isset($exerciseValues['reps']) && isset($exerciseValues['weight'])) {
                    $reps = $exerciseValues['reps'];
                    $weight = $exerciseValues['weight'];
                    for ($i = 0; $i < count($reps); $i++) {
                        $value .= $reps[$i] . 'x' . $weight[$i] . ';';
                    }
                }
            
                $value = substr($value, 0, -1);
                $sql = "INSERT INTO `$exerciseName` (`id`, `values`, `date`)
                VALUES (?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                if (!$stmt) {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                    exit;
                }
                $stmt->bind_param("iss", $id, $value, $date);
            
                if (!$stmt->execute()) {
                    echo $stmt->error;
                }
            }
        }
        
        header("location: home.php");
    }
}
?>
