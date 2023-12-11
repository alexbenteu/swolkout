<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user_credintials
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["otpOK"] = "nu";
            
            if($_POST["email"] == "admin@example.com"){
                header("Location: admin.php");
                exit;
            }
            header("Location: otp.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
</head>
<body>
    
    <div class="contents">
    
    <form method="post">
        <table>
            <tr>
                <td colspan="2"><h1>LOGIN</h1></td>
            </tr>
            <tr><td><br></td></tr>
            <tr><td colspan="2">
                <?php if ($is_invalid): ?>
                <em style="color: red;">invalid login</em>
                <?php endif; ?>
            </td></tr>
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
                <td style="text-align: center;"><button type="submit">log in</button>  
                <td style="text-align: center;"><button type="button" onclick="openResetPasswordPage()">reset password</button>  
            </tr>
        </table>
        
    </form>
    </div>
    <script>
    function openResetPasswordPage() {
        window.location.href = "reset_password.php";
    }
</script>
</body>
</html>








