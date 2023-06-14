<?php

namespace App\Controllers;
use App\Models\Application;
use App\Models\Languages;
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
        "Other",
        "IIT",
        "ILEP",
        "YI",
        "MI",
        "IRITS",
        "IFENU",
        "PI",
        "IONMO",
        "GPI",
        "IFMC",
        "IRG",
        "IPI",
        "Maritime College",
        "Graduate School",
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

    public $language ="en";
        

    public function indexAction()
    {
        $lang= new Languages($this->language);
        $data = [
            'name' => $lang->get('NAME'),
            'welcome' => $lang->get('WELCOME'),
            'calendar' => $lang->get('CALENDAR'),
            'calendar_legend' => $lang->get('CALENDAR_LEGEND'),
            'btn_booking' => $lang->get('BTN_BOOKING'),
            'error_select_message' => $lang->get('ERROR_SELECT_MESSAGE'),
            'error_date_message' => $lang->get('ERROR_DATE_MESSAGE'),
            'contact_information' => $lang->get('CONTACT_INFORMATION'),
            'support_service' => $lang->get('SUPPORT_SERVICE'),
            'form'=>$lang->get('FORM'), 
            'from'=>$lang->get('FROM'),
            'to'=>$lang->get('TO'),
            'fio'=>$lang->get('FIO'),
            'age'=>$lang->get('AGE'),
            'institute'=>$lang->get('INSITUTE'), 
            'institute_select'=>$lang->get('INSITUTE_SELECT'), 
            'institute_other'=>$lang->get('INSITUTE_OTHER'), 
            'institute_maritame_college'=>$lang->get('INSITUTE_MARITAME_COLLEGE'), 
            'institute_postraduare'=>$lang->get('INSITUTE_POSTGRADUATE'),
            'institute_iit'=>$lang->get('INSITUTE_IIT'),
            'institute_ilep'=>$lang->get('INSITUTE_ILEP'),
            'institute_yi'=>$lang->get('INSITUTE_YI'),
            'institute_mi'=>$lang->get('INSITUTE_MI'),
            'institute_irits'=>$lang->get('INSITUTE_IRITS'),
            'institute_ifenu'=>$lang->get('INSITUTE_IFENU'),
            'institute_pi'=>$lang->get('INSITUTE_PI'),
            'institute_ionmo'=>$lang->get('INSITUTE_IONMO'),
            'institute_gpi'=>$lang->get('INSITUTE_GPI'),
            'institute_ifmc'=>$lang->get('INSITUTE_IFMC'),
            'institute_irg'=>$lang->get('INSITUTE_IRG'),
            'institute_ipi'=>$lang->get('INSITUTE_IPI'),
            'course'=>$lang->get('COURSE'),
            'course_select'=>$lang->get('COURSE_SELECT'),
            'course_other'=>$lang->get('COURSE_OTHER'),
            'course_1'=>$lang->get('COURSE_1'),
            'course_2'=>$lang->get('COURSE_2'),
            'course_3'=>$lang->get('COURSE_3'),
            'course_4'=>$lang->get('COURSE_4'),
            'course_1_mage'=>$lang->get('COURSE_1_MAGE'),
            'course_2_mage'=>$lang->get('COURSE_2_MAGE'),
            'phone'=>$lang->get('PHONE'),
            'contacts'=>$lang->get('CONTACTS'),
            
        ];

        View::renderTemplate('Home/index.html', $data);
    }

    public function roomsLoader(){
        $rooms = Room::getAll();
        return print_r(json_encode($rooms));
    }

    public function applicationPost() {
        $lang= new Languages($this->language);
        
        //TODO: баг с региксом фио
        // Валидация по полю ФИО
        if ($_POST["fullname"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_FIO')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) < 2)
            return print_r(json_encode(array('fail' => $lang->get('MIN_FIO')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["fullname"]) > 120)
            return print_r(json_encode(array('fail' => $lang->get('MAX_FIO')), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/^[а-яА-ЯёЁa-zA-Z ]+$/", $_POST["fullname"]))
            return print_r(json_encode(array('fail' => $lang->get('NUMBER_FIO')), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю ВОЗРАСТ
        if ($_POST["age"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_AGE')), JSON_UNESCAPED_UNICODE));
        if (!is_int((int)$_POST["age"]))
            return print_r(json_encode(array('fail' => $lang->get('NUMBER_AGE')), JSON_UNESCAPED_UNICODE));
        if (((int) $_POST["age"]) < 16 )
            return print_r(json_encode(array('fail' => $lang->get('MIN_AGE')), JSON_UNESCAPED_UNICODE));
        if (((int) $_POST["age"]) > 100 )
            return print_r(json_encode(array('fail' => $lang->get('MAX_AGE')), JSON_UNESCAPED_UNICODE));

        // Валидация по полю ИНСТИТУТ
        if ($_POST["institute"] == null || strcmp($_POST["institute"], "Выберите институт") == 0)
            return print_r(json_encode(array('fail' => $lang->get('NULL_INSTITUTE')), JSON_UNESCAPED_UNICODE));
        if (!in_array($_POST["institute"], $this->institute_list))
            return print_r(json_encode(array('fail' => $lang->get('NOT_IN_INSTITUTE')), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю КУРС
        if ($_POST["course"] == null || strcmp($_POST["institute"], "") == 0)
            return print_r(json_encode(array('fail' => $lang->get('NULL_COURSE')), JSON_UNESCAPED_UNICODE));
        if (!in_array($_POST["course"], $this->course_list))
            return print_r(json_encode(array('fail' => $lang->get('NOT_IN_COURSE')), JSON_UNESCAPED_UNICODE));

        // Валидация по полю ТЕЛЕФОН
        if ($_POST["phone"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_PHONE')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["phone"]) > 20)
            return print_r(json_encode(array('fail' => $lang->get('MAX_PHONE')), JSON_UNESCAPED_UNICODE));    
        if (!preg_match("/((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,20}/", $_POST["phone"]))
            return print_r(json_encode(array('fail' => $lang->get('FORMAT_PHONE')), JSON_UNESCAPED_UNICODE));

        // Валидация по полю КОНТАКТЫ
        if ($_POST["social_network"] == null)
            return print_r(json_encode(array('fail' => $lang->get('NULL_CONTACTS')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST["social_network"]) > 120)
            return print_r(json_encode(array('fail' => $lang->get('MAX_CONTACTS')), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю booking_start
        if ($_POST['booking_start'] == null)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWN_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_start']) > 5)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[12]\d:00/", $_POST['booking_start']))
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));
        
        // Валидация по полю booking_end
        if ($_POST['booking_end'] == null)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWN_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_end']) > 5)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[12]\d:00/", $_POST['booking_end']))
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));

        // Валидация по полю booking_date
        if ($_POST['booking_date'] == null)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (iconv_strlen($_POST['booking_date']) > 10)
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));
        if (!preg_match("/[0123]\d.[01]\d.\d\d\d\d/", $_POST['booking_date']))
            return print_r(json_encode(array('fail' => $lang->get('UNKNOWNS_APPLICATION')), JSON_UNESCAPED_UNICODE));

        // Валидация корректной брони
        $booking_time_start = date("H:i", strtotime($_POST['booking_start']));
        $booking_time_end = date("H:i", strtotime($_POST['booking_end']));
        if (date("H:i", strtotime($_POST['booking_start'])) > date("H:i", strtotime($_POST['booking_end'])))
            return print_r(json_encode(array('fail' => $lang->get('NOT_POSSIBLE_BOOKING').' '. $lang->get('FROM').' '.$_POST['booking_start'].' '.$lang->get('TO').' '.$_POST['booking_start']), JSON_UNESCAPED_UNICODE));

        // Валидация возможности брони
        $booking_start = date("Y-m-d H:i", strtotime($_POST['booking_date'] . $_POST['booking_start']));
        $today_time = date("Y-m-d H:i", time());
        if ($booking_start <= $today_time)
            return print_r(json_encode(array('fail' => $lang->get('NOT_POSSIBLE_BOOKING_TIME')), JSON_UNESCAPED_UNICODE));

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
                return print_r(json_encode(array('fail' => $lang->get('EXIST_BOOKING')), JSON_UNESCAPED_UNICODE));
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
            
        return print_r(json_encode(array('success' => $lang->get('ACCEPT_BOOKING')), JSON_UNESCAPED_UNICODE));
    }

    public function loadCalendarToRoom() {
        $dates = Application::loadBooking($this->route_params["id"]);
        return print_r(json_encode($dates));
    }

    public function getLanguage() {
        return json_encode(Languages::getLanguage());
    }
}
