<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "labcheck";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
 ?>