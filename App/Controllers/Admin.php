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

        Application::$filter['phone'] = "";
        Application::$filter['fullname'] = "";
        Application::$filter['booking_date'] = "";
        Application::$filter['application_date'] = "";
        Application::$filter['approved'] = "";
        Application::$filter['address'] = "";
        Application::$filter['time_interval'] = "";

        return print_r(json_encode($applications));
    }

    public function delete(){
        Room::delete($this->route_params["id"]);
    }

    public function accept(){
        return Application::accept($_POST['id']);
    }

    public function reject(){
        return Application::reject($_POST['id']);
    }

    public function add(){

        // Валидация для поля АДРЕС
        if ($_POST["address"] == null)
            return print_r(json_encode(array('fail' => 'Адрес не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["address"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Адреса - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["address"]) > 50)
            return print_r(json_encode(array('fail' => 'Адреса не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["name"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Названиz помещения - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["name"]) > 50)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));

        // Валидация для поля ОПИСАНИЕ
        if (strlen($_POST["description"]) > 255)
            return print_r(json_encode(array('fail' => 'Описание не может быть больше 255 символов.'), JSON_UNESCAPED_UNICODE));

        // Валидация для ИЗОБРАЖЕНИЕ
        if ($_FILES['image'] == null)
            return print_r(json_encode(array('fail' => 'Изображение не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if ($_FILES['image']['size'] > 1024 * 1024 * 20)
            return print_r(json_encode(array('fail' => 'Размер изображения не может превышать 20 Мегабайт.'), JSON_UNESCAPED_UNICODE));
            
        // Создаём помещение и заполняем его данными
        $room = new Room();
        $room->address = $_POST["address"];
        $room->name = $_POST["name"];
        $room->info = $_POST["description"];
            
        // Загружаем изображение на сервер
        $to = "img/" . uniqid(rand(), true) . $_FILES['image']['name'];
        if (!file_put_contents($to, file_get_contents($_FILES['image']['tmp_name']))) 
            return  print_r(json_encode(array('fail' => 'Произошла незвестная ошибка, при загрузке файла на сервер.'), JSON_UNESCAPED_UNICODE));
        $room->image = $to;

        // Сохраняем помещене в базе данных
        $room->save();

        return print_r(json_encode(array('success' => 'Помещение успешно добавлено в базу данных.'), JSON_UNESCAPED_UNICODE));
    }

    public function edit(){

        // Валидация для поля АДРЕС
        if ($_POST["address"] == null)
            return print_r(json_encode(array('fail' => 'Адрес не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["address"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Адреса - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["address"]) > 50)
            return print_r(json_encode(array('fail' => 'Адреса не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["name"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Названиz помещения - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (strlen($_POST["name"]) > 50)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));

        // Валидация для поля ОПИСАНИЕ
        if (strlen($_POST["description"]) > 255)
            return print_r(json_encode(array('fail' => 'Описание не может быть больше 255 символов.'), JSON_UNESCAPED_UNICODE));

        // Получаем помещение по id
        $room = Room::byID($_POST["id"]);
        if ($room == null)
            return print_r(json_encode(array('fail' => 'Неизвестная ошибка получения данных по id.'), JSON_UNESCAPED_UNICODE));
            
        // Заполняем новые данные
        $room->address = $_POST["address"];
        $room->name = $_POST["name"];
        $room->info = $_POST["description"];

        // Если изображения есть, то меняем его
        if ($_FILES['image'] != null){
            // Валидация для ИЗОБРАЖЕНИЕ
            if ($_FILES['image']['size'] > 1024 * 1024 * 20)
                return print_r(json_encode(array('fail' => 'Размер изображения не может превышать 20 Мегабайт.'), JSON_UNESCAPED_UNICODE));
            
            // TODO: Удалить старое изображение с сервера

            // Загружаем изображение на сервер
            $to = "img/" . uniqid(rand(), true) . $_FILES['image']['name'];
            if (!file_put_contents($to, file_get_contents($_FILES['image']['tmp_name']))) 
                return  print_r(json_encode(array('fail' => 'Произошла незвестная ошибка, при загрузке файла на сервер.'), JSON_UNESCAPED_UNICODE));

            // Добавляем новый путь в базу
            $room->image = $to;
        }

        // Обновляем данные
        if (!$room->update())
            return  print_r(json_encode(array('fail' => 'Произошла незвестная ошибка, при загрузке файла на сервер.'), JSON_UNESCAPED_UNICODE));

        return  print_r(json_encode(array('success' => 'Помещение успешно изменено в базе данных.'), JSON_UNESCAPED_UNICODE));
    }
}
