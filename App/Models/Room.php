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
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM room');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function update($id, $address, $name, $description, $image ) {
        $db = static::getDB();
        $stmt = $db->query('UPDATE room SET address=$address, name=$name, description=$description, image=$image WHERE id=$id');
        return $stmt->execute();
    }
    
    public static function delete($id) {
        $db = static::getDB();
        $stmt = $db->query('DELETE FROM room WHERE id=$id');
        return $stmt->execute(); 
    }
}
