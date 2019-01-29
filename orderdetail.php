<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}
	
	else if (!isset($_GET['orderid']))
	{
		echo '<script>alert("Wrong access");
			window.location = "orderhistory.php"</script>';
	}	
	
	// title setting
    $title = "::LUCIDKART:: - Order Detail";
    
    // include css
	// if it doesn't include any css other than home.css,
	// declare it as an empty string ($css = "")
	$css = '<link rel="stylesheet" type="text/css" href="css/cart.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents
	echo "<h2>Order Detail</h2>";
	
	$orderId = $_GET['orderid'];
	
	$sql = "SELECT * FROM orderHeader
	JOIN orderDetail USING(orderId)
	JOIN item USING(itemId) 
	JOIN province ON orderHeader.province = province.code
	WHERE orderId=".$orderId." AND customerId=".$_SESSION['userId'];	
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
	{
		echo '<script>alert("Error: No item in Order");
			window.location = "orderhistory.php"</script>';
	}
	
	else
	{
	    $deliverySql ="SELECT * FROM orderHeader WHERE orderId=".$orderId;
	    $deliveryInfo = mysqli_fetch_assoc((mysqli_query($conn, $deliverySql)));
		
		// Deliver to
		echo '<h3>Deliver To: '.$deliveryInfo['firstName'].' '.$deliveryInfo['lastName'].'</h3>';
		echo '<p>'.$deliveryInfo['address'].', <br />'
    		.$deliveryInfo['city'].', '.$deliveryInfo['province'].'<br />'
			.$deliveryInfo['postalCode'].'</p>';
			
		// Shipped date
		if ($deliveryInfo['dispatchedDate'] == NULL)
		{
			$shipped = "Preparing for shipping...";
		}

		else
		{
			$shipped = "Shipped Date: ".$row['dispatchedDate'];
		}

		echo "<p><b>$shipped</b></p>";
		
		// Order list
		echo '<h3>Order List</h3>';
		
		$total = (float)0;
		$tax = (float)0;
		
		echo '<table><tr>
			<th>Item Name</th>
			<th>Item Image</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Sub Total</th>
			</tr>';
		
		while($row = mysqli_fetch_assoc($result))
		{
			$subtotal = (float)$row['itemPrice'] * (float)$row['qty'];
			$total += $subtotal;
			if ($tax == 0)
			    $tax = (float)$row['taxrate'];
			
			echo '<tr>
				<td>'.$row['itemName'].'</td>
				<td><img src="'.$row['itemImage'].'" width="150" height="200"></td>
				<td>'.$row['itemPrice'].'</td>
				<td>'.$row['qty'].'</td>
				<td>'.$subtotal.'</td>
				</tr>';
		}
		
		echo '<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Total: </td>
			<td>'.$total.'</td>
			</tr>';
			
		echo '<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Tax: </td>
			<td>'.round(($total * $tax), 2).'</td>
			</tr>';
			
		echo '<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Grand Total: </td>
			<td>'.round(($total + $total * $tax), 2).'</td>
			</tr>';
		
		echo '</table>';
		
	}
	

	// footer
	require_once('lib/footer.php');

?>
	