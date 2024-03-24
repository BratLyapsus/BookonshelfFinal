<?php
session_destroy();
include '../../Private/connection-pdo.php';
$title = 'Вход';
include '../includes/navbar.inc.php';
?>

<div class="login">
    <form action="../PHP/login.php" method="post">
        <label>User name</label><br>
        <input type="text" name="user_name"class="logininput"><br><br>
        <label>Password</label><br>
        <input type="password" name="password"class="logininput"><br><br>
        <input type="submit" value="Вход" class="btn"><br><br>

        <?php
        if (isset($_SESSION['Notification']))
        {
        ?>
           <div class="notification_error">
               <?php
                    echo $_SESSION['Notification'];
                    unset ($_SESSION['Notification']);
                    ?>
           </div>
        <?php
        }
        ?>
    </form>
</div>
