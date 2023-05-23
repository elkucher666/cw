<?php

//Сделано

//Обновление информации о продукте

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once '../config/connect.php';

/*
 * Создаем переменные со значениями, которые были получены с $_POST
 */
 $id = $_POST['id'];
 $fio = $_POST['fio'];
 $age = $_POST['age'];
 $institute = $_POST['institute'];
 $course = $_POST['course'];
 $phone = $_POST['phone'];
 $social_network = $_POST['social_network'];
 $id_room = $_POST['id_room'];

/*
 * Делаем запрос на изменение строки в таблице products
 */

mysqli_query($connect, "UPDATE `application` SET `fio` = '$fio', `age` = '$age', `institute` = '$institute', `phone` = '$phone', `social_network` = '$social_network', `id_room` = '$id_room' WHERE `id` = '$id'");

/*
 * Переадресация на главную страницу
 */

//header('Location: /ppcp/index.php');