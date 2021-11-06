<?php

// THIS SCRIPT USES ALL OF CAPTCHA CLASSES AND GENERATES CAPTCHA AND STREAM IT INTO ITS CONTENT

include_once "captcha_database_handler.php";
include_once "alternative_answers.php";
include_once "algorithms.php";

$db = new CaptchaDatabase ();
$answer = new Answers ( $db->getWord() );
$algorithms = new Algorithm;
$answers = $answer->getAnswer();
$type = $db->getInfo()["captcha_type"];
if ( isset($answers[0]) && $type ) {
    $algorithms->streamImage( $answers , $type );
}
else die("ERROR OCCUERD!");

?>