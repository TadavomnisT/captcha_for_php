<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS FILE PREVENTS DIRECTORY BROWSING AND REDIRECTS TO SIGHN IN PAGE

redirect("sign_in.php");


// ==================================functions===================================

function redirect($url)
{
    if (!headers_sent())
    {
	    header('Location: '.$url); exit;
    }else
    {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
	}
}

// ==============================================================================

?>