<?php

session_start();
echo $_SESSION['basicCaptcha']."<br>".$_SESSION['dynamicBasicCaptcha']."<br>".$_SESSION['untiOCRcaptcha']."<br>";

?>