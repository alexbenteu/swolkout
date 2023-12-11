<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>

<html>
    <head>
        <title>Admin</title>
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
                <table>
                    <tr>
                        <td><h1>ADMIN</h1></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                         <td><button class="button" onclick="openExercise()">add new exercise</button></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                         <td><button class="button" onclick="openReset()">reset admin password</button></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                         <td><button class="button" onclick="openLogOut()">log out</button></td>
                    </tr>
                </table>
        </div></div>
    </body>
    <script>
        function openExercise() {
            window.location.href = "addnewexercise.php";
        }
        function openReset() {
            window.location.href = "resetadminpassword.php";
        }
        function openLogOut() {
            window.location.href = "logout.php";
        }
    </script>
</html>
