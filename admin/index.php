<?php
    require_once('lib/header.php');	

    // title setting
    $title = "ADMIN - ::LUCIDKART::";
    
    // include css
    $css = '<link rel="stylesheet" type="text/css" href="../css/admin/index.css">';
    $message = "";
    $adminpassword = 'admin123';

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

    if (!isset($_SESSION['admin']))
    {
?>

<h2>Admin Login</h2>
<h3>password: <?= $adminpassword?></h3>
<p><font color=red><strong><?= $message ?></strong></font></p><br />
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

<input type="password" name="txtPassword" placeholder="Admin Password"><br /><br />
<input type="submit" name="adminlogin" value="Admin Login"><br /><br />

</form>

<?php
    }

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