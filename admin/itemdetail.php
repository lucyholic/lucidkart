<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	require_once('../class/item.php');
	
	// title setting
    $title = "::LUCIDKART:: - Item Detail";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');
	
	if(empty($_GET['itemid']))
		header('Location: itemmaintenance.php');		
		
	$itemId = mysqli_real_escape_string($conn, $_GET['itemid']);

	try
	{
		$item = new Item();
		$item = $item->GetItem($itemId);

		if($item->latestCollection == 0)
			$checked = "";
		else
			$checked = "checked";

		echo '<h2>'.$item->itemName.'</h2>';
		echo '<p>Category: '.$item->categoryName.'</p>';
		echo '<p><img src="../'.$item->itemImage.'" width="300" height="400"></p>';
		echo '<p>$ '.$item->itemPrice.'</p>';
		echo '<p>'.$item->description.'</p>';
		echo '<p>Latest Item: <input type="checkbox" '.$checked.' readonly /></p>';
		echo '<a href="itemmaintenance.php">Go back to Item Maintenance Page</a>';

	}
	
	catch(Exception $ex)
	{
		echo '<script>window.location="../notfound.php"</script>';
	}

	
	require_once('../lib/footer.php');

?>