<?php

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

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Weight Chart</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <table>
            <tr>
                 <h1>WEIGHT GRAPHIC</h1>  
            </tr>
            <tr>
                 <canvas id="graphic"></canvas>  
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
        </script>
    </body>
</html>