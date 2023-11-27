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
    <div>
    <h1>LOGIN</h1>
    <div class="contents">
    <?php if ($is_invalid): ?>
        <em>invalid login</em>
    <?php endif; ?>
    <form method="post">
        <table>
            <tr>
                 <label for="email">email: </label>  
                 <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">  
            </tr>
            <tr>
                 <label for="password">password: </label>  
                 <input type="password" name="password" id="password">  
            </tr>
            <tr>
                <td style="text-align: center;"><button type="submit">log in</button>  
                <td style="text-align: center;"><button type="reset">reset</button>  
            </tr>
        </table>
        
    </form>
    </div></div>
</body>
</html>








