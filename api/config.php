<?php
$host = "localhost";
$database = "kodam";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($conn, "UTF8");