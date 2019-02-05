<?php
	require_once('lib/php_header.php');
	
	if (isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
		$message = "";	

	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo "<script>alert('Log in to view cart.');
		    window.location = 'index.php';</script>";
	}


	else
	{
		// if no session for cart, set it first
		if (!isset($_SESSION['items']))
			$_SESSION['items'] = array();
		
		// if values are passed from item.php page,
		// update array
		if (isset($_POST['txtItemId']) && isset($_POST['numQty']))
		{
			$itemId = $_POST['txtItemId'];
			$qty = $_POST['numQty'];
			$items = $_SESSION['items'];
			
			if (!isset($items[$itemId]))
			    $items[$itemId] = 0;
			
			$sql = "SELECT * FROM item WHERE itemId=".$itemId;
			$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			
			$message = $row['itemName']." is added.";
			$items[$itemId] += $qty;
			
			$_SESSION['items'] = $items;

		}

		// if Delete button clicked
		else if (isset($_POST['delete']) && isset($_POST['txtKey']))
		{
			$key = $_POST['txtKey'];
			$items = $_SESSION['items'];

			unset($items[$key]);
			$_SESSION['items'] = $items;
			
			$message = "Item is deleted";
		}
	}
	
	// title setting
    $title = "::LUCIDKART:: - " . $_SESSION['userName'] . "'s Cart";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/cart.css">';
	
	require_once('lib/menu.php');

	if ($message!=null)
	{
		echo "<div id='message' class='alert alert-success' role='alert'>$message</div>";
	}

	echo "<h2>".$_SESSION['userName']."'s Cart</h2>";
	
	$total = (float)0;

	if ($_SESSION['items'] == null)
		echo "<p>Your cart is empty</p>
			<p><a href='index.php'>Continue shopping</a></p>";
	
	else
	{		
		echo "<div style='overflow-x:auto;'><table id='tblCart' name='tblCart'><tr>
			<th>Item Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Subtotal</th>
			<th>Delete</th>
			</tr>";			
	
	
		foreach($_SESSION['items'] as $id => $q)
		{
			$sql = "SELECT * FROM item WHERE itemId=".$id;
			$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			$subtotal = floatval($q) * $row['itemPrice'];
			$total += $subtotal;
			$key = $row['itemId'];
			$hiddenForm = "<form name='hiddenForm' action=".$_SERVER['PHP_SELF']." method='post'>
				<input type='hidden' name='txtKey' id='txtKey' value='".$row['itemId']."' />
				<input type='submit' name='delete' value='Delete' /></form>";
				
			
			echo "<tr>
				<td><img src=".$row['itemImage'].">".$row['itemName']."</td>
				<td>".$row['itemPrice']."</td>
				<td>".$q."</td>
				<td>".$subtotal."</td>
				<td>".$hiddenForm."</td>
			</tr>";
		}
		
		echo "<tr>
				<td></td>
				<td></td>
				<td>Total:</td>
				<td>".$total."</td>
			</tr></table></div>
			<input type='button' value='Proceed to Order' onClick='Order();' />";
	}
		
?>

	<p>(Cart will be cleared when logout)</p>
	
	<script>
	function Order()
	{		
		if ('tblCart' == null)
			document.getElementById("message").innerHTML = "<font color=red><strong>Cart is Empty!</strong></font>";
		else
			window.location = 'order.php';
	}
	</script>
	
<?php

	require_once('lib/footer.php');

?>
	