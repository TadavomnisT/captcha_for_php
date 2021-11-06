<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT PROVIDES A SIGN-IN PANEL AND CHECKS ADMIN VALIDATION

require_once("includes/redirect.php");
require_once("admin_database_handler.php");

$casesensitivity = FALSE; //put TRUE if you need case-sensitive captcha

function chechCaptcha( $captcha , $answers , $casesensitivity)
{
    foreach ($answers as $answer) {
        if (
            ( ($casesensitivity) ? $captcha : strtolower($captcha) )
            ==
            ( ($casesensitivity) ? $answer : strtolower($answer) )
        )
        return true;
    }
    return false;
}


$message = "<div style='color:white;'>
.لطفا فقط یکی از کپچاهای بالا (فارسی یا انگلیسی) را وارد نمایید
<br>
!لازم نیست زبان صفحه‌کلید خود را عوض کنید
</div>";

// sign in
if ( isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["Login"]) && isset($_POST["captcha"]) ) {
    session_start();

    if (
        $_POST["username"] != NULL &&
        $_POST["username"] != "" &&
        $_POST["password"] != NULL &&
        $_POST["password"] != "" &&
        chechCaptcha( $_POST["captcha"] , json_decode($_SESSION['captcha'] , true) , $casesensitivity)
    ) {
        $db = new Database(
            $_POST["username"],
            $_POST["password"]
        );
        if( $db->admin ){
            $_SESSION['username'] = $_POST["username"];
            $_SESSION['password'] = $_POST["password"];
            redirect("menu.php");
        }
        $message = "<div style='color:white;'>.خطا! نام کاربری یا رمز عبور را اشتباه وارد کرده اید</div>";
    }
    else $message = "<div style='color:white;'>.خطا! مقادیر ورودی را اشتباه وارد کرده اید</div>";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <script>
        function reloadCaptcha()
        {
            img = document.getElementById('captcha');
            img.src = 'generate_captcha.php';
        }
    </script>
</head>
<body>
    <form class="Box" action="" method="post">

        <h1>ورود به پنل</h1>
        <input type="text" name="username" placeholder="نام کاربری" required>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <img id="captcha" src="generate_captcha.php" alt="captcha">
        <div style='color:white;font-size:12px;'>.کپچا ناخوانا است؟ <a href="#" onclick="document.getElementById('captcha').src='generate_captcha.php?img=' + Math.random(); return false">اینجا</a> کلیک نمائید</div>
        <input type="text" name="captcha" placeholder="کپچا" required>
        <input type="submit" name="Login" value="Login">
        <?php echo $message; ?>
    </form>
</body>
</html>

