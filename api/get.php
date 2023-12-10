<?php
require_once "config.php";
$query = mysqli_query($conn, "SELECT * FROM questions ORDER BY RAND() LIMIT 1;");
  echo json_encode(mysqli_fetch_assoc($query));