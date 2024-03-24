<?php
session_start();
include '../../Private/connection-pdo.php';

$username = $_POST['user_name'];
$password = $_POST['password'];

$sql = "SELECT u.user_id, u.userName, u.userPassword, r.userRole FROM users u 
    LEFT JOIN roles r ON u.userRole_id = r.userRole_id 
    WHERE u.userName = :username AND u.userPassword = :password";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":username", $username);
$stmt->bindParam(":password", $password);
$stmt->execute();
if ($result=$stmt->fetch()) {
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['firstName'] = $result['firstName'];
    $_SESSION['lastName'] = $result['lastName'];
    $_SESSION['userName'] = $result['userName'];
    $_SESSION['userRole'] = $result['userRole'];
    header('Location: ../html/index.php?page=' . $_SESSION['userRole']);
        if($result['userRole'] == 'admin')
        {
            $_SESSION['userRole'] = 'admin';
            header('Location: ../html/index.php?page=admin');
        }
        elseif($result['userRole'] == 'user')
        {
            $_SESSION['userRole'] = 'user';
            header('Location: ../html/index.php?page=user');
        }
    }else
    {
        $_SESSION['Notification'] = 'Unknown user name and/or password';
        header('Location: ../html/index.php?page=login');
    }
?>