<?php
session_start();
include '../../Private/connection-pdo.php';

?>
<div class="navbar">
    <a href="index.php?page=user-books">Все книги</a>
    <a href="../PHP/oder_book.php">Заказать</a>
    <a href="../PHP/reserve_book.php">Зарезервировать</a>
    <a href="index.php?page=user-mybooks">Мои книги</a>
    <a href="index.php?page=user-mybookshistory">Моя история</a>
    <a href="index.php?page=user-booksearch" id="logout">Назад к поиску</a>
</div>

