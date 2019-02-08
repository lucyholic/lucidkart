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

    require_once('lib/adminmenu.php');
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

        <form id="adminSignIn" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h1>Admin Sign In</h1>	
            <br />

            <?php
            echo "password: $adminpassword";
            if ($message != "") {
                    echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>";	
                }
            ?>

            <input type="password" name="txtPassword" placeholder="Admin Password"><br /><br />
            <input type="submit" class="submit" name="adminlogin" value="Admin Login"><br /><br />

        </form>

<?php
    }

    // Display admin index page

    else
    {
	    require_once('lib/adminmenu.php');
    
?>
    <div class="categories">
        <div class='container'>
            <a href='itemmaintenance.php'>
                <!-- <img src='../images/admin/itemc.png' > -->
                <div class='overlay'>
                    <h6>Item Maintenance</h6>
                </div>
                <img src="../images/admin/itemc.png" alt="instagram logo" 
                onmouseover="this.src='../images/admin/itemcc.png';" onmouseout="this.src='../images/admin/itemc.png';">

            </a>
        </div>
        <div class='container'>
            <a href='categorymaintenance.php'>
                <div class='overlay'>
                    <h6>Category Maintenance</h6>
                </div>
                <img src='../images/admin/categoryc.png' 
                onmouseover="this.src='../images/admin/categorycc.png';" onmouseout="this.src='../images/admin/categoryc.png';">
            </a>
        </div>
        <div class='container'>
            <a href='ordermanagement.php'>
                <div class='overlay'>
                    <h6>Order Management</h6>
                </div>
                <img src='../images/admin/orderc.png' 
                onmouseover="this.src='../images/admin/ordercc.png';" onmouseout="this.src='../images/admin/orderc.png';">
            </a>
        </div>
        <div class='container'>
            <a href='stockmanagement.php'>
                <div class='overlay'>
                    <h6>Stock Management</h6>
                </div>
                <img src='../images/admin/stockc.png' 
                onmouseover="this.src='../images/admin/stockcc.png';" onmouseout="this.src='../images/admin/stockc.png';">
            </a>
        </div>
    </div>

<?php
    require_once('../lib/footer.php');
    }
?>