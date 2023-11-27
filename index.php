<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    if ($_SESSION["otpOK"] == "nu") {
        header('Location: otp.php');
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
            <div>
                <h1>HOME</h1>
                <div class="contents">
                    <table id="toStyle">
                        <tr>
                             <a href="weightchart.php">weight chart</a>  
                        </tr>
                        <tr>
                             <a href="exercisechart.php">exercise chart</a>  
                        </tr>
                        <tr>
                             <a href="addweight.php">add weight</a>  
                        </tr>
                        <tr>
                             <a href="addworkout.php">add workout</a>  
                        </tr>
                        <tr>
                             <a href="workoutreminder.php">workout reminder</a>  
                        </tr>
                        <tr>
                             <a href="weightreminder.php">weight reminder</a>  
                        </tr>
                        <tr>
                             <a href="logout.php">log out</a>  
                        </tr>
                </table></div>
            </div>
        <?php else: ?>
            <div>
                <h1>HELLO</h1>
                <div class="contents">
                    <table id="toStyle">
                        <tr>
                             <a href="login.php">log in</a>  
                        </tr>
                        <tr>
                             <a href="signup.html">sign up</a>  
                </table></div>
            </div>           
        <?php endif; ?>
        
    </body>
</html>
    
    
    
    
    
    
    
    
    
    
    