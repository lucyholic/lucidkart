<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	
	// title setting
    $title = "::LUCIDKART:: - Item Detail";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');
	
	if(empty($_GET['itemid']))
		header('Location: itemmaintenance.php');		
		
	$id = $_GET['itemid'];
	
	$sql = "SELECT * FROM item LEFT JOIN category ON item.itemCategory = category.categoryId WHERE itemId=".$id;
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
		header('Location: ../notfound.php');
	
	$row = mysqli_fetch_assoc($result);

	if ($row['latestCollection'] == 0)
		$checked = "";
	else
		$checked = "checked";
	
	echo '<h2>'.$row['itemName'].'</h2>';
	echo '<p>Category: '.$row['categoryName'].'</p>';
	echo '<p><img src="../'.$row['itemImage'].'" width="300" height="400"></p>';
	echo '<p>$ '.$row['itemPrice'].'</p>';
	echo '<p>'.$row['description'].'</p>';
	echo '<p>Latest Item: <input type="checkbox" '.$checked.' readonly /></p>';
	echo '<a href="itemmaintenance.php">Go back to Item Maintenance Page</a>';
		
	require_once('../lib/footer.php');

?>