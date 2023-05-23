<?php require_once '../config/connect.php';?>

//Добавление комментария

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

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

<?php
$bookings = mysqli_fetch_all($bookings);

foreach ($bookings as $booking) {
    ?>
        <tr>
            <td><?= $booking[0] ?></td>
            <td><?= $booking[1] ?></td>
            <td><?= $booking[2] ?></td>
            <td><?= $booking[3] ?></td>
            <td><?= $booking[4] ?></td>
            <td><?= $booking[5] ?></td>
            <td><?= $booking[6] ?></td>
            <td><?= $booking[7] ?></td>
            <td><a href="product.php?id=<?= $booking[0] ?>">View</a></td>
            <td><a href="update.php?id=<?= $booking[0] ?>">Update</a></td>
            <td><a style="color: red;" href="vendor/delete.php?id=<?= $booking[0] ?>">Delete</a></td>
        </tr>
    <?php
}
?>
