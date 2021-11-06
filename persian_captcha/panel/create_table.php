<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT IMPLEMENTS "CREATING TABLE"'s GRAFFICAL USER INTERFACE

require_once("includes/check_session.php");
require_once "includes/strToArray.php";
require_once "admin_database_handler.php";

$html="
<form class='Box' action='' method='post'>
    <h1>
        ساخت جدول جدید
    </h1> 
    <input type='submit' name='create' value='برای ایجاد یک جدول جدید کلیک کنید'>
    <input type='submit' name='return' value='بازگشت'>
</form>
";

// return to previous url
if( isset($_POST["return"]) )
redirect("database.php");

// creating table
if( isset($_POST["create"]) )
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT `table_list` FROM `setting` ;" 
    );
    $table_array = json_decode($result["0"]["table_list"] , true);
    $index = (int) count($table_array) + 1;
    $new_table_name = "words" . $index;
    $result = $admin_db->query(
        "CREATE TABLE `". $new_table_name ."` (
        `id` int(11) NOT NULL,
        `word` varchar(10) COLLATE utf8_persian_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
        " 
    );
    $table_array[$new_table_name] = 0;
    $result = $admin_db->query(
        "UPDATE `setting` SET `table_list` = '".json_encode($table_array)."' ;" 
    );
    $html = "
    <div class='Box'>
    
    <div style='color:white;'>
    .جدول با موفقیت ساخته شد
    
    </div>
    <form action='edit_table.php' method='post'>
    <input type='hidden' name='table_name' value='". $new_table_name ."'>
    <input type='submit' name='add' value='اضافه کردن کلمه بصورت دستی'>
    </form>
    <form action='' method='post'>
    <input type='hidden' name='table_name' value='". $new_table_name ."'>
    <input type='submit' name='file' value='اضافه کردن کلمه از فایل'>
    <input type='submit' name='return' value='بازگشت'>
    </form>
    </div>
    ";
}

// uploading file
if( isset($_POST["file"]) && isset($_POST["table_name"]) )
{
    $html = "
    <div class='Panel'>
    
    
    <form action='' method='post' enctype='multipart/form-data'>
    <div style='color:white;'>
    <span style='color:yellow;'>
    *فایل خود را آپلود نمائید*
    </span>
    <br>
    .<b>نکته</b> : دقت فرمائید که کلمات در فایل میبایستی با کاما (,) از هم جدا شده باشند و هیچ گونه فاصله ای مانند بریک‌لاین یا اسپیس بین آنها نباشد
    <br>
    .<b>نکته</b> : دقت فرمائید که طول کلمات باید بین 2 تا 7 حرف باشد ، در غیر اینصورت کلمه در دیتابیس درج نخواهد شد
    </div>
    <input type='hidden' name='table_name' value=". $_POST["table_name"]." />
    <input type='file' name='fileToUpload' id='fileToUpload'>
    <input type='submit' name='upload' value='آپلود'>
    <input type='submit' name='return' value='بازگشت'>
    </form>
    </div>
    ";
}

// importing file data to database
if( isset($_POST["upload"]) && isset($_POST["table_name"]) )
{
    if ( $_FILES["fileToUpload"]["tmp_name"] != "" ) {
        $admin_db = new Database(
            $_SESSION["username"],
            $_SESSION['password']
        );
        foreach (explode("," , file_get_contents($_FILES["fileToUpload"]["tmp_name"])) as $key => $word) {
            if(
                count(strToArray($word)) > 1 &&  
                count(strToArray($word)) < 8 
            )
            $result = $admin_db->query(
                "INSERT INTO `".$_POST["table_name"]."` (`id`, `word`) VALUES ('".($key + 1)."', '".$word."')  ;" 
            );
        }
        $html = "
        <div class='Panel'>
        <div style='color:white;'>
        .کلمات با موفقیت درون جدول ایمپورت شدند
        </div>
        <form action='database.php'>
        <input type='submit' name='return' value='بازگشت'>
        </form>
        </div>
        ";
    }
    else {
        $html = "
        <div class='Panel'>
        <div style='color:white;'>
        .خطا! شما هیچ فایلی انتخاب نکرده اید
        </div>
        <form action=''  method='post'>
        <input type='hidden' name='file' value='اضافه کردن کلمه از فایل'>
        <input type='hidden' name='table_name' value=". $_POST["table_name"]." />
        <input type='submit' name='quit' value='بازگشت'>
        </form>
        </div>
        ";
    }
    
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ساخت جدول جدید</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php echo $html; ?>
</body>
</html>