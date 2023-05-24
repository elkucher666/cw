<?php

    /*
     * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
     */

    require_once 'config/connect.php';

    /*
     * Получаем ID продукта из адресной строки - /product.php?id=1
     */

    $id = $_GET['id'];
    /*
     * Делаем выборку строки с полученным ID выше
     */

    $application = mysqli_query($connect, "SELECT * FROM `application` WHERE `id` = '$id'");

    /*
     * Преобразовывем полученные данные в нормальный массив
     * Используя функцию mysqli_fetch_assoc массив будет иметь ключи равные названиям столбцов в таблице
     */

    $application = mysqli_fetch_assoc($application);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
</head>
<body>
    <h3>Update</h3>
    <form action="vendor/update.php" method="post">
    <input type="hidden" name="id" value="<?= $application['id'] ?>">
        
        <p>FIO</p>
        <input type="text" name="fio" value="<?= $application['fio'] ?>">
        
        <p>age</p>
        <input type="text" name="age" value="<?= $application['age'] ?>">
        
        <p>institute</p>
        <input type="text" name="institute" value="<?= $application['institute'] ?>">
        
        <p>course</p>
        <input type="text" name="course" value="<?= $application['course'] ?>">
        
        <p>post</p>
        <input type="text" name="phone" value="<?= $application['phone'] ?>">
       
        <p>social_network</p>
        <input type="text" name="social_network" value="<?= $application['social_network'] ?>">
       
        <p>id_room</p>
        <input type="text" name="id_room" value="<?= $application['id_room'] ?>">
        <br><br><br><br> 
        <button type="submit">Update</button>
    </form>
</body>
</html>