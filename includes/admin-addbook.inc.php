<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Добавить книгу';
$userrole = $_SESSION['userRole'];
$username = $_SESSION['userName'];
pageAccessCheck('admin');

?>
<div id="addbook">
<form action="../PHP/add_book.php" method="post" enctype="multipart/form-data">

    <label>Название книги</label><br>
    <input type="text" id="bookname" name="bookname" required><br>
    <label>Автор</label><br>
    <input type="text" id="bookwriter" name="bookwriter" required><br>
    <label>Язык</label><br>
    <input type="text" id="booklanguage" name="booklanguage" required><br>
    <label>Жанр</label><br>
    <input type="text" name="bookgenre" required><br>
    <label>Количество страниц</label><br>
    <input type="text" pattern="[0-9]*" title="Введите пожалуйста только числа" name="pageamount" required><br>
    <label>Регистрационный номер</label><br>
    <input type="text" name="registrationnumber" required><br>
    <label>Количество книг</label><br>
    <input type="text" pattern="[0-9]*" title="Введите пожалуйста число" name="bookamount" required><br>
    <label>Аннотация</label><br>
    <textarea id="bookAnnotation" name = "bookannotation" required></textarea><br>
    <label>Фото обложки</label><br>
    <input type="file" accept="image/*" placeholder="Фото обложки"name="bookphoto" required><br>
    <input class="btn" type="submit" value="Ok">
</form>
    </div>
<?php
if (isset($_SESSION['Notification']))
{
    ?>
    <div class="notification_error">
        <?php
        echo $_SESSION['Notification'];
        unset ($_SESSION['Notification']);
        ?>
    </div>
    <?php
}