<?php

// THIS SCRIPT PROVIDES A "API" FOR EXTERNAL USUES OF CAPTCHA PROJET
// NOTICE 1: the API works with json protocol for the answers
// NOTICE 2: the API works with base64 encoding for images
// 
// 
// ==========================================================================================================
// 
//                                 EXAMPLE  an external PHP usage:
// 
//                      file_get_content("https://domain.to.this.url/api.php");
// 
//                                    json will be somting like:
// 
//     {"answers":["\u0627\u06cc\u0645\u0627\u0646","hdlhk"],"base64_image":"\/9j\/4AAQSkZJRgAB}....."}




include_once "captcha_database_handler.php";
include_once "alternative_answers.php";
include_once "algorithms.php";

$db = new CaptchaDatabase ();
$answer = new Answers ( $db->getWord() );
$algorithms = new Algorithm;
$answers = $answer->getAnswer();
$type = $db->getInfo()["captcha_type"];
$base64_encoded_image = $algorithms->getBase64Image( $answers , $type );
$json = json_encode(
    [
        "answers" => $answers ,
        "base64_image" => $base64_encoded_image 
    ]
);
echo $json;

?>