<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    if ($_SESSION["email"] == "admin@example.com") {
        header('Location: admin.php');
        exit;
    }
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user_credintials
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>

    <body>
        <?php if (isset($user)): ?>
            <?php header("location: home.php"); ?>
        <?php else: ?>
            <div class="contents">
                <h1>HELLO</h1><br><br><br>
                <a href="login.php">log in</a><br>
                <a href="signup.html">sign up</a>  
            </div>           
        <?php endif; ?>
        
    </body>
</html>
    
    
    
    
    
    
    
    
    
    
    
