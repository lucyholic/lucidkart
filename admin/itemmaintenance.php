<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	
	// title setting
    $title = "::LUCIDKART:: - Item Maintenatnce";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	
	require_once('lib/adminmenu.php');
	
	
	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = $_GET['search'];
		$sql = "SELECT * FROM item WHERE itemName LIKE '%".$keyword."%'";
		$result = mysqli_query($conn, $sql);
		
		if ($result -> num_rows == 0)
		{
			echo "<script>alert('No item found');</script>";
			$result = mysqli_query($conn, "SELECT * FROM item");
		}
	}

	else
		$result = mysqli_query($conn, "SELECT * FROM item");
	

	if (isset($_GET['latestOnly']))
	{
		$latestSql = "SELECT * FROM item WHERE latestCollection != 0";
		$result = mysqli_query($conn, $latestSql);
	}

	if (isset($_GET['reset']))
	{
		$resetSql = "UPDATE item SET latestCollection = 0";
		mysqli_query($conn, $resetSql);
		$result = mysqli_query($conn, "SELECT * FROM item");
	}
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Item Maintenance Page</title>
		<meta charset="utf-8">
		<script src="js/validate.js"></script>
		<!--<link rel="stylesheet" href="../css/cart.css">-->
	</head>
	
	<body>
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
		while($row = mysqli_fetch_assoc($result))
			{
				// string variables for deletion
				$message = '"Delete item '.$row['itemName'].'?"';
				$delete = '"itemdelete.php?itemid='.$row['itemId'].'"';
				
				echo "<tr>
					<td>".$row['itemId']."</td>
					<td><img src='../".$row['itemImage']."' width='60' height='80'></td>
					<td>".$row['itemName']."</td>
					<td>$".$row['itemPrice']."</td>
					<td><a href='itemdetail.php?itemid=".$row['itemId']."'>Detail</a> 
					<a href='itemedit.php?itemid=".$row['itemId']."'>Edit</a> 
					<a href='javascript:if(confirm(".$message.")) document.location.href=".$delete."'>Delete</a></td>
					</tr>";
			}
	?>
	
	</table>
		
	</body>
</html>
	
<?php

	require_once('../lib/footer.php');

?>