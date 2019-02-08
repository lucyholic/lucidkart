<?php
	require_once('lib/php_header.php');
	require_once('class/validate.php');
	require_once('class/orderheader.php');
	require_once('class/orderitem.php');
	
	// Bounce back if not coming from order.php or without login session
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}
	
	else if (!isset($_POST['confirm']))
	{
		echo '<script>alert("Wrong access");
			window.location = "index.php"</script>';
	}	
	
	else if (!isset($_SESSION['items']))
	{
		echo '<script>alert("Cart is Empty!");
			window.location = "index.php"</script>';
	}
	
	$items = $_SESSION['items'];

	// construct orderHeader class
	$orderHeader = new OrderHeader();

	// Set attributes

	$orderHeader->customerId = $_SESSION['userId'];
	$orderHeader->orderDate = date("Y/m/d");
	$orderHeader->firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
	$orderHeader->lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
	$orderHeader->phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
	$orderHeader->address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
	$orderHeader->city = mysqli_real_escape_string($conn, $_POST['txtCity']);
	$orderHeader->province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
	$orderHeader->postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);
	
	// Get Taxrate
	$taxResult = mysqli_query($conn, "SELECT taxrate FROM province WHERE code='".$orderHeader->province."'");
	$taxrate = floatval(mysqli_fetch_row($taxResult)[0]);
	
	// Create order header
	$orderSql = $orderHeader->AddOrderHeader();
		
	mysqli_query($conn, $orderSql);
	$orderId = mysqli_insert_id($conn);
	
	// add order items	
	$items = $_SESSION['items'];
	foreach($items as $id => $q)
	{
		// create an order item object
		$o = new orderItem();
		$o->orderId = $orderId;
		$o->itemId = $id;
		$o->qty = $q;

		$detailSql = $o->AddOrderItem();
		mysqli_query($conn, $detailSql);
	}
	
	unset($_SESSION['items']);
	$items = null;
	

	// title setting
    $title = "::LUCIDKART:: - Order Complete";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	require_once('lib/menu.php');

	echo "<h2>Thank you, ".$_SESSION['userName']."!<br />
		Your order is completed</h2>";
	
	// Order list
	echo "<h3>Item</h3>";
	
	//	itemSql
	$itemResult = mysqli_query($conn, "SELECT * FROM orderDetail JOIN item USING (itemId) 
	WHERE orderid='".$orderId."'");

	$total = (float)0;
	
	if ($itemResult -> num_rows == 0)
	{
		echo '<script>alert("Error");
			window.location="index.php";</script>';
	}
	
	else if ($itemResult -> num_rows == 1)
	{
	    
	    $itemRow = mysqli_fetch_assoc($itemResult);
	    $total = round(floatval($itemRow['itemPrice']) * (1 + $taxrate), 2);
    		echo '<h3>1 item: '.$itemRow['itemName'].'</h3>
    		<p>Total Amount: $'.$total.'</p>';
	    
	}
	
	else
	{
		$firstItem = "";
		$numRows = mysqli_num_rows($itemResult);
		
		while($itemRow = mysqli_fetch_assoc($itemResult))
		{
			if ($firstItem == "")
				$firstItem = $itemRow['itemName'];
			$total += floatval($itemRow['itemPrice']);
		}
		
		$total = round($total * (1 + $taxrate), 2);
		
		
		echo '<p>'.$numRows.' items: '.$firstItem.' and '.($numRows - 1).' more item(s)</p>
			<p>Total Amount: $'.$total.'</p><br />';
	}

	
	// Delivery Address
	echo '<h3>Deliver To: '.$orderHeader->firstName.' '.$orderHeader->lastName.'</h3>
		<p>'.$orderHeader->address.', <br />'
		.$orderHeader->city.', '.$orderHeader->province.'<br />'
		.$orderHeader->postalCode.'</p>';
		
	
	require_once('lib/footer.php');

?>
	