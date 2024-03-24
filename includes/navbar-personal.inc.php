<?php
include '../../Private/connection-pdo.php';
$userRole = $_SESSION['userRole'];
if ($userRole == 'user')
{
?>
<div class="navbar">
    <a href="index.php?page=user">Личное</a>
    <a href="index.php?page=user-books">Все книги</a>
    <a href="index.php?page=user-booksearch">Поиск книги</a>
    <!--<a href="../PHP/my_books.php">Мои книги</a>-->
    <a href="index.php?page=user-mybooks">Мои книги</a>
    <a href="index.php?page=user-mybookshistory">Моя история</a>
    <a href="../PHP/logout.php" id="logout">Выход</a>
</div>
<?php }?>
<?php
if ($userRole == 'admin')
{
    ?>
    <div class="navbar">
        <a href="index.php?page=admin">Личное</a>
        <a href="index.php?page=admin-books">Все книги</a>
        <a href="index.php?page=admin-booksearch">Поиск книги</a>
        <a href="index.php?page=admin-mybooks">Мои книги</a>
        <a href="index.php?page=admin-addbook">Добавить книгу</a>
        <a href="../PHP/logout.php" id="logout">Выход</a>
    </div>
<?php }?>



