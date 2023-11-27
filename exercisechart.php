<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$mysqli = require __DIR__ . "/database.php";

$dates_json = $values_json = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['myExercise'])) {
    $selectedExercise = $_POST['myExercise'];

    $query = "SELECT date, `values` FROM `$selectedExercise` WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli -> query($query);

    if (!$result) {
        die("Query failed: " . $mysqli->error);
    }

    $dates = [];
    
    $values = [];

    while ($row = $result->fetch_assoc()) {
        $dates[] = $row["date"];
        $exerciseParts = explode(';', $row["values"]);
        $highestWeight = 0;
        foreach ($exerciseParts as $part) {
            list($reps, $weight) = explode('x', trim($part));
            $weight = (int)trim($weight);
            if ($weight > $highestWeight) {
                $highestWeight = $weight;
            }
        }
        $values[] = $highestWeight;
    }

    $dates_json = json_encode($dates);
    $values_json = json_encode($values);
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Exercise Graphic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <div>
        <h1>EXERCISE GRAPHIC</h1>  
        <table>
            <tr>
                <td>
                    <form method="post">
                        <select name="myExercise" id="mySelect"></select>
                        <button type="submit">show graphic</button>
                    </form>
                </td>
            </tr>
            <tr>
                 <canvas id="graphic"></canvas>  
            </tr>
        </table>
        </div>
        <script>

            function loadOptions() {
                fetch('exerciselist.txt')
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

                <?php if (!empty($dates_json) && !empty($values_json)) : ?>
                generateGraphic();
                <?php endif; ?>
            });

            function generateGraphic(){
                var dates = JSON.parse('<?php echo $dates_json; ?>');
                var values = JSON.parse('<?php echo $values_json; ?>');

                var target = document.getElementById('graphic').getContext('2d');
                var graphic = new Chart(target, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'date',
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