<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}elseif ($_SESSION["email"] == "admin@example.com") {
    header('Location: admin.php');
    exit;
}elseif ($_SESSION["otpOK"] == "nu") {
    header('Location: otp.php');
    exit;
}

$mysqli = require __DIR__ . "/database.php";

$query = "SELECT date, value FROM weight WHERE id = {$_SESSION["user_id"]}";

$result = $mysqli -> query($query);

$dates = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row["date"];
    $values[] = $row["value"];
}

$dates_json = json_encode($dates);
$values_json = json_encode($values);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['myExercise'])) {
    $selectedExercise = $_POST['myExercise'];

    $query = "SELECT date, `values` FROM `$selectedExercise` WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli -> query($query);

    if (!$result) {
        die("Query failed: " . $mysqli->error);
    }

    $dates2 = [];
    
    $values2 = [];

    while ($row = $result->fetch_assoc()) {
        $dates2[] = $row["date"];
        $exerciseParts = explode(';', $row["values"]);
        $highestWeight = 0;
        foreach ($exerciseParts as $part) {
            list($reps, $weight) = explode('x', trim($part));
            $weight = (int)trim($weight);
            if ($weight > $highestWeight) {
                $highestWeight = $weight;
            }
        }
        $values2[] = $highestWeight;
    }

    $dates_json2 = json_encode($dates2);
    $values_json2 = json_encode($values2);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <p>weight chart</p>
                    <canvas id="graphic"></canvas>
                    <br><br>
                    <form method="post">
                        <select name="myExercise" id="mySelect"></select>
                        <button type="submit">show graphic</button>
                    </form>
                    <br>
                    <p id="nameSelected"></p>
                    <canvas id="graphic2"></canvas>
                </td>
            </tr>
        </table>
        
        <script>
            var dates = JSON.parse('<?php echo $dates_json; ?>');
            var values = JSON.parse('<?php echo $values_json; ?>');

            var target = document.getElementById('graphic').getContext('2d');
            var graphic = new Chart(target, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: '',
                        data: values,
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales:{
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 2nd grafic

            function loadOptions() {

                var defaultOption = document.createElement('option');
                defaultOption.textContent = 'select exercise';
                defaultOption.value = '';
                defaultOption.disabled = true;
                defaultOption.selected = true;

                // Add the default option to the select element
                var selectElement = document.getElementById('mySelect');
                selectElement.appendChild(defaultOption);

                fetch(`exerciselist.txt?nocache=${new Date().getTime()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();})
                    .then(text => {
                        const lines = text.split(/\r?\n/);
                        lines.forEach(line => {
                            if (line.trim().length > 0) { 
                                const option = document.createElement('option');
                                option.textContent = line;
                                document.getElementById('mySelect').appendChild(option);
                            }
                        });
                    })
                    .catch(error => console.error('Error loading options:', error));
            }

            document.addEventListener('DOMContentLoaded', function() {
                loadOptions();
                <?php if (!empty($dates_json2) && !empty($values_json2)) : ?>
                    document.getElementById('nameSelected').innerHTML=`<?php echo $selectedExercise ?>`;
                    generateGraphic2();
                <?php endif; ?>
            });

            function generateGraphic2(){      

                var dates = JSON.parse('<?php echo $dates_json2; ?>');
                var values = JSON.parse('<?php echo $values_json2; ?>');

                var target = document.getElementById('graphic2').getContext('2d');
                var graphic = new Chart(target, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: '',
                            data: values,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales:{
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>