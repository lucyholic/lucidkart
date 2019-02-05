<?php
/*
When logout from admin account,
unset admin session and redirect to the site home
*/

	require_once('lib/header.php');		
    
    if (!isset($_SESSION['admin']))
    {
        unset($_SESSION['admin']);
    }

    echo '<script>window.location="../index.php";</script>';
?>