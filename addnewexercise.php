<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
} elseif ($_SESSION["email"] != "admin@example.com") {
    header('Location: index.php');
    exit;
}

$mysqli = require __DIR__ . "/database.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tableName = mysqli_real_escape_string($mysqli, $_POST["numeExerc"]);

    if (empty($tableName)) {
        $error = "Name is required";
    } else {
        $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
        $tableExists = $mysqli->query($checkTableQuery);

        if ($tableExists->num_rows > 0) {
            $error = "'$tableName' already exists in the database";
        } else {
            $sql = "CREATE TABLE `$tableName` (
                id INT UNSIGNED,
                `values` VARCHAR(256) NOT NULL,
                date DATE NOT NULL,
                FOREIGN KEY (id) REFERENCES user_credintials(id)
            )";
            if ($mysqli->query($sql)) {
                $filename = __DIR__ . "/exerciselist.txt";
                $myfile = fopen($filename, "a");
                fwrite($myfile, $tableName . "\n");
                fclose($myfile);
                header("location: admin.php");
                exit;
            } else {
                $error = "the exercise already exists: " . $tableName;
            }
        }
    }
}
?>

<!DOCTYPE HTML>
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
        <div class="contents">
            <table id="toStyle">
                <form action="" method="POST">
                    <tr>
                        <td colspan="2"><h1>ADD EXERCISE</h1></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td style="text-align: center;"><label for="numeExerc">exercise name:</label></td>
                        <td style="text-align: center;"><input type="text" id="numeExerc" name="numeExerc" required></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td colspan="2" style="text-align: center; color: red;"><?php if (!empty($error)) echo $error; ?></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><button class="button" type="submit">Add to Database</button></td>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</body>
</html>
