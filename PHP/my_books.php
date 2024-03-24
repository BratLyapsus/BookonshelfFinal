<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
$userid = $_SESSION['user_id'];
$result = getBorrowedBooksData($userid);
foreach ($result as $raw)
{
    echo $raw['bookName'];
}