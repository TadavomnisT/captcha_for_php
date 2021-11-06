<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT SHOWS A MENU TO MANAGE DATABASE

require_once("includes/check_session.php");

// return to previous url
if( isset($_POST["return"]) )
redirect("menu.php");

// redirects to select_table.php
if( isset($_POST["select_table"]) )
redirect("select_table.php");

// redirects to create_table.php
if( isset($_POST["create_table"]) )
redirect("create_table.php");

// redirects to edit_table.php
if( isset($_POST["edit_table"]) )
redirect("edit_table.php");

// redirects to delete_table.php
if( isset($_POST["delete_table"]) )
redirect("delete_table.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دیتابیس</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">

</head>
<body>
    <form class="Box" action="" method="post">
        <h1>
        مدیریت دیتابیس
        </h1> 
        <input type="submit" name="select_table" value="انتخاب جدول مرجع">
        <input type="submit" name="create_table" value="ایجاد جدول کلمات جدید">
        <input type="submit" name="edit_table" value="ویرایش جداول پیشین">
        <input type="submit" name="delete_table" value="حذف جداول پیشین">
        <input type="submit" name="return" value="بازگشت">
    </form>
</body>
</html>