<?php
require_once('./../config/connect.php');


function getPOST($key) {
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return null;
    }
}


$query_string = "SELECT max(`id`) from `room`";

$file_name = $_FILES["image"]["name"];

$image = "./../img/" . (mysqli_query($connect, $query_string)->fetch_assoc()["max(`id`)"] + 1) . substr($file_name, strrpos($file_name, ".", -1));

move_uploaded_file($_FILES["image"]["tmp_name"], $image);

$query_string = "INSERT INTO `room` (`address`, `name`, `description`, `image`) VALUES ('".getPOST('address')."', '".getPOST('name')."', '".getPOST('description')."', '".$image."')";

mysqli_query($connect, $query_string);


?>