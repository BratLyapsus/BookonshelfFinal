<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

if($_POST['bookwriter'] != '') {
    $bookwriter = $_POST['bookwriter'];

    $result = getWriterBooks($bookwriter);

    if ($result !== false) {
        // Data found, set session variables
        $_SESSION['book_id'] = $result['book_id'];
        $_SESSION['bookName'] = $result['bookName'];
        $_SESSION['bookWriter'] = $result['bookWriter'];
        $_SESSION['bookGenre'] = $result['bookGenre'];
        $_SESSION['registrationNumber'] = $result['registrationNumber'];
        $_SESSION['pageAmount'] = $result['pageAmount'];
        $_SESSION['bookAmount'] = $result['bookAmount'];
        $_SESSION['bookPhoto'] = $result['bookPhoto'];
        $_SESSION['bookAnnotation'] = $result['bookAnnotation'];
        echo $result['bookGenre'];
        if($_SESSION['userRole'] == 'admin') {
            header('Location: ../html/index.php?page=admin-booksearchresult');
        }
        elseif ($_SESSION['userRole'] == 'user') {
            header('Location: ../html/index.php?page=user-booksearchresult');
        }
        exit(); // Add exit to stop script execution after redirection
    } else {
        // No data found, handle accordingly (e.g., display a message)
        echo "No matching records found.";

    }
}