<?php
require_once('./../config/connect.php');


function getPOST($key) {
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return null;
    }
}

$query_string = "INSERT INTO `application` (`fullname`, `age`, `institute`, `course`, `phone`, `social_network`, `id_room`, `booking_start`, `booking_end`, `booking_date`,`application_date`) VALUES ('".getPOST('fullname')."', '".getPOST('age')."', '".getPOST('institute')."', '".getPOST('course')."', '".getPOST('phone')."', '".getPOST('social_network')."', '".getPOST('id_room')."', '".getPOST('booking_start')."', '".getPOST('booking_end')."', '".getPOST('booking_date')."', '".getPOST('application_date')."')";

mysqli_query($connect, $query_string);


$a = [
    "key" => "value",
    "ke" => "value",
];

print_r(json_encode($a));


?>