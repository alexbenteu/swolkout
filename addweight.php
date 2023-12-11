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

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_SESSION["user_id"];
    $date = date("Y-m-d");

    $sql = "INSERT INTO weight (id, value, date)
        VALUES (?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("iss", $id, $_POST["newWeight"], $date);
                    
    if ($stmt->execute()) {
        header("location: home.php");
        exit;
        
    }
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Add Weight</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link rel="stylesheet" href="style.css">
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
                            <form method="POST">
                                <tr>
                                    <td><label for="newWeight">new weight:</label></td>
                                    <td><input type="text" id="newWeight" name="newWeight" required></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;" colspan="2"><button class="button" type="submit" onclick="alerta()">add to database</button></td>
                                </tr>
                            </form>
                        </table> 
                    </div>
                    
                </td>
            </tr>
        </table>
        <script>
            function alerta() {
            alert("weight saved successfully");
        }
        </script>
    </body>
</html>