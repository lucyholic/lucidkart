<?php
/*

admin index page

if admin session is not set, displays admin login page,
or display admin menu

*/
    require_once('lib/header.php');	

    // title setting
    $title = "ADMIN - ::LUCIDKART::";
    
    // include css
    $css = '<link rel="stylesheet" type="text/css" href="../css/admin/index.css">';
    $message = "";
    $adminpassword = 'admin123';

    // when admin login is attemped, check the password
    if (isset($_POST['adminlogin']))
    {
        $pw = $_POST['txtPassword'];

        if ($pw != $adminpassword)
        {
            $message = "Admin password doesn't match";
        }

        else
        {
            $_SESSION['admin'] = "authenticated";
        }
    }
    
    // if admin session is not set, display admin login page
    if (!isset($_SESSION['admin']))
    {
?>

<h2>Admin Login</h2>

<?php

    echo "password: $adminpassword";
    echo "<span style='color: red; font-weight: bold'>$message</span>";

?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

<input type="password" name="txtPassword" placeholder="Admin Password"><br /><br />
<input type="submit" name="adminlogin" value="Admin Login"><br /><br />

</form>

<?php
    }

    // Display admin index page

    else
    {
	    require_once('lib/adminmenu.php');
    
?>
    <div class='container'>
        <a href='itemmaintenance.php'>
            <div class='overlay'>
                Item Maintenance
            </div>
            <img src='../images/admin/item.png' height='20%' width='20%'>
        </a>
    </div>
    <div class='container'>
        <a href='categorymaintenance.php'>
            <div class='overlay'>
                Category Maintenance
            </div>
            <img src='../images/admin/category.png' height='20%' width='20%'>
        </a>
    </div>
    <div class='container'>
        <a href='ordermanagement.php'>
            <div class='overlay'>
                Order Management
            </div>
            <img src='../images/admin/order.png' height='20%' width='20%'>
        </a>
    </div>
    <div class='container'>
        <a href='stockmanagement.php'>
            <div class='overlay'>
                Stock Management
            </div>
            <img src='../images/admin/stock.png' height='20%' width='20%'>
        </a>
    </div>

<?php
    require_once('../lib/footer.php');
    }
?>