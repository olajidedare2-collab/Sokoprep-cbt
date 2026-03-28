<?php

$host = "localhost";
$user = "u417277908_sokoprep_user";
$password = "Motilol@123";
$database = "u417277908_sokoprep_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>