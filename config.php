<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_system";

// Create connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($connect,"utf8");

// Check connection
if (!$connect) {
  die("ບໍ່ສາມາດເຊື່ອມຕໍ່ຖານຂໍ້ມູນໄດ້: " . mysqli_connect_error());
}
/* echo "ເຊື່ອມຕໍ່ຖານຂໍ້ມູນສຳເລັດແລ້ວ"
?> */