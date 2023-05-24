<?php

//Добавление нового продукта


/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once '../config/connect.php';

/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */

$fio = $_POST['fio'];
$age = $_POST['age'];
$institute = $_POST['institute'];
$course = $_POST['course'];
$phone = $_POST['phone'];
$social_network = $_POST['social_network'];
$id_room = '1';


$booking="20:00:00"; //время начала брони
$booking_end= date("H:i:s", strtotime("+1 hour", strtotime($booking))); // время конца брони
$booking_date = date("y-m-d"); //дата брони
$application_date = date("y-m-d H:i:s"); //сейчас
           

/*
 * Делаем запрос на добавление новой строки в таблицу
 */

mysqli_query($connect,"INSERT INTO `application` (`id`, `fio`, `age`, `institute`, `course`, `phone`, `social_network`, `id_room`) VALUES (NULL, '$fio', '$age', '$institute', '$course', '$phone', '$social_network', '$id_room')");


mysqli_query($connect,"INSERT INTO `booking` (`id`, `booking`, `booking_end`, `id_room`, `booking_date`, `application_date`) VALUES (NULL, '$booking', '$booking_end', '$id_room', '$booking_date', '$application_date')");

/*  
 * Переадресация на главную страницу
 */

header('Location: /ppcp/index.php');