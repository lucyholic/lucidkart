<?php
/*

Checks admin session
If not logged in as admin, redirects to index

*/

if (!isset($_SESSION['admin']))
{
    echo '<script>alert("Invalid access");
        window.location="index.php";
    </script>';
}

?>