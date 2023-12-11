<?php

session_start();

$error = '';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
} elseif ($_SESSION["email"] != "admin@example.com") {
    header('Location: index.php');
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!($_POST["password1"] === $_POST["password2"])) {
        $error = "passwords do not match";
    } else {
        $sql = "SELECT * FROM user_credintials WHERE name = 'admin'";
        $query = $mysqli->query($sql);
        $row = $query->fetch_assoc();
        $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
        $sql = "UPDATE user_credintials SET password = '$password' WHERE name = 'admin'";
        $mysqli->query($sql);

        if (empty($error)) {
            header("location: admin.php");
            exit;
        }
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Reset Admin Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div>
        
        <div class="contents">
            <table>
                <form action="" method="POST">
                        <tr>
                            <td colspan="2"><h1>RESET ADMIN PASSWORD</h1></td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                             <td style="text-align: center;"><label for="password1">new password: </label> </td> 
                             <td style="text-align: center;"><input type="password" id="password1" name="password1" required>  </td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                             <td style="text-align: center;"><label for="password2">repeat password: </label>  </td>
                             <td style="text-align: center;"><input type="password" id="password2" name="password2" required></td>  
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                             <td style="text-align: center; color: red;" colspan="2"><?php if (!empty($error)) echo $error; ?></td>  
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                            <td colspan="2" style="text-align: center;"><button class="button" type="submit">reset password</button></td>
                        </tr>
                </form>
            </table>
        </div></div>
    </body>
</html>