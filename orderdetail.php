<?php
	// This line must be on the top
	require_once('lib/php_header.php');

	// include class
	require_once('class/orderheader.php');
	require_once('class/item.php');
	
	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}
	
	else if (!isset($_GET['orderid']))
	{
		$_SESSION['message'] = "Wrong access";
		echo '<script>window.location = "index.php"</script>';
	}

	$orderId = mysqli_real_escape_string($conn, $_GET['orderid']);

	try
	{
		$order = new Order();
		$order = $order->GetOrderHeader($orderId);
		$order->GetOrderDetail();
		$order->GetTotal();
	}

	catch(Exception $ex)
	{
		$_SESSION['message'] = $ex->getMessage();

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
	
	// Deliver to
	echo "<h3>Deliver to: ".$order->firstName." ".$order->lastName."</h3>";
	echo "<p>$order->address, <br />
		$order->city, $order->province<br />
		$order->postalCode</p>";

	// Shipped date
	if($order->dispatchedDate == "")
		$shipped = "Preparing for shipping...";
	else
		$shipped = "Shipped Date: $order->dispatchedDate";

		echo "<p><b>$shipped</b></p>";
	
	// Order list
	echo '<h3>Order List</h3>';

	echo '<table><tr>
		<th>Item Name</th>
		<th>Item Image</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Sub Total</th>
		</tr>';

	foreach($order->orderDetails as $id => $q)
	{
		$item = new Item();
		$item = $item->GetItem($id);

		$subtotal = number_format((float)$item->itemPrice * $q, 2);

		echo '<tr>
			<td>'.$item->itemName.'</td>
			<td><img src="'.$item->itemImage.'" width="150" height="200"></td>
			<td>'.$item->itemPrice.'</td>
			<td>'.$q.'</td>
			<td>'.$subtotal.'</td>
			</tr>';
	}
	
		
	echo '<tr>
		<td></td>
		<td></td>
		<td></td>
		<td>Total: </td>
		<td>'.$order->subtotal.'</td>
		</tr>';
		
	echo '<tr>
		<td></td>
		<td></td>
		<td></td>
		<td>Tax: </td>
		<td>'.$order->tax.'</td>
		</tr>';
		
	echo '<tr>
		<td></td>
		<td></td>
		<td></td>
		<td>Grand Total: </td>
		<td>'.$order->total.'</td>
		</tr>';
	
	echo '</table>';
		
	
	// footer
	require_once('lib/footer.php');

?>
	