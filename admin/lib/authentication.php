<?php

if (!isset($_SESSION['admin']))
{
    echo '<script>alert("Invalid access");
        window.location="index.php";
    </script>';
}

?>