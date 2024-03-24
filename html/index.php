<?php
session_start();

//check if variable page is present, if not we assign to it value home
if(isset($_GET['page'])) {
$page = $_GET['page'];
} else {
$page = 'home';
}
//define which block to include depending on parameter "$page"
include'../includes/' . $page . '.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <title>Main page</title>  -->
    <title><?php echo $title?> </title>
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div id="header">Библиотека Колывань</div>

</body>

</html>