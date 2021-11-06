<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT ALLOWS ADMIN TO CHANGE CAPTCHA-ALGORITHM

require_once("includes/check_session.php");
require_once "admin_database_handler.php";
require_once "captcha_database_handler.php";
require_once "alternative_answers.php";
require_once "algorithms.php";


$selector = "";
$message = ".جهت تغییر الگوریتم، یکی از موارد بالا را انتخاب نمائید ، سپس ذخیره را انتخاب کنید";

$admin_db = new Database(
    $_SESSION["username"],
    $_SESSION['password']
);
$captcha_db = new CaptchaDatabase ();

if( isset($_POST["return"]) )
redirect("menu.php");

// save changes
if( isset($_POST["save"]) && isset($_POST["captcha"]) )
{
    $result = $admin_db->query(
        "Update `setting` SET `captcha_type` = '". (int) $_POST["captcha"] ."' ;"
    );
    $message = ".تنظیمات با موفقیت ذخیره شد";
}


$choosed_algorithm = $captcha_db->getInfo()["captcha_type"];
$answer = new Answers ( $captcha_db->getWord() );
$algorithms = new Algorithm;
$answers = $answer->getAnswer();
for ($i=1; $i <= 6 ; $i++)
$images[] = $algorithms->getBase64Image( $answers , $i );


foreach ($images as $key => $image) {
    $selector .="
    <input id='captcha". ((int)$key + 1) ."' type='radio' name='captcha' value='". ((int)$key + 1) ."'  ".  ( ( ((int)$key + 1) == $choosed_algorithm ) ? "checked" : "" )  ." />
    <label class='drinkcard-cc' for='captcha". ((int)$key + 1) ."' style='background-image:url(data:image/jpeg;base64,".$image.");' ></label>
    ";
}

function printAnswer($answer)
{
    ob_start();
    echo ":پاسخهای درست" . "<br>";
    foreach ($answer as $value) echo $value . "<br>";
    return ob_get_clean();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتظیمات الگوریتم</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">

</head>
<body>

    <form class='Panel' action='' method='post'>
        <h1>
        نتظیمات الگوریتم
        </h1> 
        <div style="color:white;">
            <?php echo printAnswer($answers); ?>
        </div>
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