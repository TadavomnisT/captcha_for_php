<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT ALLOWS CHOOSING A RESOURCE TABLE USING A GUI

require_once("includes/check_session.php");
require_once "admin_database_handler.php";


$selector = "";
$message = ".جهت تغییر جدول، یکی از موارد بالا را انتخاب نمائید ، سپس ذخیره را انتخاب کنید" . "<br>" .
            ".دقت فرمائید که باید حتما روی دکمه دایره ای شکل کلید کنید تا انتخاب شما قطعی شود";

$admin_db = new Database(
    $_SESSION["username"],
    $_SESSION['password']
);

if( isset($_POST["return"]) )
redirect("database.php");

// selects table
if( isset($_POST["save"]) && isset($_POST["table"]) )
{
    $result = $admin_db->query(
        "Update `setting` SET `selected_table` = '". $_POST["table"] ."' ;"
    );
    $message = ".جدول با موفقیت انتخاب شد";
}


$result = $admin_db->query(
    "SELECT `selected_table` , `table_list` FROM `setting` ;" 
);
$table_array = json_decode($result["0"]["table_list"] , true);
$selected_table = $result["0"]["selected_table"];

$key = 0;

foreach ($table_array as $table => $max) {
    $selector .="
    <input id='table". ((int)$key + 1) ."' type='radio' name='table' value='". $table ."'  ".  ( ( $table == $selected_table ) ? "checked" : "" )  ." />
    <label class='drinkcard-cc' for='table". ((int)$key + 1) ."' ><div style='color:white;'>".$table."</div></label>
    ";
    ++$key;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انتخاب جدول</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">

</head>
<body>

    <form class='Panel' action='' method='post'>
        <h1>
        انتخاب جدول
        </h1> 

        <div class="cc-selector-2">
            <?php echo $selector; ?>
        </div>
        <div style="color:white;">
            <?php echo $message; ?>
        </div>
        <input type="submit" name="save" value="ذخیره">
        <input type="submit" name="return" value="بازگشت">
    </form>
</body>
</html>