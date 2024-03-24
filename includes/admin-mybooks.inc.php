<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Мои книги';
$userrole = $_SESSION['userRole'];
$userid = $_SESSION['user_id'];
pageAccessCheck('admin');
$resultborrowed = getBorrowedBooksData($userid);
$resultreserved = getReservedBooksData($userid);

if (isset($_SESSION['Notification']))
{
    ?>
    <div class="notification-bookhandled">
        <?php
        echo $_SESSION['Notification'];
        unset ($_SESSION['Notification']);
        ?>
    </div>
    <?php
}
?>
<br>
<h1 id="mybooks">Зарезервированные книги</h1>
<ul id="book_list">
    <?php foreach ($resultreserved as $rowreserved) : ?>
        <li class="card" id="book">
            <div class="container">
                <div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($rowreserved['bookPhoto']) . '"'; ?></div>
                <div><br></div>
            </div>
        </li>

    <?php endforeach; ?>
</ul>

<h1 id="mybooks">Взятые книги</h1>

<ul id="book_list">
    <?php foreach ($resultborrowed as $rowborrowed) : ?>
        <li class="card" id="book">
            <div class="container">
                <div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($rowborrowed['bookPhoto']) . '"'; ?></div>
                <div><br></div>
                <form action="../PHP/return_book.php" method="post">
                    <input type="text" name="bookid" id="form" value="<?php echo $rowborrowed['book_id'] ?>"><br>
                    <input type="submit" value="Вернуть книгу" id="btn-link">
                </form>
            </div>
        </li>

    <?php endforeach; ?>
</ul>
