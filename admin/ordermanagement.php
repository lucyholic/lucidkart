<?php
	require_once('lib/header.php');	
	
	// title setting
    $title = "::LUCIDKART:: - Order management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	
	require_once('lib/menu.php');
    
    $sql = "SELECT * FROM orderHeader";

    if (isset($_POST['notdispatched']))
    {
        $sql = "SELECT * FROM orderHeader WHERE dispatchedDate IS NULL";
    }

    if (isset($_GET['txtOrderId']))
    {
        $orderId = $_GET['txtOrderId'];
        $sql = "SELECT * FROM orderHeader WHERE orderId='".$orderId."'";
    }

    $result = mysqli_query($conn, $sql);
    ?>

<h2>Order Management</h2>
<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    Search by Order ID : <input type="number" name="txtOrderId" id="txtOrderId" />
    <input type="submit" value="Search" />
</form>
<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="submit" name="notdispatched" value="Show Not Dispatched Orders" />
</form>
<br />
<table>
<tr><th>Order ID</th><th>Order Date</th><th>Dispatched Date</th></tr>

<?php
    while($row = mysqli_fetch_assoc($result))
    {
        if ($row['dispatchedDate'] == null)
        {
            $dispatchedDate = "N/A";
        }
        else
        {
            $dispatchedDate = $row['dispatchedDate'];
        }

        echo '<tr>
            <td><a href="ordermanager.php?orderid='.$row['orderId'].'">'.$row['orderId'].'</a></td>
            <td>'.$row['orderDate'].'</td>
            <td>'.$dispatchedDate.'</td></tr>';
    }

    echo '</table>';

    require_once('../lib/footer.php');
?>