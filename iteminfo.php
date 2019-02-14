<?php
	require_once('lib/php_header.php');
	require_once('class/item.php');
	
	if(empty($_GET['itemid']))
		header('Location: index.php');
	
	$id = mysqli_real_escape_string($conn, $_GET['itemid']);

	try
	{
		$item = new Item();
		$item = $item->GetItem($id);
	}

	catch(Exception $ex)
	{
		echo "<script> window.location = 'index.php';</script>";
	}
	
    // title setting
    $title = "::LUCIDKART:: - " . $item->itemName;
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';

	require_once('lib/menu.php');
?>

<script>
    function LoginAlert()
    {
        document.getElementById("message").innerHTML = "<div class='alert alert-danger' role='alert'>Log in first</div>";
    }
</script>

<?php
	
	echo '<div><img src="'.$item->itemImage.'" width="300" height="400"></div>';
	
	echo '<form id="itemForm" name="addCart" action="cart.php" method="post" onsubmit="return CheckQty();">
		<input type="hidden" name="txtItemId" id="txtItemId" value='.$item->itemId.' readonly /><br />';
		
	echo '<h2>'.$item->itemName.'</h2>';
	echo '<p>Category: '.$item->categoryName.'</p>';
	echo '<div><p>$ '.$item->itemPrice.'</p>';
	echo '<p>'.$item->description.'</p></div>';
	
	if ((int)$item->onHand == 0)
		echo "Sold Out";
	else
	{
		echo 'Quantity: <input type="number" name="numQty" id="numQty" value="0" step="1" min="0" max="'.$row['onHand'].'" /><br />';
		if (isset($_SESSION['userId']) && isset($_SESSION['userName']))
			echo "<input id='add' class='submit' type='submit' name='submit' value='Add' />";
		else
			echo "<input id='add' class='submit' type='button' name='submit' value='Add' onclick='LoginAlert();' />";
		echo '<div id="message"></div>';
	}

	echo '</form>';

	require_once('lib/footer.php');
		
	?>
