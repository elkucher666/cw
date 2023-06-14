<?php

namespace App\Models;

class Languages extends \Core\Model
{
    private $data;

    public function __construct($language){
        $this->data = parse_ini_file("../public/languages/system_$language.ini");     
    }

    public function get($name){
        return $this->data[$name];  
    }

    public static function getLanguage(){
        preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), $matches);
        $langs=array_combine($matches[1], $matches[2]);
        foreach ($langs as $n => $v) 
            $langs[$n]=$v ? $v :1;

        arsort($langs);
        $default_lang = key($langs);
        return $default_lang;
    }

}
// echo $language = Languages::getLanguage();
?>