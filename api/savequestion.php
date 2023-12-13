<?php
require_once "config.php";
$data = json_decode(file_get_contents('php://input'), true);
$item1 = $data['item1'];
$item2 = $data['item2'];

if ($item1 && $item2) {
  $insertQuery = mysqli_query($conn, "INSERT INTO questions VALUES(null, '$item1', '$item2', 0, 0)");
  if($insertQuery) {
    echo "سوال با موفقیت اضافه شد.";
  } else {
    echo "خطا: " . mysqli_error($conn);
  }
} else {
  echo "داده ها به درستی وارد نشده اند.";
}