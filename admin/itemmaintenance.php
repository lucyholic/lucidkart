<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	// title setting
    $title = "::LUCIDKART:: - Item Maintenatnce";
    
    // include css
	// $css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	$css = '<link rel="stylesheet" type="text/css" href="../css/admin/adminSubpages.css">';
	
	require_once('lib/adminmenu.php');

	
	if (isset($_GET['search']) && trim($_GET['search']) != "")
	{
		$keyword = mysqli_real_escape_string($conn, $_GET['search']);
		$sql = "SELECT * FROM item WHERE itemName LIKE '%".$keyword."%'";
		$result = mysqli_query($conn, $sql);
		
		if ($result -> num_rows == 0)
		{
			$_SESSION['message'] = "No item found";
			$result = mysqli_query($conn, "SELECT * FROM item");
		}
	}

	else if (isset($_GET['latestOnly']))
	{
		$latestSql = "SELECT * FROM item WHERE latestCollection != 0";
		$result = mysqli_query($conn, $latestSql);
	}

	else if (isset($_GET['reset']))
	{
		$resetSql = "UPDATE item SET latestCollection = 0";
		mysqli_query($conn, $resetSql);
		$result = mysqli_query($conn, "SELECT * FROM item");
	}

	else
		$result = mysqli_query($conn, "SELECT * FROM item");

	// Set message
	if (isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
		$message = "";

	if($message != "")
	{
		echo "<div id='message' class='alert alert-success' role='alert'>$message</div>";
    }

?>

	<h2>Item Maintenance</h2>
	<br />
	<form class="searchForm" name="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
		<input class="searchInput" type="text" name="search" id="search" placeholder="Search Item..">
		<input class="searchButton submit" type="submit" value="Search">
		<br><br>
	</form>
	<form class="mainForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
		<input class="white" type="submit" name="latestOnly" value="Show Latest Collection" />
		<input class="white" type="submit" name="reset" value="Reset Latest Collection" />
		<br /><br /><br />
		<a href="itemupload.php" id="addNewItem">
			Add a new Item
			<img src="../images/plus.png" height="40px" alt="plus">
		</a>
	</form>
	

	<br /><br />
	<table class="reflow">		
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
		// string variables for deletion
		$alert = '"Delete item '.$row['itemName'].'?"';
		$delete = '"itemdelete.php?itemid='.$row['itemId'].'"';
		
		echo "
		<tr>
			<td>".$row['itemId']."</td>
			<td><img src='../".$row['itemImage']."' width='60' height='80'></td>
			<td>".$row['itemName']."</td>
			<td>$".$row['itemPrice']."</td>
			<td>
				<a href='itemdetail.php?itemid=".$row['itemId']."'>Detail</a><br>
				<a href='itemedit.php?itemid=".$row['itemId']."'>Edit</a><br>
				<a href='javascript:if(confirm(".$alert.")) document.location.href=".$delete."'>Delete</a>
			</td>
		</tr>
		";
	}
	
	echo '</table>
	<br><br><br>';

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