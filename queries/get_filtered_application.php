<?php
require_once('./../config/connect.php');



$query ="SELECT `application`.`id`, `application`.`booking_date`, `application`.`booking_start`, `application`.`booking_end`, `application`.`fullname`, `application`.`phone`, `room`.`address`, `room`.`name`, `application`.`application_date`, `application`.`approved` FROM `application`, `room` WHERE `application`.`id_room`=`room`.`id` ";


$time_interval = $_POST["time_interval"];
$phone = $_POST["phone"];
$fullname = $_POST["fullname"];
$booking_date = $_POST["booking_date"];
$application_date = $_POST["application_date"];
$approved = $_POST["approved"];
$address = $_POST["address"];

if ($time_interval == "today") {
    $query .= "AND `application`.`application_date` LIKE CONCAT(DATE_FORMAT(CURRENT_DATE,'%d.%m.%Y'), '%') ";
} else if ($time_interval == "current_week") {
    $query .= "AND WEEK(STR_TO_DATE(SUBSTRING(`application`.`application_date`, 1, 10), GET_FORMAT(DATE,'EUR')),1) = WEEK(CURRENT_DATE,1) ";
} else if ($time_interval == "current_month") {
    $query .= "AND `application`.`application_date` LIKE CONCAT('%.%', MONTH(CURRENT_DATE), '.', YEAR(CURRENT_DATE), '%') ";
}

if (isset($fullname)) {
    $query .= "AND `application`.`fullname` LIKE '%$fullname%' ";
}

if (isset($phone)) {
    $query .= "AND `application`.`phone` LIKE '%$phone%' ";
}

if (isset($booking_date)) {
    $query .= "AND `application`.`booking_date` LIKE '%$booking_date%' ";
}

if (isset($application_date)) {
    $query .= "AND `application`.`application_date` LIKE '%$application_date%' ";
}

if (isset($approved)) {
    $query .= "AND `application`.`approved` LIKE '%$approved%' ";
}

if (isset($address)) {
    $query .= "AND `room`.`address` LIKE '%$address%' ";
}





$result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_ASSOC);

// $result["query"] = $query;

print_r(json_encode($result));

?>