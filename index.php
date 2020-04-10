<?php

/*
    NOTICE: In this example I showed you How to use captchas in HTML5
    IMPORTANT: If you'd like to use captcha in php, in order to send in bots, send for another script, etc you may use :
    $image = file_get_contents("URL_TO_CAPTCHA"); 
*/

// Downloading required files
$files=array( "basicCaptcha.php","dynamicBasicCaptcha.php","antiOCRcaptcha.php","seeSessions.php","zxx-noise.ttf","zxx-xed.ttf" );
foreach ($files as $file)if (!file_exists($file))copy('https://raw.githubusercontent.com/TadavomnisT/captcha_for_php/master/'.$file, $file);


echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing captcha</title>
</head>
<body>
    This is a basic captcha (Not recommended) :<br>
    <img id="cpch" src="basicCaptcha.php" alt="captcha">
    <br>
    This is a dynamic basic captcha (Not recommended) :<br>
    <img id="cpch2" src="dynamicBasicCaptcha.php" alt="captcha">
    <br>
    This is an OCR proof captcha :<br>
    <img id="cpch3" src="antiOCRcaptcha.php" alt="captcha">
    <br>
    <a href="seeSessions.php" target="_blank">See Sessions!</a> 
</body>
</html>
';

// Script by TadavomnisT
?>
