<?php

// checks if user has logged in, else redirects to sign in page

session_start();

if( (!isset($_SESSION['username'])) || (!isset($_SESSION['password']))  )
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