<?php

// THIS IS A TEST FROM ALL ALGORITHMS OF CAPTCAH PROJECT
// YOU CAN DELETE THIS FILE


include_once "captcha_database_handler.php";
include_once "alternative_answers.php";
include_once "algorithms.php";

function printAnswer($answer)
{
    ob_start();
    print_r($answer);
    return ob_get_clean();
}


$db = new CaptchaDatabase ();
$answer = new Answers ( $db->getWord() );
$algorithms = new Algorithm;
$answers = $answer->getAnswer();
for ($i=1; $i <= 6 ; $i++)
$images[] = $algorithms->getBase64Image( $answers , $i );


$content = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .center {
        margin: auto;
        width: 85%;
        border: 3px solid gold;
        padding: 10px;
      }
    </style>
</head>
<body style="background-color: gray;">
<div >
<div class="center" >
    <p>The answer array is : </p>
    <pre>'. printAnswer($answers) .'</pre>
    <br>
    <br>';
foreach ($images as $key => $image) {
$content .='
<img src="data:image/jpeg;base64,'.$image.'" alt="captcha_'. ((int)$key + 1) .'">
';
}
$content .= ' 
<br>
<br>
<div style"margin: auto;">
<button onClick="window.location.reload();">Refresh CAPTCHAs</button> 
</div>  
</div>  
</div>  
</body>
</html>
';

echo $content;

?>
