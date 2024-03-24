<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$bookid = $_SESSION['book_id'];
$userid = $_SESSION['user_id'];
$currentdate = date("Y-m-d");
$startdate = $currentdate;
$enddate = date("Y-m-d", strtotime($startdate . " +3 weeks")); // Add 3 weeks to the current date
//$borrowid = getBorrowId($bookid);
//$borrowid = checkBorrowIdExistanceByUser($bookid);
$borrowid = checkBorrowIdByBookIdAndUserId ($bookid, $userid);
$bookdata = getSingleBookDataById($bookid);
$bookamount = $bookdata['bookAmount'];
//if (checkBorrowIdExistanceByUser($bookid))
if (checkBorrowIdByBookIdAndUserId ($bookid, $userid))
{
    // Book already borrowed, handle notification or redirection here
    $_SESSION['Notification'] = 'Книга уже вами читается.';
    //header('Location: ../html/index.php?page=user-booksearchresult');
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
    exit; // Make sure to exit after redirecting
}

if (checkReservationIdByBookIdAndUserId ($bookid, $userid))
{
    // Book already reserved by you, handle notification or redirection here
    $_SESSION['Notification'] = 'Книга вами уже зарезервирована. Вы сможете взять эту книгу как только она вернется в библиотеку';
    //header('Location: ../html/index.php?page=user-booksearchresult');
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
    exit; // Make sure to exit after redirecting
}
if ($bookamount > 0)
{
    $bookamount = $bookamount - 1;
    editBookAmount($bookid, $bookamount);
    $borrowid = addBookToBorrow($bookid, $userid, $startdate, $enddate);
    $historyid = addBookToHistory($borrowid, $bookid, $userid, $startdate, $enddate);
    $_SESSION['Notification'] = 'Книга готова. Вы можете ее забрать в библиотеке.';
    //header('Location: ../html/index.php?page=user-booksearchresult');
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
} else
{
    $_SESSION['Notification'] = 'Книга в данный момент занята. Вы можете ее зарезезервировать.';
    //header('Location: ../html/index.php?page=user-booksearchresult');
    header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-booksearchresult');
    exit; // Make sure to exit after redirecting
}
