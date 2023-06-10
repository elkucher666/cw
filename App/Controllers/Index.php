<?php

namespace App\Controllers;

use App\Models\Application;
use \Core\View;
use \App\Models\Room;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Index extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Home/index.html');
    }

    public function roomsLoader(){
        $rooms = Room::getAll();
        return print_r(json_encode($rooms));
    }

    public function applicationPost() {
        // TODO: Добавить валидацию
        $application = new Application();

        $application->age = $_POST['age'];
        $application->fullname = $_POST['fullname']; 
        $application->institute = $_POST['institute']; 
        $application->course = $_POST['course']; 
        $application->phone = $_POST['phone'];
        $application->social_network = $_POST['social_network']; 
        $application->id_room = $_POST['id_room']; 
        $application->booking_date = date("Y-m-d", strtotime($_POST['booking_date'])); 
        $application->booking_start = $_POST['booking_start']; 
        $application->booking_end = $_POST['booking_end']; 
        $application->created_at =  date("Y-m-d H:i:s", strtotime($_POST['application_date']));
        $application->approved = 0;
        $application->save();
        
        // TODO: Убрать хардкод
        return header('Location: /php-mvc-master/public/');
    }

    public function loadCalendarToRoom() {
        $dates = Application::loadBooking($this->route_params["id"]);
        return print_r(json_encode($dates));
    }
}
