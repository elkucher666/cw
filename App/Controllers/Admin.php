<?php

namespace App\Controllers;

use App\Models\Room;
use \Core\View;
use \App\Models\Application;
use App\Models\Languages;

// TODO: Добавить смену языка
class Admin extends \Core\Controller
{
    private $login = "admin";
    private $pass = "k?8%Zd{oqDW7";
    public function auth(){
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ($_SERVER['PHP_AUTH_USER'] != $this->login || $_SERVER['PHP_AUTH_PW'] != $this->pass) {
                header('WWW-Authenticate: Basic realm=\"Restricted Section\"');
                header(' HTTP/1.0 401 Unauthorized');
                die("Неправельное имя пользователя или пароль");
            }
        } else {
            header('WWW-Authenticate: Basic realm=\"Restricted Section\"');
            header(' HTTP/1.0 401 Unauthorized');
            die("Пожалуйста, введите имя пользователя и пароль");
        }
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public $lang_list = [
        "ru",
        "en",
    ];
        

    public function setLang() {

        session_start();
        if (in_array($this->route_params["lang"], $this->lang_list)){
            $_SESSION["lang"] = $this->route_params["lang"];
        } else {
            $_SESSION["lang"] = "ru";
        }

        return header("Location: admin");
    }
    
    public function indexAction()
    {
        $this->auth();
        
        session_start();
        if (!isset($_SESSION["lang"])){
            $_SESSION["lang"] = "ru";
        }

        $lang= new Languages($_SESSION["lang"]);
        $data = [
            'name' => $lang->get('NAME'),
            'fio'=>$lang->get('FIO'),
            'phone'=>$lang->get('PHONE'),
            'booking_date' => $lang->get('BOOKING_DATE'),
            'status' => $lang->get('STATUS'),
            'status_all' => $lang->get('STATUS_ALL'),
            'status_under_consideration' => $lang->get('STATUS_UNDER_CONSIDERATION'),
            'status_approved' => $lang->get('STATUS_APPROVED'),
            'status_disapproved' => $lang->get('STATUS_DISAPPROVED'),
            'btn_accept'=> $lang->get('BTN_ACCEPT'),
            'btn_clear'=> $lang->get('BTN_CLEAR'),
            'application_date' => $lang->get('APPLICATION_DATE'),
            'address' => $lang->get('ADDRESS'),             
            'today' => $lang->get('TODAY'),
            'week' => $lang->get('WEEK'),
            'month' => $lang->get('MONTH'),
            'all_time' => $lang->get('ALL_TIME'),
            'table_booking_date' => $lang->get('TABLE_BOOKING_DATE'),
            'table_time' => $lang->get('TABLE_TIME'),
            'table_fio' => $lang->get('TABLE_FIO'),
            'table_phone' => $lang->get('TABLE_PHONE'),
            'table_address' => $lang->get('TABLE_ADDRESS'),
            'table_application_date' => $lang->get('TABLE_APPLICATION_DATE'),
            'table_status' => $lang->get('TABLE_STATUS'),
            'table_room_name' => $lang->get('TABLE_ROOM_NAME'),
            'table_room_address' => $lang->get('TABLE_ROOM_ADDRESS'),
            'table_room_information' => $lang->get('TABLE_ROOM_INFORMATION'),
            'table_room_image' => $lang->get('TABLE_ROOM_IMAGE'),
            'table_room_edit' => $lang->get('TABLE_ROOM_EDIT'),
            'btn_add' => $lang->get('BTN_ADD'),
            'add_room' => $lang->get('ADD_ROOM'),
            'room_name' => $lang->get('ROOM_NAME'),
            'description' => $lang->get('DESCRIPTION'),
            'image' => $lang->get('IMAGE'),
            'edit_room' => $lang->get('EDIT_ROOM'),
            'btn_edit' => $lang->get('BTN_EDIT'),
            'delete_message' => $lang->get('DELETE_MESSAGE'),
        ];
        View::renderTemplate('Home/admin.html', $data);
    }

    public function filter(){
        $this->auth();

        // Заполняем фильтры
        Application::$filter['phone'] = $_POST['phone']; 
        Application::$filter['fullname'] = $_POST['fullname']; 
        Application::$filter['booking_date'] = $_POST['booking_date'];
        Application::$filter['application_date'] = $_POST['application_date']; 
        Application::$filter['approved'] = $_POST['approved']; 
        Application::$filter['address'] = $_POST['address']; 
        Application::$filter['time_interval'] = $_POST['time_interval']; 
        
        // Получаем результат фильтрации
        $applications = Application::filter();

        // Обнуляем фильтры
        Application::$filter['phone'] = "";
        Application::$filter['fullname'] = "";
        Application::$filter['booking_date'] = "";
        Application::$filter['application_date'] = "";
        Application::$filter['approved'] = "";
        Application::$filter['address'] = "";
        Application::$filter['time_interval'] = "";

        // Возвращем результат
        return print_r(json_encode($applications));
    }

