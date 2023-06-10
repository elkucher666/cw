<?php

namespace App\Controllers;

use App\Models\Room;
use \Core\View;
use \App\Models\Application;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Admin extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/admin.html');
    }

    public function filter(){
        // TODO: Добавить валидацию
        Application::$filter['phone'] = $_POST['phone']; 
        Application::$filter['fullname'] = $_POST['fullname']; 
        Application::$filter['booking_date'] = $_POST['booking_date'];
        Application::$filter['application_date'] = $_POST['application_date']; 
        Application::$filter['approved'] = $_POST['approved']; 
        Application::$filter['address'] = $_POST['address']; 
        Application::$filter['time_interval'] = $_POST['time_interval']; 
        
        $applications = Application::filter();
        // foreach($applications as $app) {
        //     echo $app . "\n";
        // }

        Application::$filter['phone'] = "";
        Application::$filter['fullname'] = "";
        Application::$filter['booking_date'] = "";
        Application::$filter['application_date'] = "";
        Application::$filter['approved'] = "";
        Application::$filter['address'] = "";
        Application::$filter['time_interval'] = "";

        // echo "<br>1". $_POST['phone'];
        // echo "<br>2". $_POST['fullname'];
        // echo "<br>3". $_POST['booking_date'];
        // echo "<br>4". $_POST['application_date'];
        // echo "<br>5". $_POST['approved'];
        // echo "<br>6". $_POST['address'];
        // echo "<br>7". $_POST['time_interval'];

        // TODO: Написать обработку запроса в Application
        // echo print_r(json_encode(Application::getAll()));
        return print_r(json_encode($applications));
    }

    public function delete(){
        Application::delete($this->route_params["id"]);
    }

    public function accept(){
        return Application::accept($_POST['id']);
    }

    public function reject(){
        return Application::reject($_POST['id']);
    }

    public function add(){
        // TODO: Добавить валидацию
        // TODO: Добавить загрузку данных на сервер

        // $room = new Room();

        // $room->id = 3;
        // $room->address = $_POST["address"];
        // $room->name = $_POST["name"];
        // $room->info = $_POST["description"];
        // $room->image = $_POST["image"];

        return ;
    }

    public function edit(){
        // TODO: Добавить валидацию
        // TODO: Добавить загрузку данных на сервер

        // $room = new Room();

        // $room->id = 3;
        // $room->address = $_POST["address"];
        // $room->name = $_POST["name"];
        // $room->info = $_POST["description"];
        // $room->image = $_POST["image"];

        return ;
    }
}
