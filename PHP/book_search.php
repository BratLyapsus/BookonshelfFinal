<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

if($_POST['bookname'] != '') {
    $bookname = $_POST['bookname'];

    $result = getSingleBookData($bookname);

    if ($result !== false) {
        // Data found, set session variables
        $_SESSION['book_id'] = $result['book_id'];
        $_SESSION['bookName'] = $result['bookName'];
        $_SESSION['bookWriter'] = $result['bookWriter'];
        $_SESSION['bookLanguage'] = $result['bookLanguage'];
        $_SESSION['bookGenre'] = $result['bookGenre'];
        $_SESSION['registrationNumber'] = $result['registrationNumber'];
        $_SESSION['pageAmount'] = $result['pageAmount'];
        $_SESSION['bookAmount'] = $result['bookAmount'];
        $_SESSION['bookPhoto'] = $_FILES['bookPhoto']['tmp_name'];
        $_SESSION['bookAnnotation'] = $result['bookAnnotation'];
        echo $result['bookGenre'];
        if($_SESSION['userRole'] == 'admin') {
            header('Location: ../html/index.php?page=admin-booksearchresult');
        }
        elseif ($_SESSION['userRole'] == 'user') {
            header('Location: ../html/index.php?page=user-booksearchresult');
        }
        exit(); // Add exit to stop script execution after redirection
    }

    else {
        $_SESSION['Notification'] = 'Книга не найдена!';
        header('Location: ../html/index.php?page=user-booksearch');

}
}

if ($_POST['bookwriter'] != '') {
    $bookwriter = $_POST['bookwriter'];

    $result = getWriterBook($bookwriter);

    if ($result !== false) {
        // Data found, set session variables
        $_SESSION['book_id'] = $result['book_id'];
        $_SESSION['bookName'] = $result['bookName'];
        $_SESSION['bookWriter'] = $result['bookWriter'];
        $_SESSION['bookGenre'] = $result['bookGenre'];
        $_SESSION['bookLanguage'] = $result['bookLanguage'];
        $_SESSION['registrationNumber'] = $result['registrationNumber'];
        $_SESSION['pageAmount'] = $result['pageAmount'];
        $_SESSION['bookAmount'] = $result['bookAmount'];
        $_SESSION['bookPhoto'] = $result['bookPhoto'];
        $_SESSION['bookAnnotation'] = $result['bookAnnotation'];
        echo $result['bookGenre'];
        if ($_SESSION['userRole'] == 'admin') {
            header('Location: ../html/index.php?page=admin-writersearchresult');
        } elseif ($_SESSION['userRole'] == 'user') {
            header('Location: ../html/index.php?page=user-writersearchresult');
        }
        exit(); // Add exit to stop script execution after redirection
    } else {
        $_SESSION['Notification'] = 'Автор не найден!';
        header('Location: ../html/index.php?page=user-booksearch');
    }
}