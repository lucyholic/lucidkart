<?php
	require_once('lib/header.php');		
    
    if (!isset($_SESSION['admin']))
    {
        unset($_SESSION['admin']);
    }

    echo '<script>window.location="../index.php";</script>';
?>