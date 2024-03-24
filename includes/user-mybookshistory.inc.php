<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
include '../includes/navbar-personal.inc.php';

$title = 'Моя история';
$userrole = $_SESSION['userRole'];
$userid = $_SESSION['user_id'];
pageAccessCheck('user');
//$resultborrowed = getBorrowedBooksData($userid);
$resulthistory = getHistoryBooksData($userid);
?>


<ul id="book_list">
    <?php foreach ($resulthistory as $rowhistory) : ?>
        <li class="card" id="book">
            <div class="container">
                <div>Start: <?php echo $rowhistory['borrowedStartDate']; ?> End: <?php echo $rowhistory['borrowedEndDate']; ?></div>
                <br><div class="bookphoto"><?php echo '<image src="data:image/png;base64,' . base64_encode($rowhistory['bookPhoto']) . '"'; ?>
                </div>

            </div>
        </li>

    <?php endforeach; ?>
</ul>