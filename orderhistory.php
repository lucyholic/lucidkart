<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}
	
	// sql setting
	$orderSql = "SELECT * FROM orderHeader 
	    JOIN orderDetail USING (orderId) 
	    JOIN item ON orderDetail.itemId = item.itemId 
	    WHERE customerId='".$_SESSION['userId']."' 
    	ORDER BY orderDate DESC";
	$orderResult = mysqli_query($conn, $orderSql);
	
	// title setting
    $title = "::LUCIDKART:: - ".$_SESSION['userName']."'s Order History";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents
	echo "<h2>".$_SESSION['userName']."'s Order History</h2>";
	
	if (mysqli_num_rows($orderResult) == 0)
		echo '<p>You have no order history.</p>';
	
	else
	{
		echo '<p>Click Order Date to see Detail</p>
			<div style="overflow-x:auto;"><table>
    			<tr>
    				<th>Order Date</th>
    				<th>Order Item</th>
    				<th>Price</th>
    				<th>Quantity</th>
    				<th>Total Amount</th>
    			</tr>';
		
		while($row = mysqli_fetch_assoc($orderResult))
		{
			
			echo '<tr>
				<td><a href="orderdetail.php?orderid='.$row['orderId'].'">'.$row['orderDate'].'</a></td>
				<td>'.$row['itemName'].'</td>
				<td>'.$row['itemPrice'].'</td>
				<td>'.$row['qty'].'</td>
				<td></td>
				</tr>';
		}
		
		echo '</table></div>';
	}
	

	// footer
	require_once('lib/footer.php');

?>
	