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
	$orderSql = "SELECT *
		FROM orderHeader
	    WHERE customerId='".$_SESSION['userId']."' 
    	ORDER BY orderDate DESC";
	$orderResult = mysqli_query($conn, $orderSql);
	
	// title setting
    $title = "::LUCIDKART:: - ".$_SESSION['userName']."'s Order History";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/cart.css">';
	
	// menu
	require_once('lib/menu.php');

	// set message
    if (isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
	else
		$message = "";	

    if ($message != "")
	{
		echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>";
    }
	
	// body contents
	
	echo "<h2>".$_SESSION['userName']."'s Order History</h2>";
	
	if (mysqli_num_rows($orderResult) == 0)
		echo '<p>You have no order history.</p>';
	
	else
	{
		echo '<p>Click Order Date to see Detail</p>
			<div style="overflow-x:auto;"><br />
			<table>
    			<tr>
    				<th>Order Date</th>
					<th>Order Item</th>
					<th>Quantity</th>
					<th>Shipped Date</th>
				</tr>';
		
		while($row = mysqli_fetch_assoc($orderResult))
		{
			$itemSql = "SELECT * FROM orderDetail
				JOIN item USING (itemId)
				WHERE orderId = '".$row['orderId']."'
				orDER BY itemName";
			$itemResult = mysqli_query($conn, $itemSql);
			$numItem = mysqli_num_rows($itemResult);

			// Display shipped date
			if ($row['dispatchedDate'] == NULL)
			{
				$shipped = "Preparing for shipping...";
			}

			else
			{
				$shipped = $row['dispatchedDate'];
			}
			
			if ($numItem == 0)
				$numItem = 1;

			echo '<tr>
				<td rowspan="'.$numItem.'"><a href="orderdetail.php?orderid='.$row['orderId'].'">'.$row['orderDate'].'</a></td>';
			
			$count = 0;
			while ($itemRow = mysqli_fetch_assoc($itemResult))
			{
				echo '<td>'.$itemRow['itemName'].'</td>
					<td>'.$itemRow['qty'].'</td>';
				
				if ($count == 0)
					echo '<td rowspan="'.$numItem.'">'.$shipped.'</td></tr>';
				
				echo '</tr>';
				$count++;
			}
		}
		
		echo '</table></div>';
	}

	// footer
	require_once('lib/footer.php');

?>
	