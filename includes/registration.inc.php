<?php
include '../../Private/connection-pdo.php';
include '../functions/functions.php';

$title = 'Регистрация пользователя';


?>
    <div class="navbar">

        <a href="index.php?page=home">Главная</a>
        <a href="index.php?page=login">Вход</a>
        <a href="index.php?page=information">Информация</a>
    </div>

    <div id="addbook">
        <form action="../PHP/user_registration.php" method="post" enctype="multipart/form-data">

            <label>Имя</label><br>
            <input type="text" id="firstname" name="firstname" required><br>
            <label>Фамилия</label><br>
            <input type="text" id="lastname" name="lastname" required><br>
            <label>Ник</label><br>
            <input type="text" id="username" name="username" required><br>
            <label>Права доступа</label><br>
            <input type="text" id="userrole" name="userrole" required><br>
            <label>Пароль</label><br>
            <input type="password" name="password" required><br>
            <label>Электронная почта</label><br>
            <input type="email" name="email" required><br>

            <label>Город</label><br>
            <input type="text" name="city" required><br>
            <label>Улица</label><br>
            <input type="text" name="street" required><br>
            <label>Номер дома</label><br>
            <input type="text" name="housenumber" required><br>
            <label>Почтовый индекс</label><br>
            <input type="text" name = "postalcode" required></input><br>
            <label>Фото пользователя</label><br>
            <input type="file" accept="image/*" placeholder="Фото пользователя" name="userphoto" required><br>
            <input class="btn" type="submit" value="Ok">
        </form>
    </div>
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