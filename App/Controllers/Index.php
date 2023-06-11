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

    // Список допущенных институтов
    public $institute_list = [
        "Другое",
        "ИИТ",
        "ИЯЭиП",
        "ЮИ",
        "МИ",
        "ИРиИТС",
        "ИФЭиУ",
        "ПИ",
        "ИОНиМО",
        "ГПИ",
        "ИФМиЗ",
        "ИРГ",
        "ИПИ",
        "Морской Колледж",
        "Аспирантура",
    ];

    // Список допущенных курсов
    public $course_list = [
        "Другое",
        "1 курс",
        "2 курс",
        "3 курс",
        "4 курс",
        "1 курс магистратура",
        "2 курс магистратура",
    ];

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

        // Валидация по полю ФИО
        if ($_POST["fullname"] == null)
            return print_r(json_encode(array('fail' => 'ФИО не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) < 2)
            return print_r(json_encode(array('fail' => 'Минимальная длина ФИО - 2 символа.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) > 120)
            return print_r(json_encode(array('fail' => 'ФИО не может быть больше 120 символов.'), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/^[А-яёЁ ,.'-]+$/", $_POST["fullname"]))
            return print_r(json_encode(array('fail' => 'ФИО должен содеражть только буквы.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю ВОЗРАСТ
        if ($_POST["age"] == null)
            return print_r(json_encode(array('fail' => 'Возраст не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (!is_int((int)$_POST["age"]))
            return print_r(json_encode(array('fail' => 'Возраст должен быть числом.'), JSON_UNESCAPED_UNICODE));
        if (((int) $_POST["age"]) < 16 )
            return print_r(json_encode(array('fail' => 'Вы должны быть старше 16 лет.'), JSON_UNESCAPED_UNICODE));
        if (((int) $_POST["age"]) > 100 )
            return print_r(json_encode(array('fail' => 'Вам серьёзно столько лет?'), JSON_UNESCAPED_UNICODE));

        // Валидация по полю ИНСТИТУТ
        if ($_POST["institute"] == null || strcmp($_POST["institute"], "Выберите институт") == 0)
            return print_r(json_encode(array('fail' => 'Выберите институт.'), JSON_UNESCAPED_UNICODE));
        if (!in_array($_POST["institute"], $this->institute_list))
            return print_r(json_encode(array('fail' => 'Институт не входит в допущенный массив.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю КУРС
        if ($_POST["course"] == null)
            return print_r(json_encode(array('fail' => 'Курс не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (!in_array($_POST["course"], $this->course_list))
            return print_r(json_encode(array('fail' => 'Курс не входит в допущенный массив.'), JSON_UNESCAPED_UNICODE));

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
