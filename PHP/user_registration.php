<?php
session_start();
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$username = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$userrole = $_POST['userrole'];
$userpassword = $_POST['password'];
$useremail = $_POST['email'];
$city = $_POST['city'];
$postalcode = $_POST['postalcode'];
$street = $_POST['street'];
$housenumber = $_POST['housenumber'];
$roleId = getUserRoleId($userrole);
//echo $roleid;


// Check if file is uploaded and is an image
if (isset($_FILES['userphoto']) && is_uploaded_file($_FILES['userphoto']['tmp_name']) &&
    isImage($_FILES['userphoto']['tmp_name']))
{
// Read image file
    $userphoto = file_get_contents($_FILES['userphoto']['tmp_name']);
}

if (checkUserNameExistence($username) || checkEmailExistence($useremail))
{
    // user already exists, handle notification or redirection here
    $_SESSION['Notification'] = 'Пользователь с таким ником и/или имэйлом уже существует';
    header('Location: ../html/index.php?page=registration');
    exit; // Make sure to exit after redirecting
} else
{
    // user doesn't exist, proceed to add it
    $addressId = getAddressId($city, $street, $postalcode, $housenumber);
    $userId = addUser($roleId, $addressId, $firstname, $lastname, $username, $userpassword, $useremail, $userphoto);

}

$_SESSION['Notification'] = 'Поздравляем! Вы зарегестрированны!';
header('Location: ../html/index.php?page=login');
