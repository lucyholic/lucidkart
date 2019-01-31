<?php	

    // title setting
    $title = "::LUCIDKART::";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/index.css">';
    
	require_once('lib/php_header.php');
	
	require_once('lib/menu.php');
	
	// If any item is searched
	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = mysqli_real_escape_string($conn, $_GET['search']);
		$sql = "SELECT * FROM item WHERE itemName LIKE '%".$keyword."%'";
		$result = mysqli_query($conn, $sql);
		
		if ($result -> num_rows == 0)
		{
			echo "<script>alert('No item found');</script>";
			$result = mysqli_query($conn, "SELECT * FROM item");
		}
	}
	
	// when menu bar is clicked
	else if (isset($_GET['category']))
	{
		$category = mysqli_real_escape_string($conn, $_GET['category']);
		$sql = "SELECT * FROM item WHERE itemCategory=".$category;
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_query($conn, "SELECT * FROM category WHERE categoryId=".$category) -> num_rows == 0)
			header('Location: notfound.php');
	}

	else
	{
		$result = mysqli_query($conn, "SELECT * FROM item");
		require_once('lib/homeCover.php');
	}

if (isset($_GET['category']))
    echo '<div class="itemCol" style="top:-45px">';
else
    echo '<div class="itemCol">';
	while($row = mysqli_fetch_assoc($result))
	{
		$id = $row['itemId'];
		echo '<div class="item">
				<a href="item.php?itemid='.$id.'" class="itemName">
					<div class="overlay"><div class="description">'.$row['description'].'</div></div>
					<img src="'.$row['itemImage'].'" width="300" height="400"><br />
					<p>'.$row['itemName'].'</p>
				</a>';
		
		if ($row['onHand'] != 0 )
			echo '<p class="itemPrice">$ '.$row['itemPrice'].'</p></div>';
		else
			echo '<p class="itemPrice">Sold Out</p></div>';
	}
	echo '</div';
	
	require_once('lib/footer.php');
?>