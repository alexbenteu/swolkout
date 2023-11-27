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

$error_ex = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_SESSION["user_id"];
    $date = date("Y-m-d");

    $sql = "INSERT INTO weight (id, value, date)
        VALUES (?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("iss", $id, $_POST["newWeight"], $date);
                    
    if ($stmt->execute()) {
        header("location: index.php");
        exit;
        
    }
}

?>

<html>
    <head>
        <title>Add Weight</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>

    <body>
        <div>
            <h1>ADD WEIGHT</h1>
            <div class="contents">
                <table>
                    <form method="POST">
                            <tr>
                                 <label for="newWeight">new weight:</label>  
                                 <input type="text" id="newWeight" name="newWeight">  
                            </tr>
                            <tr>
                                 <?php if ($error_ex === 1) echo $error; ?>  
                            </tr>
                            <tr>
                                 <button class="button" type="submit">add to database</button>  
                            </tr>
                    </form>
                </table>
    </div></div>
    </body>
</html>