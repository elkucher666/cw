<?php
require_once('./../config/connect.php');



$query ="SELECT `application`.`id`, `application`.`booking_date`, `application`.`booking_start`, `application`.`booking_end`, `application`.`fullname`, `application`.`phone`, `room`.`address`, `room`.`name`, `application`.`application_date`, `application`.`approved` FROM `application`, `room` WHERE `application`.`id_room`=`room`.`id` ";

$time_interval = $_POST["time_interval"];

if ($time_interval == "today") {
    $query .= 'AND `application`.`application_date` LIKE REPLACE(CONCAT(CURRENT_DATE), "-", ".")';
} else if ($time_interval == "current_week") {
    $query .= "AND WEEK(`application`.`application_date`,1) = WEEK(CURRENT_DATE,1)";
} else if ($time_interval == "current_month") {
    $query .= "AND `application`.`application_date` LIKE CONCAT('____-%',MONTH(CURRENT_DATE),'-%')";
}



$result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_ASSOC);

$result["query"] = $query;

print_r(json_encode($result));

?>