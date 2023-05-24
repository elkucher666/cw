<?php

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once 'config/connect.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ppcp</title>
</head>
<style>
    th, td {
        padding: 10px;
    }

    th {
        background: #606060;
        color: #fff;
    }

    td {
        background: #b5b5b5;
    }
</style>
<body>
    <table>
        <tr>
            <th>id</th>
            <th>fio</th>
            <th>age</th>
            <th>institute</th>
            <th>course</th>
            <th>post</th>
            <th>SN</th>
            <th>id_room</th>
        </tr>

        <?php

            /*
             * Делаем выборку всех строк из таблицы "products"
             */
       
            
            $applications = mysqli_query($connect, "SELECT * FROM `application`");

            /*
             * Преобразовываем полученные данные в нормальный массив
             */

            $applications = mysqli_fetch_all($applications);

            $rooms=mysqli_query($connect, "SELECT * FROM `room`");
            $rooms = mysqli_fetch_all($rooms);
            
            /*
             * Перебираем массив и рендерим HTML с данными из массива
            */
            foreach ($rooms as $room) {
                ?>
                <img src=<?=$room[3]?>>
                <div><?=$room[2]?></div>
                <div id="parametroom0" class="parametroom">Площадь: 20м</div></div>
                    <th></th>
                    $room[2];
                    $room[3];
            <?php
                }
                ?>
            $room[3]?>>
            <?php
            foreach ($applications as $application) {
                ?>
                    <tr>
                        <td><?= $application[0] ?></td>
                        <td><?= $application[1] ?></td>
                        <td><?= $application[2] ?></td>
                        <td><?= $application[3] ?></td>
                        <td><?= $application[4] ?></td>
                        <td><?= $application[5] ?></td>
                        <td><?= $application[6] ?></td>
                        <td><?= $application[7] ?></td>
                        <td><a href="product.php?id=<?= $application[0] ?>">View</a></td>
                        <td><a href="update.php?id=<?= $application[0] ?>">Update</a></td>
                        <td><a style="color: red;" href="vendor/delete.php?id=<?= $application[0] ?>">Delete</a></td>
                    </tr>
                <?php
            }
        ?>
    </table>
    <h3>Add</h3>
    <form action="vendor/create.php" method="post">
        <p>FIO</p>
        <input type="text" name="fio">
        <p>age</p>
        <input type="number" name="age">
        <p>institute</p>
        <input type="text" name="institute"> <br> <br>
        <p>course</p>
        <input type="number" name="course"> <br> <br>
        <p>post</p>
        <input type="number" name="post"> <br> <br>
        <p>social_network</p>
        <input type="text" name="social_network"> <br> <br>
        <p>id_room</p>
        <input type="number" name="id_room"> <br> <br>

        <button type="submit">Add
    </form>

    
    

</body>
</html>
