<?php
	require_once('lib/php_header.php');
	//include('css/item.css'); 
	
	if(empty($_GET['itemid']))
		header('Location: index.php');
	
	$id = mysqli_real_escape_string($conn, $_GET['itemid']);
	
	$sql = "SELECT * FROM item 
		JOIN category 
		ON item.itemCategory = category.categoryId 
		WHERE itemId=".$id;	
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
		header('Location: notfound.php');
	
	$row = mysqli_fetch_assoc($result);

    // title setting
    $title = "::LUCIDKART:: - " . $row['itemName'];
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';

	require_once('lib/menu.php');
?>

<script>
    function LoginAlert()
    {
        document.getElementById("message").innerHTML = "<span style='color: red; font-weight: bold'>Log in first</span>";
    }
</script>

<?php
	
	echo '<div><img src="'.$row['itemImage'].'" width="300" height="400"></div>';
	
	echo '<form id="itemForm" name="addCart" action="cart.php" method="post" onsubmit="return CheckQty();">
		<input type="hidden" name="txtItemId" id="txtItemId" value='.$row['itemId'].' readonly /><br />';
		
	echo '<h2>'.$row['itemName'].'</h2>';
	echo '<p>Category: '.$row['categoryName'].'</p>';
	echo '<div><p>$ '.number_format($row['itemPrice'], 2).'</p>';
	echo '<p>'.$row['description'].'</p></div>';
	
	if ($row['onHand'] == 0)
		echo "Sold Out";
	else
	{
		echo 'Quantity: <input type="number" name="numQty" id="numQty" value="0" step="1" min="0" max="'.$row['onHand'].'" /><br />';
		if (isset($_SESSION['userId']) && isset($_SESSION['userName']))
			echo "<input id='add' type='submit' name='submit' value='Add' />";
		else
			echo "<input id='add' type='button' name='submit' value='Add' onclick='LoginAlert();' />";
		echo '<div id="message"></div>';
	}

	echo '</form>';

	require_once('lib/footer.php');
		
	?>
