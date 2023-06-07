<?php
require_once('./../config/connect.php');

$id = $_POST["id"];
$address = $_POST["address"];
$name = $_POST["name"];
$description = $_POST["description"];


$query_string = "SELECT `image` from `room` WHERE `id` = $id";


$image = mysqli_query($connect, $query_string)->fetch_assoc()["image"];


if (isset($_FILES["image"])) {
    unlink($image);
    
    $file_name = $_FILES["image"]["name"];
    $image = "./../img/rooms_images/" . $id . substr($file_name, strrpos($file_name, ".", -1));
    move_uploaded_file($_FILES["image"]["tmp_name"], $image);
}

$query_string = "UPDATE `room` SET `address`='$address',`name`='$name',`description`='$description',`image`='$image' WHERE `id`='$id'";
mysqli_query($connect, $query_string);


?>