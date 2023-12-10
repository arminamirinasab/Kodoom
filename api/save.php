<?php
require_once "config.php";
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$isItem2 = $data['isItem2'];

$selectQuery = mysqli_query($conn, "SELECT * FROM questions WHERE id = $id;");
$votesNumber = mysqli_fetch_assoc($selectQuery);
if ($isItem2 == true) {
  $votesNumber = intval($votesNumber["votes2"]);
  $votesNumber++;
  $updateQuery = mysqli_query($conn, "UPDATE questions SET votes2 = $votesNumber WHERE id = $id");
} else if ($isItem2 == false) {
  $votesNumber = intval($votesNumber["votes1"]);
  $votesNumber++;
  $updateQuery = mysqli_query($conn, "UPDATE questions SET votes1 = $votesNumber WHERE id = $id");
}