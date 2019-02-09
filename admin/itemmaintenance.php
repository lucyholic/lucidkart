<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	// title setting
    $title = "::LUCIDKART:: - Item Maintenatnce";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	
	require_once('lib/adminmenu.php');

	if (isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
		$message = "";	

	
	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = mysqli_real_escape_string($conn, $_GET['search']);
		$sql = "SELECT itemId FROM item WHERE itemName LIKE '%".$keyword."%'";
		$result = mysqli_query($conn, $sql);
		
		if ($result -> num_rows == 0)
		{
			$message = "No item found";
			$result = mysqli_query($conn, "SELECT itemId FROM item");
		}
	}

	else if (isset($_GET['latestOnly']))
	{
		$latestSql = "SELECT itemId FROM item WHERE latestCollection != 0";
		$result = mysqli_query($conn, $latestSql);
	}

	else if (isset($_GET['reset']))
	{
		$resetSql = "UPDATE item SET latestCollection = 0";
		mysqli_query($conn, $resetSql);
		$result = mysqli_query($conn, "SELECT * FROM item");
	}

	else
		$result = mysqli_query($conn, "SELECT itemId FROM item");

	echo "<span style='color: red; font-weight: bold'>$message</span>";
?>

	<h2>Item Maintenance</h2>
	<p><a href="itemupload.php">Add a new Item</a></p>
	<form name="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
		<input type="text" name="search" id="search" placeholder="Search Item..">
		<input type="submit" value="Search">
	</form>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
		<input type="submit" name="latestOnly" value="Show Latest Collection" />
		<input type="submit" name="reset" value="Reset Latest Collection" />
	</form>
	<br />
	<table>
		<tr>
			<th>Item Id</th>
			<th>Item Image</th>
			<th>Item Name</th>
			<th>Item Price</th>
			<th></th>
		</tr>

<?php

	// list of items

	while($row = mysqli_fetch_assoc($result))
	{
		$item = new Item();
		$item = $item->GetItem($row['itemId']);

		// string variables for deletion
		$alert = '"Delete item '.$item->itemName.'?"';
		$delete = '"itemdelete.php?itemid='.$item->itemId.'"';
		
		echo "<tr>
			<td>".$item->itemId."</td>
			<td><img src='../".$item->itemImage."' width='60' height='80'></td>
			<td>".$item->itemName."</td>
			<td>$".$item->itemPrice."</td>
			<td><a href='itemdetail.php?itemid=".$item->itemId."'>Detail</a> 
			<a href='itemedit.php?itemid=".$item->itemId."'>Edit</a> 
			<a href='javascript:if(confirm(".$alert.")) document.location.href=".$delete."'>Delete</a></td>
			</tr>";
	}
	
	echo '</table>';

	require_once('../lib/footer.php');

?>