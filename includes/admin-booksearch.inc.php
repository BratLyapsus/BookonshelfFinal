<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Поиск книги';
$userrole = $_SESSION['userRole'];
pageAccessCheck('admin');
?>

<div class="book-search">

    <form action="../PHP/book_search.php" method="post" <!--id="search_fields-->">
    <ul id="search-list">

        <li><label>Автор книги</label>
        <li>
        <li><input type="text"  name="bookwriter" ></li><br>
        <li><label>Название книги</label>
        <li>
        <li><input type="text" name="bookname"></li><br>
        <li><input type="submit" id="search_button" value="Искать"  class="btn">
        <li>
    </ul>
    </form>
</div>
