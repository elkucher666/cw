<?php
require_once('./../config/connect.php');

$id = $_POST["id"];


$query_string = "SELECT `image` from `room` WHERE `id` = $id";
mysqli_query($connect, $query_string);
unlink($image);

$query_string = "DELETE FROM `room` WHERE `room`.`id` = $id";
mysqli_query($connect, $query_string);

?>