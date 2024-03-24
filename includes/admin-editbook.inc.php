<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-admin-booksoptions.inc.php';

$title = 'Редактировать книгу';
$userrole = $_SESSION['userRole'];
$username = $_SESSION['userName'];
pageAccessCheck('admin');

?>
    <div id="addbook">
        <form action="../PHP/edit_book.php" method="post" enctype="multipart/form-data">
            <label>book_id</label><br>
            <input type="text" id="bookid" name="bookid" value="<?php echo htmlspecialchars($_SESSION['book_id']); ?>" required><br>
            <label>Название книги</label><br>
            <input type="text" id="bookname" name="bookname" value="<?php echo htmlspecialchars($_SESSION['bookName']); ?>" required><br>
            <label>Автор</label><br>
            <input type="text" id="bookwriter" name="bookwriter" value="<?php echo htmlspecialchars($_SESSION['bookWriter']); ?>" required><br>
            <label>Язык</label><br>
            <input type="text" id="booklanguage" name="booklanguage" value="<?php echo htmlspecialchars($_SESSION['bookLanguage']); ?>" required><br>
            <label>Жанр</label><br>
            <input type="text" name="bookgenre" value="<?php echo htmlspecialchars($_SESSION['bookGenre']); ?>" required><br>
            <label>Количество страниц</label><br>
            <input type="text" pattern="[0-9]*" title="Введите пожалуйста только числа" name="pageamount" value="<?php echo htmlspecialchars($_SESSION['pageAmount']); ?>" required><br>
            <label>Регистрационный номер</label><br>
            <input type="text" name="registrationnumber" value="<?php echo htmlspecialchars($_SESSION['registrationNumber']); ?>" required><br>
            <label>Количество книг</label><br>
            <input type="text" pattern="[0-9]*" title="Введите пожалуйста число" name="bookamount" value="<?php echo htmlspecialchars($_SESSION['bookAmount']); ?>" required><br>
            <label>Аннотация</label><br>
            <input class="bookannotation" name = "bookannotation" value="<?php echo htmlspecialchars($_SESSION['bookAnnotation']); ?>" required><br>
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
