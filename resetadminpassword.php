<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}elseif ($_SESSION["email"] != "admin@example.com") {
    header('Location: index.php');
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_ex = 0;
    if (!($_POST["password1"] === $_POST["password2"])) {
        $error_ex = 1;
        $error = "passwords do not match";
        exit;
    }

    $sql = "SELECT * FROM user_credintials WHERE name = 'admin'";
    $query = $mysqli->query($sql);
    $row = $query->fetch_assoc();
    $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
    $sql = "UPDATE user_credintials SET password = '$password' WHERE name = 'admin'";
    $mysqli->query($sql);
    
    header("location: admin.php");
}


?>

<html>
    <head>
        <title>Reset Admin Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div>
        <h1>RESET ADMIN PASSWORD</h1>
        <div class="contents">
            <table>
                <form action="" method="POST">
                        <tr>
                             <label for="password1">new password: </label>  
                             <input type="text" id="password1" name="password1">  
                        </tr>
                        <tr>
                             <label for="password2">repeat password: </label>  
                             <input type="text" id="password2" name="password2">  
                        </tr>
                        <tr>
                             <?php if ($error_ex === 1) echo $error; ?>  
                        </tr>
                        <tr>
                             <button class="button" type="submit">reset</button>  
                        </tr>
                </form>
            </table>
        </div></div>
    </body>
</html>