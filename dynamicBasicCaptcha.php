<?php

// IMPORTANT : It is crackable with OCR bots.
// WARNING : This is not an optimized script, it's just to show you how I provide a dynamic captcha
// Script by TadavomnisT

session_start();
$captcha_length = 25; //Define length of captcha characters, must be from 1 to 32
$case_sensitivity = true; //Put true if you want to have case sensitive captcha and false if you don't
$str_rand=md5(rand());
$str="";

$newImage = imagecreate(10.8*$captcha_length+((intval($captcha_length/14)==0)?pow($captcha_length,(1/3))*8:0),30);
imagecolorallocate($newImage,220,220,255);
$col=imagecolorallocate($newImage,0,0,0);

for ($i=0; $i < $captcha_length ; $i++){
    $str_temp = substr($str_rand,$i,1);
    if (intval(strval(rand())[0])>4) $str_temp = strtoupper($str_temp);
    $col = imagecolorallocate ($newImage, rand(0,100), rand(0,100), rand(0,100));
    imagestring($newImage,5,(10*($i+1)),rand(2,11),$str_temp,$col);
    $str.=$str_temp;
}

if ($case_sensitivity==false)$str=strtolower($str);
$_SESSION['dynamicBasicCaptcha']=$str;

header('content:image/jpeg');
imagejpeg($newImage);

// Script by TadavomnisT
?>