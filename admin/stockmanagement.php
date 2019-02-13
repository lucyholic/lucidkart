<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');

	// title setting
    $title = "::LUCIDKART:: - Stock management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/admin/adminSubpages.css">';
	
	require_once('lib/adminmenu.php');

	$message = "";
	$count = 0;
	
	if(isset($_POST['update']))
	{
		$numCount = $_POST['count'];

		for($i = 0; $i < $numCount; $i++)
		{
			$tempId = "txtItemId".($i + 1);
			$tempOnHand = "txtOnHand".($i + 1);
			$id = $_POST[$tempId];
			$onHand = $_POST[$tempOnHand];
			$sql = "UPDATE item SET onHand='".$onHand."' WHERE itemId='".$id."'";
			mysqli_query($conn, $sql);
		}

		$message = "Stock Updated";
	}

	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = mysqli_real_escape_string($conn, $_GET['search']);
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

<?php
	echo "<span style='color: red; font-weight: bold'>$message</span>";
?>

<form name="searchform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
	<input type="text" name="search" id="search" placeholder="Search Item..">
	<input type="submit" value="Search">
</form>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<table class="reflow">
	<tr>
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
		<input type="submit" name="update" value="update" /><form><br />';

	require_once('../lib/footer.php');
?>

<!--table reflow-->
<script>
	$('table.reflow').find('th').each(function(index, value){

		var $this = $(this),
		title = '<b class="cell-label">' + $this.html() + '</b>';

		// add titles to cells
		$('table.reflow')
		.find('tr').find('td:eq('+index+')').wrapInner('<span class="cell-content"></span>').prepend( title );
	});
</script>