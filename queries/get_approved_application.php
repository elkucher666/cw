<?php
require_once('./../config/connect.php');

$query ="SELECT * FROM `application` WHERE `application`.`approved`";
$result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_ASSOC);

print_r(json_encode($result));
?>