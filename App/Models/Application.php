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
        "approved" => "",
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

    public static function filter(){
        $sql = "SELECT * FROM application as a, room as r WHERE a.id_room = r.id";
        
        $filt = array();
        // Выводим в определённых временных отрезках
        if (strcmp(Application::$filter['time_interval'], 'today') == 0){
            $sql .= " AND DAY(a.booking_date) = DAY(NOW())";
        } else if (strcmp(Application::$filter['time_interval'], "current_week") == 0){
            $sql .= " AND WEEK(a.booking_date,1) = WEEK(NOW(),1)";
        } else if (strcmp(Application::$filter['time_interval'], "current_month") == 0){
            $sql .= " AND MONTH(a.booking_date) = MONTH(NOW())";
        }

        // Фильтрация в определённых временных отрезках по дате бронирования
        if (strcmp(Application::$filter['booking_date'], '') != 0){
            $sql .= " AND a.booking_date LIKE :booking_date";
            $filt[':booking_date'] = Application::$filter['booking_date'];
        }

        // Фильтрация в определённых временных отрезках по дате заявке
        if (strcmp(Application::$filter['application_date'], '') != 0){
            $sql .= " AND a.created_at LIKE :application_date";
            $filt[':application_date'] = Application::$filter['application_date'];
        }

        // Фильтрация по ФИО
        if (strcmp(Application::$filter['fullname'], '') != 0) {
            $sql .= " AND a.fullname LIKE :fullname";
            $filt[':fullname'] = '%'.Application::$filter['fullname'].'%';
        }

        // Фильтрация по телефону
        if (strcmp(Application::$filter['phone'], '') != 0) {
            $sql .= " AND a.phone LIKE :phone";
            $filt[':phone'] = '%'.Application::$filter['phone'].'%';
        }

        // Фильтрация по адресу
        if (strcmp(Application::$filter['address'], '') != 0) {
            $sql .= " AND r.address = :address";
            $filt[':address'] = Application::$filter['address'];
        }

        // Фильтрация по состоянию
        if (strcmp(Application::$filter['approved'], '') != 0) {
            $sql .= " AND a.approved = :approved";
            $filt[':approved'] = Application::$filter['approved'];
        }
        
        $query = static::getDB()->prepare($sql);
        $query->execute($filt);
        return $query->fetchAll();
    }
    
    // public static function update($id, $address, $name, $description, $image ) {
    //     $db = static::getDB();
    //     $stmt = $db->query('UPDATE application SET address=$address, name=$name, description=$description, image=$image WHERE id=$id');
    //     return $stmt->execute();
    // }
    
    public static function reject($id) {
        $db = static::getDB();
        $sql = "UPDATE application SET approved=2 WHERE id=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute(array($id));
    }

    public static function byRoomIDandBookingDate($id_room, $booking_date){
        $db = static::getDB();
        $sql = "SELECT * FROM application WHERE id_room=:id_room AND booking_date=:booking_date";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_room', $id_room);
        $stmt->bindValue(':booking_date', $booking_date);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function accept($id) {
        $db = static::getDB();
        $sql = "UPDATE application SET approved=1 WHERE id=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute(array($id));
    }

    public static function append($booking_start, $booking_end, $fullname, $age, $institute, $course, $phone, $social_network, $created_at, $id_room, $booking_date) {
        $db = static::getDB();
        $stmt = $db->query('INSERT INTO application (booking_start, booking_end, fullname, age, institute, course, phone, social_network, created_at, id_room, booking_date, approved) VALUES ("'.$booking_start.'", "'.$booking_end.'", "'.$fullname.'", "'.$age.'", "'.$institute.'", "'.$course.'", "'.$phone.'", "'.$social_network.'", "'.$created_at.'", "'.$id_room.'", "'.$booking_date.'", 0)');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function loadBooking($id) {
        $db = static::getDB();
        $stmt = $db->query('SELECT booking_date, booking_start, booking_end FROM application WHERE id_room='.$id.' and approved=1');
        if ($stmt == false)
            return null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}