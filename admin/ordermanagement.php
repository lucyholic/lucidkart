<?php
	require_once('lib/header.php');		
    require_once('lib/authentication.php');
    
	// title setting
    $title = "::LUCIDKART:: - Order management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/admin/adminSubpages.css">';
	
    require_once('lib/adminmenu.php');
    
    if (isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
	else
		$message = "";	
    
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

    if ($message != "")
	{
		echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>";
	}
    
 ?>


<h2>Order Management</h2>
<br /><br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input class="searchInput" type="number" name="txtOrderId" id="txtOrderId" placeholder="Search Order ID..">
    <input class="searchButton submit" type="submit" value="Search">
    <br><br>
</form>
<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input class="white" type="submit" name="notdispatched" value="Show Not Dispatched Orders" />
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

    echo '</table>
    <br><br><br>';

    require_once('../lib/footer.php');
?>