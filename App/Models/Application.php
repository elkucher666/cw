<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Application extends \Core\Model
{
    public $id; //int11
    public $fullname; //text
    public $age; //int11
    public $institute; //text
    public $course; //int11
    public $phone; //varchar(20)
    public $social_network; //text
    public $id_room; //int11
    public $booking_date; //date
    public $booking_start; //time
    public $booking_end; //time
    public $created_at ; //date
    public $approved; // int11
    public static $filter = [
        "phone" => "",
        "fullname" => "",
        "booking_date" => "",
        "application_date" => "",
        "approved" => 0,
        "address" => "",
        "time_interval" => "",
    ];

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query('SELECT a.id, a.booking_date, a.booking_start, a.booking_end, a.fullname, a.phone, r.address, r.name, a.created_at, a.approved FROM application as a, room as r WHERE a.id_room=r.id');
        return $stmt->fetchAll();
    }

    public function save() {
        $sql = "INSERT INTO application (fullname, age, institute, course, phone, social_network, id_room, booking_date, booking_end, booking_start, created_at, approved) VALUES (:fullname, :age, :institute, :course, :phone, :social_network, :id_room, :booking_date, :booking_end, :booking_start, :created_at, :approved)";
        $query = static::getDB()->prepare($sql);

        $query->bindValue(":fullname", $this->fullname);
        $query->bindValue(":age", $this->age);
        $query->bindValue(":institute", $this->institute);
        $query->bindValue(":course", $this->course);
        $query->bindValue(":phone", $this->phone);
        $query->bindValue(":social_network", $this->social_network);
        $query->bindValue(":id_room", $this->id_room);
        $query->bindValue(":booking_date", $this->booking_date);
        $query->bindValue(":booking_end", $this->booking_end);
        $query->bindValue(":booking_start", $this->booking_start);
        $query->bindValue(":created_at", $this->created_at);
        $query->bindValue(":approved", $this->approved);

        return $query->execute();
        /*
        [
            "age" => $this->age,
            "institute" => $this->institute,
            "course" => $this->course,
            "phone" => $this->phone,
            "social_network" => $this->social_network,
            "id_room" => $this->id_room,
            "booking_date" => $this->booking_date,
            "booking_end" => $this->booking_end,
            "booking_start" => $this->booking_start,
            "created_at" => $this->created_at,
            "approved" => $this->approved,
        ]
        */
    }

    public static function delete($id){
        // TODO: Сделать удаление
    }

    public static function byID(int $id) : Application|null {
        $sql = "SELECT * FROM application WHERE id=:id";
        $query = static::getDB()->prepare($sql);
        if ($query == false)
            return null;

        $query->bindValue(":id", $id);
        $result = $query->fetch();
        if ($result == false)
            return null;
 
        $application = new Application();
        $application->id = $result["id"];
        $application->fullname = $result["fullname"];
        $application->age = $result["age"];
        $application->institute = $result["institute"];
        $application->course = $result["course"];
        $application->phone = $result["phone"];
        $application->social_network = $result["social_network"];
        $application->id_room = $result["id_room"];
        $application->booking_date = $result["booking_date"];
        $application->booking_end = $result["booking_end"];
        $application->booking_start = $result["booking_start"];
        $application->created_at = $result["created_at"];
        $application->approved = $result["approved"];
        return $application;
    }

    public function a(){

    }
    /*
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


print_r(json_encode($result));

?>
         */
    
    // public static function update($id, $address, $name, $description, $image ) {
    //     $db = static::getDB();
    //     $stmt = $db->query('UPDATE application SET address=$address, name=$name, description=$description, image=$image WHERE id=$id');
    //     return $stmt->execute();
    // }
    
    // public static function delete($id) {
    //     $db = static::getDB();
    //     $stmt = $db->query('DELETE FROM application WHERE id=$id');
    //     return $stmt->execute(); 
    // }

    public static function reject($id) {
        $db = static::getDB();
        $stmt = $db->query('UPDATE application SET approved=0 WHERE id=$id');
        return $stmt->execute();
    }

    public static function accept($id) {
        $db = static::getDB();
        $stmt = $db->query('UPDATE application SET approved=1 WHERE id=$id');
        return $stmt->execute();
    }

    public static function append($booking_start, $booking_end, $fullname, $age, $institute, $course, $phone, $social_network, $created_at, $id_room, $booking_date) {
        $db = static::getDB();
        $stmt = $db->query('INSERT INTO application (booking_start, booking_end, fullname, age, institute, course, phone, social_network, created_at, id_room, booking_date, approved) VALUES ("'.$booking_start.'", "'.$booking_end.'", "'.$fullname.'", "'.$age.'", "'.$institute.'", "'.$course.'", "'.$phone.'", "'.$social_network.'", "'.$created_at.'", "'.$id_room.'", "'.$booking_date.'", 0)');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function loadBooking($id) {
        $db = static::getDB();
        $stmt = $db->query('SELECT booking_date, booking_start, booking_end FROM application WHERE id_room='.$id.' and approved=1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}