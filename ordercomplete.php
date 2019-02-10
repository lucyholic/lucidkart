<?php
	require_once('lib/php_header.php');
	require_once('class/orderheader.php');
	
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
		$_SESSION['message'] = 'Cart is empty!';
		echo '<script>window.location = "index.php"</script>';
	}
	
	$items = $_SESSION['items'];

	// construct order class
	$order = new Order();

	// Set attributes
	$order->customerId = $_SESSION['userId'];
	$order->orderDate = date("Y/m/d");
	$order->firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
	$order->lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
	$order->phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
	$order->address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
	$order->city = mysqli_real_escape_string($conn, $_POST['txtCity']);
	$order->province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
	$order->postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);
	$order->orderDetails = $items;

	$order->CreateNewOrder();

	// if no items in order
	if($order->numOfItems == 0)
	{
		echo '<script>alert("Error");
			window.location="index.php";</script>';
	}
	
	// empty cart
	unset($_SESSION['items']);	

	// title setting
    $title = "::LUCIDKART:: - Order Complete";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	require_once('lib/menu.php');

	echo "<h2>Thank you, ".$_SESSION['userName']."!<br />
		Your order is completed</h2>";
	
	// Order list
	echo "<h3>".$order->numOfItems." item(s)</h3>";
	echo "<p>Subtotal: ".$order->subtotal."</p>";
	echo "<p>Tax: ".$order->tax."</p>";
	echo "<p>Total: ".$order->total."</p>";
	
	// Delivery Address
	echo '<h3>Deliver To: '.$order->firstName.' '.$order->lastName.'</h3>
		<p>'.$order->address.', <br />'
		.$order->city.', '.$order->province.'<br />'
		.$order->postalCode.'</p>';
		
	require_once('lib/footer.php');

?>
	