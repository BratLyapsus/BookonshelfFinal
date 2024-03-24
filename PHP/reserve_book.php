<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$bookid = $_SESSION['book_id'];
$userid = $_SESSION['user_id'];
$startdate = date("Y-m-d");
$enddate = date("Y-m-d", strtotime($startdate . " +3 weeks")); // Add 3 weeks to the current date
$bookdata = getSingleBookDataById($bookid);
$bookamount = $bookdata['bookAmount'];

if(checkBorrowIdByBookIdAndUserId ($bookid, $userid))
{
    // Book already reserved by you, handle notification or redirection here
    $_SESSION['Notification'] = 'У вас уже есть эта книга.';
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
    exit; // Make sure to exit after redirecting
}
if (checkReservationIdByBookIdAndUserId ($bookid, $userid))
{
    // Book already reserved by you, handle notification or redirection here
    $_SESSION['Notification'] = 'Книга вами уже зарезервирована.';
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
    exit; // Make sure to exit after redirecting
}
if ($bookamount > 0)
{
    $bookamount = $bookamount - 1;
    editBookAmount($bookid, $bookamount);
    $borrowid = addBookToBorrow($bookid, $userid, $startdate, $enddate);
    $historyid = addBookToHistory($bookid, $userid, $startdate, $enddate);
    $_SESSION['Notification'] = 'Книга готова. Вы можете ее забрать в библиотеке. Резервирование не нужно.';
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
}

else
{
    $reserveid = addBookToReserve($bookid, $userid, $startdate, $enddate);
    $_SESSION['Notification'] = 'Книга зарезервирована. Вы сможете ее забрать, как только она вернется в библиотеку.';
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
}




