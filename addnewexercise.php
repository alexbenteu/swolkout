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

$error_ex = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $tableName = mysqli_real_escape_string($mysqli, $_POST["numeExerc"]);

    $filename = __DIR__ . "/exerciselist.txt";
    $myfile = fopen($filename, "a");
    fwrite($myfile, $tableName . "\n");
    fclose($myfile);

    $sql = "CREATE TABLE `$tableName` (
        id INT UNSIGNED,
        `values` VARCHAR(256) NOT NULL,
        date DATE NOT NULL,
        FOREIGN KEY (id) REFERENCES user_credintials(id)
        )";
    if ($mysqli->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        $error = $mysqli -> error;
        $error_ex = 1;
    }
}

?>
<html>
    <head>
        <title>Add New Exercise</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>
    <body>
        <div>
        <h1>ADD EXERCISE</h1>
        <div class="contents">
            <table  id="toStyle">
                <form action="" method="POST">
                        
                        <tr>
                             <label for="numeExerc">exercise name:</label>  
                             <input type="text" id="numeExerc" name="numeExerc">  
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
