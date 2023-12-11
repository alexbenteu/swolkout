<?php

session_start();

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>New Workout</title>
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
                    <h2>ADD WEIGHT REMINDER</h2>
                    <div class="center-container">
                        <div class="reminder">
                        <form method="post" action="save_weight_preferences.php" >
                                <label><input type="checkbox" name="days[]" value="Monday">Monday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Tuesday">Tuesday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Wednesday">Wednesday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Thursday">Thursday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Friday">Friday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Saturday">Saturday</label>  <br>
                                <label><input type="checkbox" name="days[]" value="Sunday">Sunday</label>  <br><br>
                                <button type="submit" onclick="alerta()">add reminder</button>
                        </form>
                        </div></div>
                <br><br><br><br><br>

                <h2>ADD WORKOUT REMINDER</h2>
                    <div class="center-container">
                        <div class="reminder">
                        <form method="post" action="save_workout_preferences.php" >
                            <label><input type="checkbox" name="days[]" value="Monday">Monday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Tuesday">Tuesday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Wednesday">Wednesday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Thursday">Thursday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Friday">Friday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Saturday">Saturday</label>  <br>
                            <label><input type="checkbox" name="days[]" value="Sunday">Sunday</label>  <br><br>
                            <button type="submit" onclick="alerta()">add reminder</button>
                        </form>
                    </div></div>
                </td>
            </tr>
    </table>
    <script>
        function alerta() {
            alert("preference saved successfully");
        }
    </script>
</body>