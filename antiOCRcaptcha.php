<?php

// IMPORTANT : Not crackable with OCR bots.
// NOTICE : This is an optimized script.
// Script by TadavomnisT

session_start();
$captcha_length = 32; //Define length of captcha characters, must be from 1 to 32
$case_sensitivity = true; //Put true if you want to have case sensitive captcha and false if you don't
$str_rand=md5(mt_rand());
$str="";

$image_l=30.8*$captcha_length+((intval($captcha_length/14)==0)?pow($captcha_length,(1/3))*8:0);
$newImage = imagecreate($image_l,80);
imagecolorallocate($newImage,220,220,255);
$col=imagecolorallocate($newImage,0,0,0);

$fontn[0]=realpath(getcwd()."/zxx-noise.ttf");
$fontn[1]=realpath(getcwd()."/zxx-xed.ttf");

for ($i=0;$i<100;$i++)imageline($newImage,mt_rand(0,$image_l),mt_rand(0,80),mt_rand(0,$image_l),mt_rand(0,80),imagecolorallocate($newImage,245,245,245));
for ($i=0; $i < 15 ; $i++) $cols[] = imagecolorallocate ($newImage, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
for ($i=0; $i < $captcha_length ; $i++){
    $str_temp = substr($str_rand,$i,1);
    if (mt_rand(0,1)) $str_temp = strtoupper($str_temp);
    imagettftext($newImage, mt_rand(30,50), mt_rand(-20,20), 30*$i, 60, $cols[array_rand($cols)], $fontn[mt_rand(0,1)], $str_temp );
    if(mt_rand(0,1))imagettftext($newImage, mt_rand(30,50), mt_rand(-20,20), mt_rand(0,$image_l), mt_rand(0,80), $cols[array_rand($cols)], $fontn[mt_rand(0,1)], " " );
    $str.=$str_temp;
}
if ($case_sensitivity==false)$str=strtolower($str);
$_SESSION['untiOCRcaptcha']=$str;

header('content:image/jpeg');
imagejpeg($newImage);

// Script by TadavomnisT
?>
