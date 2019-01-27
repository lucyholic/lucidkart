<?php
	require_once('lib/header.php');	
	
	// title setting
    $title = "::LUCIDKART:: - Stock management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	
	require_once('lib/menu.php');

	$message = "";
	$count = 0;
	
	if(isset($_POST['update']))
	{
		$numCount= $_POST['count'];
		echo '<script>console.log("count: '.$numCount.'");</script>';
		for($i = 0; $i < $numCount; $i++)
		{
			$tempId = "txtItemId".($i + 1);
			$tempOnHand = "txtOnHand".($i + 1);
			$id = $_POST[$tempId];
			$onHand = $_POST[$tempOnHand];
			echo '<script>console.log("ID: '.$id.'")</script>';
			$sql = "UPDATE item SET onHand='".$onHand."' WHERE itemId='".$id."'";
			mysqli_query($conn, $sql);
		}

		$message = "Stock Updated";
	}

	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = $_GET['search'];
		$sql = "SELECT * FROM item WHERE itemName LIKE '%".$keyword."%'";
		$result = mysqli_query($conn, $sql);
		
		if ($result -> num_rows == 0)
		{
			$message = 'No item found';
			$result = mysqli_query($conn, "SELECT * FROM item");
		}
	}

	else
	{
		$sql = "SELECT itemId, itemName, onHand FROM item";
		$result = mysqli_query($conn, $sql);
	}
	
?>

<h2>Stock Management</h2>
<font color=red><strong><?= $message ?></strong></font>

<form name="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	<input type="text" name="search" id="search" placeholder="Search Item..">
	<input type="submit" value="Search">
</form>

<table><tr>
	<th>Item ID</th>
	<th>Item Name</th>
	<th>On Hand</th>
	</tr>


<?php
	
	while($row = mysqli_fetch_assoc($result))
	{
		$count++;
		$itemId = "txtItemId".$count;
		$stockOnHand = "txtOnHand".$count;
		$inputText = "<input type='hidden' name='$itemId' id='$itemId' value='".$row['itemId']."' />
			<input type='number' name='$stockOnHand' id='$stockOnHand' value='".$row['onHand']."' />";
		
		echo '<tr>
			<td>'.$row['itemId'].'</td>
			<td>'.$row['itemName'].'</td>
			<td>'.$inputText.'</td></tr>';
	}
	
	echo '</table>
		<input type="hidden" name="count" id="count" value="'.$count.'" />
		<input type="submit" name="update" value="update" /><form>';
?>