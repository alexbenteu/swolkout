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

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Reminder</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>

    <body>
        <div>
            <h1>ADD WEIGHT REMINDER</h1>
            <div class="contents">
                <form method="post" action="save_weight_preferences.php">
                <label><input type="checkbox" name="days[]" value="Monday">Monday</label>  
                <label><input type="checkbox" name="days[]" value="Tuesday">Tuesday</label>  
                <label><input type="checkbox" name="days[]" value="Wednesday">Wednesday</label>  
                <label><input type="checkbox" name="days[]" value="Thursday">Thursday</label>  
                <label><input type="checkbox" name="days[]" value="Friday">Friday</label>  
                <label><input type="checkbox" name="days[]" value="Saturday">Saturday</label>  
                <label><input type="checkbox" name="days[]" value="Sunday">Sunday</label>  
                <button type="submit">add reminder</button>
        </form>
    </div></div>
    </body>
</html>