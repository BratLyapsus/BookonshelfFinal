<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$bookid = $_POST['bookid'];
$userid = $_SESSION['user_id'];
$bookdata = getSingleBookDataById($bookid);
$bookamount = $bookdata['bookAmount'];

$currentdate = date("Y-m-d");
$startdate = date("Y-m-d");
$enddate = date("Y-m-d", strtotime($startdate . " +3 weeks")); // Add 3 weeks to the current date
$borrowid = getBorrowId($bookid, $userid);
echo $borrowid;
returnBook($bookid, $userid);
editEndDateHistory($borrowid, $currentdate);
$bookamount = $bookamount +1;
editBookAmount($bookid, $bookamount);

if(checkReservationIdByBookId ($bookid))
{
    $reservedata = checkReservationIdByBookId ($bookid);
    $newuserid = $reservedata['user_id'];
    clearReservationByBookIdUserId($bookid, $newuserid);
    $borrowid = addBookToBorrow($bookid, $newuserid, $startdate, $enddate);
    $historyid = addBookToHistory($borrowid, $bookid, $newuserid, $startdate, $enddate);
}
$_SESSION['Notification'] = 'Книга возвращена!!';
header("Location: ../html/index.php?page=user-mybooks");
header('Location: ../html/index.php?page=' . $_SESSION['userRole'] . '-mybooks');
echo $newuserid;