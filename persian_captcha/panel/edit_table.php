<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT HANDLES EDITING TABLE ALONG SIDE WITH GUI

require_once("includes/check_session.php");
require_once "includes/strToArray.php";
require_once "admin_database_handler.php";

$html = "";

// shows the table
if(isset($_POST["table_name"]))
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT * FROM `".$_POST["table_name"]."` ;" 
    );
    $html .= "
        <div class='Panel'>
        <table style='width:100%'>
        <thead>
        <tr>
            <th>شناسه</th>
            <th>کلمه</th>
            <th>ویرایش</th>
        </tr>
        </thead>
        ";
    if (!is_null($result))
    foreach ($result as $row){
        $html .= "
        <tr>
        <td>".$row["id"]."</td>
        <td>".$row["word"]."</td>
        <td><a href='edit_table.php?table=".$_POST["table_name"]. "&id=" .$row["id"]."'>.برای ویرایش یا حذف این سطر اینجا کلیک نمایید</a></td>
        </tr>
        ";
    }  
    $html .= "
    <tr>
    <td colspan='3'><a href='edit_table.php?table=".$_POST["table_name"]. "&add=1'>.برای اضافه کردن یک سطر اینجا کلیک نمایید</a></td>
    </tr>
    </table>
    <form action='edit_table.php' >
    <input type='submit' value='بازگشت' />
    </form>
    </div>
    ";       
}
// deletes word
elseif (isset($_POST["final_delete"])) {
    if(
        isset($_POST["final_table_name"]) &&
        isset($_POST["final_id"]) &&
        isset($_POST["final_word"]) 
    )
    {
        $admin_db = new Database(
            $_SESSION["username"],
            $_SESSION['password']
        );
        $result = $admin_db->multi_query(
            "DELETE FROM `".$_POST["final_table_name"]."` WHERE id=".$_POST["final_id"]." ;
            SET @count = 0;
            UPDATE `".$_POST["final_table_name"]."` SET `id` = @count:= @count + 1;" 
        );
        $result = $admin_db->query(
            "SELECT `table_list` FROM `setting` ;" 
        );
        $table_array = json_decode($result["0"]["table_list"] , true);
        $table_array[$_POST["final_table_name"]] = (int) $table_array[$_POST["final_table_name"]] - 1 ;
        $result = $admin_db->query(
            "UPDATE `setting` SET `table_list` = '".json_encode($table_array)."' ;" 
        );
        $html = "
        <div class='Panel'>
        <div style='color:white;'>
        !کلمه با موفقیت حذف شد
        </div>
        <form action='edit_table.php' method='post' >
        <input type='hidden' name='table_name' value=". $_GET["table"]." />
        <input type='submit' value='بازگشت' />
        </div>
        ";
    }
}
// edit word
elseif (isset($_POST["final_edit"])) {
    if(
        isset($_POST["final_table_name"]) &&
        isset($_POST["final_id"]) &&
        isset($_POST["final_word"]) &&
        count(strToArray($_POST["final_word"])) > 1 &&  
        count(strToArray($_POST["final_word"])) < 8 
    )
    {
        $admin_db = new Database(
            $_SESSION["username"],
            $_SESSION['password']
        );
        $result = $admin_db->query(
            "UPDATE `".$_POST["final_table_name"]."` SET `word` = '".$_POST["final_word"]."' WHERE id=".$_POST["final_id"]." ;" 
        );
        $html = "
        <div class='Panel'>
        <div style='color:white;'>
        !کلمه با موفقیت ویرایش شد
        </div>
        <form action='edit_table.php' method='post' >
        <input type='hidden' name='table_name' value=". $_GET["table"]." />
        <input type='submit' value='بازگشت' />
        </div>
        ";
    }
}
// add word
elseif (isset($_POST["final_add"])) {
    if(
        isset($_POST["final_table_name"]) &&
        isset($_POST["final_id"]) &&
        isset($_POST["final_word"]) &&
        count(strToArray($_POST["final_word"])) > 1 &&  
        count(strToArray($_POST["final_word"])) < 8 
    )
    {
        $admin_db = new Database(
            $_SESSION["username"],
            $_SESSION['password']
        );
        $result = $admin_db->query(
            "INSERT INTO `".$_POST["final_table_name"]."` (`id`, `word`) VALUES ('".$_POST["final_id"]."', '".$_POST["final_word"]."')  ;" 
        );
        $result = $admin_db->query(
            "SELECT `table_list` FROM `setting` ;" 
        );
        $table_array = json_decode($result["0"]["table_list"] , true);
        $table_array[$_POST["final_table_name"]] = (int) $table_array[$_POST["final_table_name"]] +1 ;
        $result = $admin_db->query(
            "UPDATE `setting` SET `table_list` = '".json_encode($table_array)."' ;" 
        );
        $html = "
        <div class='Panel'>
        <div style='color:white;'>
        !کلمه با موفقیت اضافه شد
        </div>
        <form action='edit_table.php' method='post' >
        <input type='hidden' name='table_name' value=". $_GET["table"]." />
        <input type='submit' value='بازگشت' />
        </div>
        ";
    }
}
// provide add panel
elseif ( !isset($_GET["table"]) && !isset($_GET["id"]) && !isset($_GET["add"]) )
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $html .=
    "
    <div class='Panel'>
    ";
    $tables = $admin_db->query(
        "SELECT `table_list` FROM `setting` ;" 
    );
    foreach (json_decode($tables["0"]["table_list"] , true) as $table => $max)
    {
        $result = $admin_db->query(
            "SELECT * FROM `".$table."` WHERE `id` < 5 ;" 
        );
        $html .= "
        <form action=''  method='post'>
        <input type='hidden' name='table_name' value=". $table ." />
            <table style='width:100%'>
            <thead>
            <tr>
                <th>شناسه</th>
                <th>کلمه</th>
            </tr>
            </thead>
            ";
        foreach ($result as $row){
            $html .= "
            <tr>
            <td>".$row["id"]."</td>
            <td>".$row["word"]."</td>
            </tr>
            ";
        }  
        $html .= "
        <tr>
            <td>...</td>
            <td>...</td>
            </tr>
        </table>
        <input type='submit' name='double_check' value='".$table." ویرایش جدول' />
        </form>
        ";
    }

    $html .= "
    <form action='database.php' >
    <input type='submit' value='بازگشت' />
    </form>
    </div>
    ";    
}
// provide edit panel
elseif ( isset($_GET["table"]) && isset($_GET["id"]) )
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT * FROM `" . $_GET["table"] . "` WHERE id = " . $_GET["id"] . " ;" 
    );
    $html .= "
    <div class='Panel'>
        <form action=''  method='post'>
        <input type='hidden' name='final_table_name' value=". $_GET["table"]." />
        <input type='hidden' name='final_id' value=". $_GET["id"] ." />
            <table style='width:100%'>
            <thead>
            <tr>
                <th>شناسه</th>
                <th>کلمه</th>
            </tr>
            </thead>
            ";
        foreach ($result as $row){
            $html .= "
            <tr>
            <td><input disabled='disabled' type='text' name='final_id' value=". $row["id"]." /></td>
            <td><input minlength='2' maxlength='7' type='text' name='final_word' value=". $row["word"]." required /></td>
            </tr>
            ";
        }  
        $html .= "
        </table>
        <div style='color:white;'>
        .دقت فرمائید که طول کلمات باید بین 2 تا 7 حرف باشد
        </div>
        <input type='submit' name='final_delete' value='حذف' />
        <input type='submit' name='final_edit' value='ویرایش' />
        </form>
        <form action='edit_table.php' method='post' >
        <input type='hidden' name='table_name' value=". $_GET["table"]." />
        <input type='submit' value='بازگشت' />
        </form>
    </div>    
        ";
}
// provide add panel
elseif ( isset($_GET["table"]) && isset($_GET["add"]) )
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT MAX(id) FROM `".$_GET["table"]."`;" 
    );
    $id = (int)$result["0"]["MAX(id)"] + 1;
    $html .= "
    <div class='Panel'>
    <form action=''  method='post'>
    <input type='hidden' name='final_table_name' value=". $_GET["table"] ." />
    <input type='hidden' name='final_id' value=". $id." />
        <table style='width:100%'>
        <thead>
        <tr>
            <th>شناسه</th>
            <th>کلمه</th>
        </tr>
        </thead>
        <tr>
        <td><input disabled='disabled' type='text' name='temp_id' value=". $id." /></td>
        <td><input input minlength='2' maxlength='7' type='text' name='final_word' required /></td>
        </tr>
        <tr>
        </tr>
        </table>
        <div style='color:white;'>
        .دقت فرمائید که طول کلمات باید بین 2 تا 7 حرف باشد
        </div>
        <input type='submit' name='final_add' value='اضافه کردن کلمه' />
        </form>
        <form action='edit_table.php' method='post' >
        <input type='hidden' name='table_name' value=". $_GET["table"]." />
        <input type='submit' value='بازگشت' />
        </div>
        ";    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش جداول</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php echo $html; ?>
</body>
</html>