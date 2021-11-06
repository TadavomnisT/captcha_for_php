<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT HANDLES DELETING TABLE ALONG SIDE WITH GUI

require_once("includes/check_session.php");
require_once "admin_database_handler.php";

$html = "";

// delete table check validation
if(isset($_POST["table_name"]))
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT `selected_table` FROM `setting` ;" 
    );  
    if ($result[0]["selected_table"] == $_POST["table_name"] ) {
        $html .= "
            <div class='Panel'>
            <div style='color:white;'>
            .خطا! جدول انتخاب شده در حال حاضر در حال استفاده میباشد
            <br>
            .لازم است قبل از حذف، از <a href='select_table.php'>اینجا</a> جدول دیگری را انتخاب نمائید
            <br>
            .در صورتی که جدول دیگری ندارید ، ابتدا از <a href='create_table.php'>اینجا</a> یک جدول بسازید
            </div>
            <form action='database.php' >
            <input type='submit' value='بازگشت' />
            </form>
            </div>
            ";
    }
    else {
        $result = $admin_db->query(
            "SELECT * FROM `".$_POST["table_name"]."` WHERE `id` < 5 ;" 
        );
        $html .= "
            <div class='Panel'>
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
        <div style='color:white;'>
        آیا از حذف این جدول مطئمن هستید؟
        </div>
        <form action=''  method='post'>
        <input type='hidden' name='final_delete_table' value=". $_POST["table_name"] ." />
        <input type='submit' name='double_check' value='بله' />
        </form>
        <form action='database.php' >
        <input type='submit' value='خبر - بازگشت به پنل مدیریت دیتابیس' />
        </form>
        </div>
        ";  
    }     
}
// delete table
else if ( isset($_POST["double_check"]) && isset($_POST["final_delete_table"]) )
{
    $admin_db = new Database(
        $_SESSION["username"],
        $_SESSION['password']
    );
    $result = $admin_db->query(
        "SELECT `table_list` FROM `setting` ;" 
    );
    $table_array = json_decode($result["0"]["table_list"] , true);
    unset($table_array[$_POST["final_delete_table"]]);
    $result = $admin_db->query(
        "UPDATE `setting` SET `table_list` = '". json_encode($table_array) . "' ;" 
    );
    $result = $admin_db->query(
        "DROP TABLE `" . $_POST["final_delete_table"] . "` ;"
    );
    $html = "
    <div class='Panel'>
    <div style='color:white;'>
    !جدول با موفقیت حذف شد
    </div>
    <form action='database.php' >
    <input type='submit' value='بازگشت' />
    </form>
    </div>
    ";
}
// show delete panel
else
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
        <input type='submit' name='double_check' value='".$table." حذف جدول' />
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حذف جداول</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php echo $html; ?>
</body>
</html>