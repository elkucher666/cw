<?php

namespace App\Controllers;

use App\Models\Room;
use \Core\View;
use \App\Models\Application;

// TODO: Добавить проверку авторизованности администратора
// TODO: Добавить смену языка
class Admin extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        // $realm = 'Запретная зона';

        // $users = array('admin' => 'mypass', 'guest' => 'guest');

        // // echo $_SERVER['PHP_AUTH_DIGEST'];
        // if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        //     header('HTTP/1.1 401 Unauthorized');
        //     header('WWW-Authenticate: Digest realm="'.$realm.
        //         '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

        //     die('Текст, отправляемый в том случае, если пользователь нажал кнопку Cancel');
        // }


        // // анализируем переменную PHP_AUTH_DIGEST
        // if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
        //     !isset($users[$data['username']]))
        //     die('Неправильные данные!');


        // // генерируем корректный ответ
        // $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
        // $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
        // $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

        // if ($data['response'] != $valid_response)
        //     die('Неправильные данные!');

        // // все хорошо, логин и пароль верны
        // echo 'Вы вошли как: ' . $data['username'];


        // // функция разбора заголовка http auth
        // function http_digest_parse($txt)
        // {
        //     // защита от отсутствующих данных
        //     $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        //     $data = array();
        //     $keys = implode('|', array_keys($needed_parts));

        //     preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        //     foreach ($matches as $m) {
        //         $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        //         unset($needed_parts[$m[1]]);
        //     }

        //     return $needed_parts ? false : $data;
        // }

        View::renderTemplate('Home/admin.html');
    }

    public function filter(){

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
        Room::delete($this->route_params["id"]);
    }

    public function accept(){
        return Application::accept($this->route_params['id']);
    }

    public function reject(){
        return Application::reject($this->route_params['id']);
    }

    public function add(){

        // Валидация для поля АДРЕС
        if ($_POST["address"] == null)
            return print_r(json_encode(array('fail' => 'Адрес не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Адреса - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) > 50)
            return print_r(json_encode(array('fail' => 'Адреса не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Названиz помещения - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) > 50)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));

        // Валидация для поля ОПИСАНИЕ
        if (iconv_strlen($_POST["info"]) > 255)
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
        $room->info = $_POST["info"];
            
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
        if (iconv_strlen($_POST["address"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Адреса - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["address"]) > 50)
            return print_r(json_encode(array('fail' => 'Адреса не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля НАЗВАНИЕ ПОМЕЩЕНИЯ
        if ($_POST["name"] == null)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть пустым.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) < 5)
            return print_r(json_encode(array('fail' => 'Минимальная длина Названиz помещения - 5 символов.'), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["name"]) > 50)
            return print_r(json_encode(array('fail' => 'Название помещения не может быть больше 50 символов.'), JSON_UNESCAPED_UNICODE));
        
        // Валидация для поля ОПИСАНИЕ
        if (iconv_strlen($_POST["info"]) > 255)
            return print_r(json_encode(array('fail' => 'Описание не может быть больше 255 символов.'), JSON_UNESCAPED_UNICODE));

        // Получаем помещение по id
        $room = Room::byID($_POST["id"]);
        if ($room == null)
            return print_r(json_encode(array('fail' => 'Неизвестная ошибка получения данных по id.'), JSON_UNESCAPED_UNICODE));
        
        // Заполняем новые данные
        $room->address = $_POST["address"];
        $room->name = $_POST["name"];
        $room->info = $_POST["info"];

        // Если изображения есть, то меняем его
        if ($_FILES['image']['size'] != 0){

            // Валидация для ИЗОБРАЖЕНИЕ
            if ($_FILES['image']['size'] > 1024 * 1024 * 20)
                return print_r(json_encode(array('fail' => 'Размер изображения не может превышать 20 Мегабайт.'), JSON_UNESCAPED_UNICODE));
            
                
            // Загружаем изображение на сервер
            $to = "img/" . uniqid(rand(), true) . $_FILES['image']['name'];
            if (!file_put_contents($to, file_get_contents($_FILES['image']['tmp_name']))) 
                return  print_r(json_encode(array('fail' => 'Произошла незвестная ошибка, при загрузке файла на сервер.'), JSON_UNESCAPED_UNICODE));

            unlink($room->image);    

            // Добавляем новый путь в базу
            $room->image = $to;
        }

        // Обновляем данные
        if (!$room->update())
            return  print_r(json_encode(array('fail' => 'Произошла незвестная ошибка, при загрузке файла на сервер. Предыдущее изображение было удалено.'), JSON_UNESCAPED_UNICODE));

        return  print_r(json_encode(array('success' => 'Помещение успешно изменено в базе данных.'), JSON_UNESCAPED_UNICODE));
    }
}
