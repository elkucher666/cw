<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Room extends \Core\Model
{

    public $id; //int11
    public $address; //text
    public $name; //text
    public $info; //text
    public $image; //text

    
    /**
     * Get all the users as an associative array
     *
     * @return array
     */


     public function save(){
        $sql = "INSERT INTO room (address, name, info, image) VALUES (:address, :name, :description, :image)";
        $query = static::getDB()->prepare($sql);

        $query->bindValue(":address", $this->address);
        $query->bindValue(":name", $this->name);
        $query->bindValue(":description", $this->info);
        $query->bindValue(":image", $this->image);

        return $query->execute();

    }

    public function edit($id) {
        $sql= "UPDATE room SET address=:address, name=:name, info=:description, image=:image WHERE id=:id";
        $query = static::getDB()->prepare($sql);
        $query->bindValue(":id", $id);
        
        $query->bindValue(":address", $this->address);
        $query->bindValue(":name", $this->name);
        $query->bindValue(":description", $this->info);
        $query->bindValue(":image", $this->image);

        return $query->execute();
    }

    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM room');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function delete($id){
        $db = static::getDB();
        $sql = "delete from room WHERE id=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute(array($id));
    }

}
