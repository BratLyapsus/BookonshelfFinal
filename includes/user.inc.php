<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Пользователь: ' . $_SESSION['userName'];
$userrole = $_SESSION['userRole'];
$username = $_SESSION['userName'];

pageAccessCheck('user');
$result = getUserData($username);
?>
<ul id="book_list">
    <li class="card-user" id="book">
        <div class="container">
            <div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($result['userPhoto']) . '"'; ?></div>
        </div>
    </li>
    <li class="card" id="book">
        <div class="container">
            <div class="bookdata">Имя: <?php echo $result['firstName'] ?></div>
            <div class="bookdata">Фамилия: <?php echo $result['lastName'] ?></div>
            <div class="bookdata">Ник: <?php echo $result['userName'] ?></div><br>
            <div class="bookdata">Роль: <?php echo $result['userRole'] ?></div><br>
            <div class="bookdata">Имэйл: <?php echo $result['userEmail'] ?></div><br>
            <div class="bookdata">Город: <?php echo $result['city'] ?></div>
            <div class="bookdata">Улица: <?php echo $result['streetName'] ?></div>
            <div class="bookdata">Дом: <?php echo $result['houseNumber'] ?></div>
        </div>
    </li>


</ul>

