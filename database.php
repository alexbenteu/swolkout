<?php

$host = "localhost";
$dbname = "swolkout";
$username = "root";
$password = "12350";

$mysqli = new mysqli($host, $username, $password, $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;