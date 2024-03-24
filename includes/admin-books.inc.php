<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Все книги';
$userrole = $_SESSION['userRole'];
pageAccessCheck('admin');

$result = getAllBooksData();
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


<ul id="book_list">
    <?php foreach ($result as $row) : ?>
        <li class="card" id="book">
            <div class="container">
                <div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($row['bookPhoto']) . '"'; ?></div>
                <div><br></div>
                <form action="../PHP/book_search.php" method="post">
                    <input type="text" name="bookname" id="form" value="<?php echo $row['bookName'] ?>"><br>
                    <input type="submit" value="Перейти к книге" id="btn-link">
                </form>
            </div>
        </li>

    <?php endforeach; ?>
</ul>

