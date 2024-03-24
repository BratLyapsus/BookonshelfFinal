<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';
$bookname = $_SESSION['bookName'];
deleteBook($bookname);
$_SESSION['Notification'] = 'Книга удалена!!';
header("Location: ../html/index.php?page=admin-books");