    public function delete(){
        $this->auth();

        if (!Room::delete($this->route_params["id"]))
            return print_r(json_encode(array('fail' => 'Помещение не было удалено из-за неизвестной ошибки.'), JSON_UNESCAPED_UNICODE));

        return print_r(json_encode(array('success' => 'Помещение успешно удалено.'), JSON_UNESCAPED_UNICODE));
    }

    public function accept(){
        $this->auth();
        return Application::accept($this->route_params['id']);
    }

    public function reject(){
        $this->auth();
        return Application::reject($this->route_params['id']);
    }

    public function add(){
        $this->auth();
        $lang= new Languages($_SESSION["lang"]);

        // Валидация для поля АДРЕС
        if ($_POST["address"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_ADDRESS')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) < 5)                                    
            return print_r(json_encode(array('fail' => $lang->get('MIN_ADDRESS')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) > 50)                                   
            return print_r(json_encode(array('fail' => $lang->get('MAX_ADDRESS')), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_NAME_ROOM')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) < 5)                         
            return print_r(json_encode(array('fail' => $lang->get('MIN_NAME_ROOM')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) > 50)                         
            return print_r(json_encode(array('fail' => $lang->get('MAX_NAME_ROOM')), JSON_UNESCAPED_UNICODE));

        // Валидация для поля ОПИСАНИЕ
        if (iconv_strlen($_POST["info"]) > 255)
            return print_r(json_encode(array('fail' => $lang->get('MAX_DESCRIPTION')), JSON_UNESCAPED_UNICODE));

        // Валидация для ИЗОБРАЖЕНИЕ
        if ($_FILES['image'] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_IMAGE')), JSON_UNESCAPED_UNICODE));
        if ($_FILES['image']['size'] > 1024 * 1024 * 20)
            return print_r(json_encode(array('fail' => $lang->get('MAX_IMAGE')), JSON_UNESCAPED_UNICODE));
            
        // Создаём помещение и заполняем его данными
        $room = new Room();
        $room->address = $_POST["address"];
        $room->name = $_POST["name"];
        $room->info = $_POST["info"];
            
        // Загружаем изображение на сервер
        $to = "img/" . uniqid(rand(), true) . $_FILES['image']['name'];
        if (!file_put_contents($to, file_get_contents($_FILES['image']['tmp_name']))) 
            return  print_r(json_encode(array('fail' => $lang->get('UNKNOWN_LOAD')), JSON_UNESCAPED_UNICODE));
        $room->image = $to;

        // Сохраняем помещене в базе данных
        $room->save();

        return print_r(json_encode(array('success' => $lang->get('SUCCESSFULL_ADDED')), JSON_UNESCAPED_UNICODE));
    }

    public function edit(){
        $this->auth();
        $lang= new Languages($_SESSION["lang"]);
        
        // Валидация для поля АДРЕС
        if ($_POST["address"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_ADDRESS')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) < 5)                                               
            return print_r(json_encode(array('fail' => $lang->get('MIN_ADDRESS')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) > 50)                                                       
            return print_r(json_encode(array('fail' => $lang->get('MAX_ADDRESS')), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_NAME_ROOM')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) < 5)                                                                                                      
            return print_r(json_encode(array('fail' => $lang->get('MIN_NAME_ROOM')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) > 50)                                                                                      
            return print_r(json_encode(array('fail' => $lang->get('MAX_NAME_ROOM')), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля ОПИСАНИЕ
        if (iconv_strlen($_POST["info"]) > 255)
            return print_r(json_encode(array('fail' => $lang->get('SUCCESSFULL_ADDED')), JSON_UNESCAPED_UNICODE));

        // Получаем помещение по id
        $room = Room::byID($_POST["id"]);
        if ($room == null)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWN_ID')), JSON_UNESCAPED_UNICODE));
        
        // Заполняем новые данные
        $room->address = $_POST["address"];
        $room->name = $_POST["name"];
        $room->info = $_POST["info"];

        // Если изображения есть, то меняем его
        if ($_FILES['image']['size'] != 0){

            // Валидация для ИЗОБРАЖЕНИЕ
            if ($_FILES['image']['size'] > 1024 * 1024 * 20)
                return print_r(json_encode(array('fail' => $lang->get('MAX_IMAGE')), JSON_UNESCAPED_UNICODE));
            
                
            // Загружаем изображение на сервер
            $to = "img/" . uniqid(rand(), true) . $_FILES['image']['name'];
            if (!file_put_contents($to, file_get_contents($_FILES['image']['tmp_name']))) 
                return  print_r(json_encode(array('fail' => $lang->get('UNKNOWN_LOAD')), JSON_UNESCAPED_UNICODE));

            unlink($room->image);   

            // Добавляем новый путь в базу
            $room->image = $to;
        }

        // Обновляем данные
        if (!$room->update())
            return  print_r(json_encode(array('fail' => $lang->get('UNKNOWN_LOAD_DELETE')), JSON_UNESCAPED_UNICODE));

        return  print_r(json_encode(array('success' => $lang->get('SUCCESSFULL_EDIT')), JSON_UNESCAPED_UNICODE));
    }
}
