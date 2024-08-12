<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "Register";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Error;");
}
    echo "connected successfully";

?>