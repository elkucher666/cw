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
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
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
        
        // Валидация по полю ФИО
        if ($_POST["fullname"] == null)
            return print_r(json_encode(array('fail' => 'ФИО не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) < 2)
            return print_r(json_encode(array('fail' => 'Минимальная длина ФИО - 2 символа.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) > 120)
            return print_r(json_encode(array('fail' => 'ФИО не может быть больше 120 символов.'), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/^[а-яА-ЯёЁa-zA-Z ]+$/", $_POST["fullname"]))
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
        if ($_POST["course"] == null || strcmp($_POST["institute"], "") == 0)
            return print_r(json_encode(array('fail' => 'Курс не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (!in_array($_POST["course"], $this->course_list))
            return print_r(json_encode(array('fail' => 'Курс не входит в допущенный массив.'), JSON_UNESCAPED_UNICODE));

        // Валидация по полю ТЕЛЕФОН
        if ($_POST["phone"] == null)
            return print_r(json_encode(array('fail' => 'Телефон не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["phone"]) > 20)
            return print_r(json_encode(array('fail' => 'Телефон не может быть больше 20 символов.'), JSON_UNESCAPED_UNICODE));    
        if (!preg_match("/((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,20}/", $_POST["phone"]))
            return print_r(json_encode(array('fail' => 'Телефон должен соответстовать формату.'), JSON_UNESCAPED_UNICODE));

        // Валидация по полю КОНТАКТЫ
        if ($_POST["social_network"] == null)
            return print_r(json_encode(array('fail' => 'Контакты не могут быть пустыми.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["social_network"]) > 120)
            return print_r(json_encode(array('fail' => 'Контакты не могут быть больше 120 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю booking_start
        if ($_POST['booking_start'] == null)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_start']) > 5)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[12]\d:00/", $_POST['booking_start']))
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю booking_end
        if ($_POST['booking_end'] == null)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_end']) > 5)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[12]\d:00/", $_POST['booking_end']))
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));

        // Валидация по полю booking_date
        if ($_POST['booking_date'] == null)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_date']) > 10)
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[0123]\d.[01]\d.\d\d\d\d/", $_POST['booking_date']))
            return print_r(json_encode(array('fail' => 'Не известная ошибка формирования заявки. Вы пытаетесь нас взломать? Остановитесь! Прекратите!'), JSON_UNESCAPED_UNICODE));

        // Валидация корректной брони
        $booking_time_start = date("H:i", strtotime($_POST['booking_start']));
        $booking_time_end = date("H:i", strtotime($_POST['booking_end']));
        if (date("H:i", strtotime($_POST['booking_start'])) > date("H:i", strtotime($_POST['booking_end'])))
            return print_r(json_encode(array('fail' => 'Невозможно забронировать с '.$_POST['booking_start'].' на '.$_POST['booking_start']), JSON_UNESCAPED_UNICODE));

        // Валидация возможности брони
        $booking_start = date("Y-m-d H:i", strtotime($_POST['booking_date'] . $_POST['booking_start']));
        $today_time = date("Y-m-d H:i", time());
        if ($booking_start <= $today_time)
            return print_r(json_encode(array('fail' => 'Невозможно забронировать помещение на данную дату и данное время.'), JSON_UNESCAPED_UNICODE));

        // Валидация по возможности забронировать на данное помещение, время и данную дату
        $apps = Application::byRoomIDandBookingDate($_POST['id_room'], date("Y-m-d", strtotime($_POST['booking_date'])));
        foreach($apps as $app){
            
            // Пропускаем все не подтверждённые заявки и заявки на рассмотрении
            if ($app['approved'] != 1)
                continue;
            
            // Узнаём время бронирования
            $start = date("H:i", strtotime($app['booking_start']));
            $end = date("H:i", strtotime($app['booking_end']));

            // Сравниваем занятое время с занимаемым
            if ($booking_time_start > $start && $booking_time_start < $end || $booking_time_end > $start && $booking_time_end < $end)
                return print_r(json_encode(array('fail' => 'На данное время, дату и помещение уже существует подтверждённая бронь.'), JSON_UNESCAPED_UNICODE));
        }
        
        // Создаём новую заявку
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
        $application->created_at = date("Y-m-d H:i:s"); 
        $application->approved = 0;
        $application->save();
        
        return print_r(json_encode(array('success' => 'Ваша зявка отправлена на рассмотрения Администратору. В течение будних суток с вами свяжутся.'), JSON_UNESCAPED_UNICODE));
    }

    public function loadCalendarToRoom() {
        $dates = Application::loadBooking($this->route_params["id"]);
        return print_r(json_encode($dates));
    }
}
