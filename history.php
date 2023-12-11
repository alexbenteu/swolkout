<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT date FROM workouts";
$result = $mysqli->query($sql);
$dates = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row["date"];
    }
}

$exerciseData = [];

$exerciseList = file(__DIR__ . "/exerciselist.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($exerciseList as $exercise) {
    foreach ($dates as $date) {
        $sql = "SELECT `values` FROM `$exercise` WHERE date = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($value);
            $stmt->fetch();
            $exerciseData[$date][$exercise] = $value;
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>All Workouts</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
    <table>
        <tr id = "title">
            <td colspan="5"><a href="home.php">SWOLKOUT</a></td>
        </tr>
        <tr id = "meniu">
                <td><a href="addweight.php">add weight</a></td>
                <td><a href="addworkout.php">add workout</a></td>
                <td><a href="history.php">workout history</a></td>
                <td><a href="set_reminders.php">set reminders</a></td>
                <td><a href="logout.php">log out</a></td>
        </tr>
        <tr id = "body">
            <td colspan="5">
                <div class="contents">
                    <table>
                        
                    </table>
                </div>
            </td>
        </tr>
    </table>
    
    <script>
        var exerciseData = <?php echo json_encode($exerciseData); ?>;
        if (typeof exerciseData === 'object' && exerciseData !== null) {
            var tableContent = '';
            for (var date in exerciseData) {
                if (exerciseData.hasOwnProperty(date)) {
                    tableContent += '<tr><td colspan="2"><h2>Date: ' + date + '</h2></td></tr>';
                    var exercises = exerciseData[date];
                    for (var exercise in exercises) {
                        if (exercises.hasOwnProperty(exercise)) {
                            var value = exercises[exercise];
                            if (value) {
                                value = value.replace(/;/g, ' -> ');
                            }

                            tableContent += '<tr><td>' + exercise + ':</td><td>' + (value || 'N/A') + '</td></tr>';
                        }
                    }
                }
            }
            var contentsDiv = document.querySelector('.contents table');
            if (contentsDiv) {
                contentsDiv.innerHTML = tableContent;
            }
        }
    </script>
</body>

