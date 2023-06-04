<?php
require_once('./../config/connect.php');

$id = $_POST["id"];

$query ="select `booking_date`, `booking_start`, `booking_end` from `application` where `id_room` = '$id' and `approved` = '1'";
$result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_ASSOC);

print_r(json_encode($result));
?>