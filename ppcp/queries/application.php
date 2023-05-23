<?php
require_once('./../config/connect.php');


function getPOST($key) {
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return null;
    }
}



$applications = mysqli_query($connect, "SELECT * FROM `application`");

/*
 * Преобразовываем полученные данные в нормальный массив
 */

$applications = mysqli_fetch_all($applications);



mysqli_query($connect,"INSERT INTO `application` (`fullname`, `age`, `institute`, `course`, `phone`, `social_network`, `id_room`, `booking_start`, `booking_end`, `booking_date`,`application_date`) VALUES ('getPOST('fullname')', 'getPOST('age')', 'getPOST('institute')', 'getPOST('course')', 'getPOST('phone')', 'getPOST('social_network')', 'getPOST('id_room')', 'getPOST('booking_start')', 'getPOST('booking_end')', 'getPOST('booking_date')', 'getPOST('application_date')')");



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
            <td><?= $application[8] ?></td>
            <td><?= $application[9] ?></td>
            <td><?= $application[10] ?></td>
            <td><?= $application[11] ?></td>
           
            <td><a href="product.php?id=<?= $application[0] ?>">View</a></td>
            <td><a href="update.php?id=<?= $application[0] ?>">Update</a></td>
            <td><a style="color: red;" href="vendor/delete.php?id=<?= $application[0] ?>">Delete</a></td>
        </tr>
    <?php
}
?>

?>