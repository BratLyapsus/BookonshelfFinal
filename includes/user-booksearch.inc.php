<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Поиск книги';
$userrole = $_SESSION['userRole'];
pageAccessCheck('user');
?>

<div class="book-search">

    <!--<form action="../html/index.php?page=test" method="post">-->
    <form action="../PHP/book_search.php" method="post" ">
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

    <?php
    if (isset($_SESSION['Notification']))
    {
        ?>
        <div class="notification-booksearch">
            <?php
            echo $_SESSION['Notification'];
            unset ($_SESSION['Notification']);
            ?>
        </div>
        <?php
    }
    ?>

    </form>
</div>
