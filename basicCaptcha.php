<?php

// IMPORTANT : It is crackable with OCR bots.
// WARNING : This is not an optimized script, it's just to show you how I provide a captcha
// Script by TadavomnisT

session_start(); //starting sessions to use, You can use other features...
$str_rand = md5(rand()); //generates a random text including digits and letters
$str  = substr($str_rand, 0, 6); //splitting first 6 characters for our captcha

//split one by one
$str1 = substr($str_rand, 0, 1);
$str2 = substr($str_rand, 1, 1);
$str3 = substr($str_rand, 2, 1);
$str4 = substr($str_rand, 3, 1);
$str5 = substr($str_rand, 4, 1);
$str6 = substr($str_rand, 5, 1);



$_SESSION['basicCaptcha'] = $str; //passing key text to session for log_in

$newImage = imagecreate(75, 30); //creating new image object
imagecolorallocate($newImage, 220, 220, 255); //generates a bright color
$col = imagecolorallocate($newImage, 0, 0, 0); //cover the image with a bright color

//generates a dark color for each character
$col1 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));
$col2 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));
$col3 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));
$col4 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));
$col5 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));
$col6 = imagecolorallocate($newImage, rand(0, 100), rand(0, 100), rand(0, 100));

// write each character on the image
imagestring($newImage, 5, 10, rand(2, 11), $str1, $col1);
imagestring($newImage, 53, 20, rand(2, 11), $str2, $col2);
imagestring($newImage, 53, 30, rand(2, 11), $str3, $col3);
imagestring($newImage, 53, 40, rand(2, 11), $str4, $col4);
imagestring($newImage, 5, 50, rand(2, 11), $str5, $col5);
imagestring($newImage, 5, 60, rand(2, 11), $str6, $col6);

// sending the generated captcha image to the header in order to use in other scripts
header('content:image/jpeg');
imagejpeg($newImage);
?> 