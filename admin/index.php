<?php
    require_once('lib/header.php');	

    // title setting
    $title = "ADMIN - ::LUCIDKART::";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/admin/index.css">';
	
	require_once('lib/menu.php');
	
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
?>