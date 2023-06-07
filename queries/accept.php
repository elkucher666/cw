<?php
require_once('./../config/connect.php');

$id = $_POST["id"];

$query ="UPDATE `application` SET `approved`='1' WHERE `id`='$id'";

mysqli_query($connect, $query);
?>