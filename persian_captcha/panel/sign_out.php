<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS SCRIPT UNSETS SESSIONS IN ORDER TO LOG OUT

require_once("includes/redirect.php");

session_start();
session_unset();
session_destroy();

redirect("sign_in.php");


?>