<?php
require_once('./../config/connect.php');


function getPOST($key) {
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return null;
    }
}

$query_string = "INSERT INTO `room` (`address`, `name`, `info`, `photo`) VALUES ('".getPOST('address')."', '".getPOST('name')."', '".getPOST('info')."', '".getPOST('photo')."')";

//echo $query_string;
//mysqli_query($connect, $query_string);

$rooms= mysqli_query($connect, "SELECT * FROM `room`");
$rooms->fetch_assoc();
foreach ($rooms as $room) {
}

print_r(json_encode($rooms));

?>