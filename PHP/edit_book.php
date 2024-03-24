<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$bookid = $_POST['bookid'];
$bookname = $_POST['bookname'];
$bookwriter = $_POST['bookwriter'];
$booklanguage = $_POST['booklanguage'];
$bookgenre = $_POST['bookgenre'];
$pageamount = $_POST['pageamount'];
$registrationnumber = $_POST['registrationnumber'];
$bookamount = $_POST['bookamount'];
$bookannotation = $_POST['bookannotation'];

// Check if file is uploaded and is an image
if (isset($_FILES['bookphoto']) && is_uploaded_file($_FILES['bookphoto']['tmp_name']) && isImage($_FILES['bookphoto']['tmp_name']))
{
// Read image file
    $bookphoto = file_get_contents($_FILES['bookphoto']['tmp_name']);
}

if (checkBookExistence($bookname) && checkWriterExistence($bookwriter) && checkGenreExistence($bookgenre)
    && checkLanguageExistence($booklanguage) && checkRegistrationNumberExistence($registrationnumber)
    && checkAnnotationExistence($bookannotation))

{
    // Book already exists, handle notification or redirection here
    $_SESSION['Notification'] = 'Книга уже есть в библиотеке';
    header('Location: ../html/index.php?page=admin-addbook');
    exit; // Make sure to exit after redirecting
} else
{
    // Book doesn't exist, proceed to add it
    $writerId = getWriterId($bookwriter);
    //echo $writerId;
    $genreId = getGenreId($bookgenre);
    $languageId = getLanguageId($booklanguage);
    $bookId = editBook($bookid, $writerId, $genreId, $languageId, $bookname, $bookphoto, $pageamount, $bookamount, $bookannotation, $registrationnumber);
}
$_SESSION['Notification'] = 'Книга отредактирована!';
header('Location: ../html/index.php?page=admin-books');