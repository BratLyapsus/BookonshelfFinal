<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$userrole = $_SESSION['userRole'];
pageAccessCheck('user');
$bookname = $_POST['bookname'];

$result = getSingleBookData($bookname);
$title = $result['bookName'];
?>

<ul id="book_list">
    <li class="card" id="book">
        <div class="container">
            <div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($result['bookPhoto']) . '"'; ?></div>
        </div>
    </li>
    <li class="card" id="book">
        <div class="container">
            <div class="bookdata">Название книги: <?php echo $result['bookName'] ?><br></div><br>
            <div class="bookdata">Автор: <?php echo $result['bookWriter'] ?></div><br>
            <div class="bookdata">Жанр: <?php echo $result['bookGenre'] ?></div><br>
            <div class="bookdata">Кол-во страниц: <?php echo $result['pageAmount'] ?></div><br>
            <div class="bookdata">Язык: <?php echo $result['bookLanguage'] ?></div><br>
            <div class="bookdata">Кол-во книг: <?php echo $result['bookAmount'] ?></div><br>
            <div class="bookdata">Рег. номер: <?php echo $result['registrationNumber'] ?></div>
        </div>
    </li>
    <li class="card-annotation" id="book">
        <div class="container">
            <div class="bookannotation">Аннотация: <?php echo $result['bookAnnotation'] ?></div>
        </div>
    </li>

</ul>
