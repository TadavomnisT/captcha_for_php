<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT SHOWS A MENU TO OF OPTIONS

require_once("includes/check_session.php");

// log out
if( isset($_POST["quit"]) )
redirect("sign_out.php");

// redirects to settings.php
if( isset($_POST["settings"]) )
redirect("settings.php");

// redirects to database.php
if( isset($_POST["database"]) )
redirect("database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل دسترسی ادمین</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">

</head>
<body>
    <form class="Box" action="" method="post">
        <h1>
        پنل دسترسی ادمین
        </h1> 
        <input type="submit" name="database" value="مدیریت دیتابیس">
        <input type="submit" name="settings" value="نتظیمات الگوریتم">
        <input type="submit" name="quit" value="خروج از پنل">
    </form>
</body>
</html>