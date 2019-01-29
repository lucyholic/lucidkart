<?php
	require_once('lib/php_header.php');
	
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
	
	// fetch information from previous page
	$customerId = $_SESSION['userId'];
	$orderDate = date("Y/m/d");
	$firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
	$lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
	$phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
	$address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
	$city = mysqli_real_escape_string($conn, $_POST['txtCity']);
	$province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
	$postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);
	
	// Get Taxrate
	$taxResult = mysqli_query($conn, "SELECT taxrate FROM province WHERE code='".$province."'");
	$taxrate = floatval(mysqli_fetch_row($taxResult)[0]);
	
	// Create order header
	$orderSql = "INSERT INTO orderHeader (customerId,
		orderDate,
		firstName,
		lastName,
		phoneNumber,
		address,
		city,
		province,
		postalCode) VALUES('".
		intval($customerId)."', '".
		$orderDate."', '".
		$firstName."', '".
		$lastName."', '".
		$phone."', '".
		$address."', '".
		$city."', '".
		$province."', '".
		$postalCode."')";
		
	$result = mysqli_query($conn, $orderSql);
	$orderId = mysqli_insert_id($conn);
	
	// add order items and update onhand	
	$items = $_SESSION['items'];
	foreach($items as $id => $q)
	{
		$detailSql = "INSERT INTO orderDetail (orderId,
			itemId,
			qty) VALUES('".
			intval($orderId)."', '".
			intval($id)."', '".
			intval($q)."')";
		
		$result = mysqli_query($conn, $detailSql);
		
		// Update onHand
		$onHand = mysqli_fetch_array(mysqli_query($conn, "SELECT onHand FROM item WHERE itemId='".$id."'"));
		$onHandSql = "UPDATE item SET
			onHand='".((int)$onHand[0] - $q)."'
			WHERE itemId='".$id."'";
		$result = mysqli_query($conn, $onHandSql);
	}
	
	$_SESSION['items'] = null;
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
	$itemResult = mysqli_query($conn, "SELECT * FROM orderDetail JOIN item ON orderDetail.itemId=item.itemId WHERE orderid='".$orderId."'");
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
		
		
		echo '<p>'.$numRows.' items: '.$firstItem.' and '.($numRows - 1).'more items</p>
			<p>Total Amount: $'.$total.'</p><br />';
	}

	
	// Delivery Address
	echo '<h3>Deliver To: '.$firstName.' '.$lastName.'</h3>
		<p>'.$address.', <br />'
		.$city.', '.$province.'<br />'
		.$postalCode.'</p>';
		
	
	require_once('lib/footer.php');

?>
	