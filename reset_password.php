<?php

$is_invalid = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user_credintials
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password"]) && $user["id"] !== 1) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["otpOK"] = "nu";
        } else {
            $is_invalid = true;
        }

        if ($_POST["password1"] !== $_POST["password2"]) {
            $error = "passwords do not match";
        } else {
            $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
            $sql = "UPDATE user_credintials SET password = '$password' WHERE id = " . $_SESSION["user_id"];
            $mysqli->query($sql);
        }
        session_destroy();
        if (empty($error) && !$is_invalid) {
            
            header("location: index.php");
            exit;
        }
    } else {
        $is_invalid = true;
        session_destroy();
        header("location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="contents">
    
    <form method="post">
        <table>
            <tr>
                <td colspan="2"><h1>RESET PASSWORD</h1></td>
            </tr>
            <tr><td><br></td></tr>
            <tr><td colspan="2">
                <?php if ($is_invalid): ?>
                <p style="color: red;">invalid credentials</p>
                <?php endif; ?>
            </td></tr>
            <tr><td><br></td></tr>
            <tr>
                 <td style="text-align: center; color: red;" colspan="2"><?php if (!empty($error)) echo $error; ?></td>  
            </tr>
            <tr><td><br></td></tr>
            <tr><td>
                 <label for="email">email: </label>  </td>
                 <td><input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">  
            </td></tr>
            <tr><td><br></td></tr>
            <tr><td>
                 <label for="password">password: </label>  </td>
                 <td><input type="password" name="password" id="password">  
            </td></tr>
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
                <td colspan="2" style="text-align: center;"><button class="button" type="submit">reset password</button></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>
