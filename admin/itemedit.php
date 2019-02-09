<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	// title setting
    $title = "::LUCIDKART:: - Edit";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');

	$error = "";
	$item = new Item();
	$item = $item->GetItem();
	
	// If the form is sutmitted, update database
	if (isset($_POST['edit']))
	{
		$item = new Item();

		$item->itemName = mysqli_real_escape($conn, $_POST['txtItemName']);
		$item->itemCategory = mysqli_real_escape($conn, (int)$_POST['lstItemCategory']);
		$item->itemPrice = mysqli_real_escape($conn, (float)$_POST['txtItemPrice']);
		$item->itemPrice = number_format($itemPrice, 2);
		$item->description = mysqli_real_escape($conn, $_POST['txtDescription']);
		$item->description = str_replace(array("\r\n", "\n", "\r"), '<br />', $description);
		$item->latestItem = isset($_POST['chkLatest']);
		

		$itemId = $_POST['numItemId'];
		$itemName = $_POST['txtItemName'];
		$itemCategory = (int)$_POST['lstItemCategory'];
		$itemPrice = (float)$_POST['txtItemPrice'];
		$itemPrice = number_format($itemPrice, 2);
		$description = $_POST['txtDescription'];
		$description = str_replace(array("\r\n", "\n", "\r"), '<br />', $description);
		$latestItem = isset($_POST['chkLatest']);

		if (!empty($_FILES['imgItemImage']))
		{
			$upload_dir = 'images/';
			$uploaded_file = $upload_dir . basename($_FILES['imgItemImage']['name']);
				
			if (move_uploaded_file($_FILES['imgItemImage']['tmp_name'], $uploaded_file))
			{
				$itemImage = $uploaded_file;
				mysqli_query($conn, "UPDATE item SET itemImage='".$itemImage."' WHERE itemId='".$itemId."'");
			}
			
			else
			{
				$error = $_FILES['imgItemImage']['error'];
			}
			
		}
		
		$sql = "UPDATE item SET 
		    itemName='".$itemName."', 
		    itemCategory='".$itemCategory."', 
		    itemPrice='".$itemPrice."', 
		    description='".$description."', 
		    latestCollection='".$latestItem."' 
		    WHERE itemId='".$itemId."'";
		$result = mysqli_query($conn, $sql);
		
		$_SESSION['message'] = "Item updated";
		echo '<script>window.location="itemmaintenance.php</script>';
		
	}
	
	// Check if item id is passed
	// if not, redirect to item maintenance page
	if(empty($_GET['itemid']) || !isset($itemId))
		echo '<script>window.location="itemmaintenance.php"</script>';
	
	$itemId = $_GET['itemid'];
	
	$sql = "SELECT * FROM item WHERE itemId=".$itemId;
	$result = mysqli_query($conn, $sql);
	
	// Check if passed id value exists on DB
	// if not, redirect to item maintenance page
	if ($result -> num_rows == 0)
		echo '<script>window.location="itemmaintenance.php"</script>';
	
	$row = mysqli_fetch_assoc($result);
	$row['description'] = str_replace('<br />', "\n", $row['description']);

	if ($row['latestCollection'] == 0)
		$checked = "";
	else
		$checked = "checked";

	echo '<span style="color: red; font-weight: bold">'.$error.'</span>';
	
?>

<form name="itemedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Item();" enctype="multipart/form-data">
<input type="hidden" name="numItemId" id="numItemId" value=<?= $row['itemId'] ?> readonly>
Item Name: <input type="text" name="txtItemName" id="txtItemName" value="<?= $row['itemName'] ?>"><br />
Item Category: <select name="lstItemCategory" id="lstItemCategory">
	<option value="" disabled>Select Category</option>

<?php
	$selectBox = mysqli_query($conn, "SELECT * FROM category ORDER BY categoryName");

	while($option = mysqli_fetch_assoc($selectBox))
	{
		if ($option['categoryId'] == $row['itemCategory'])
			echo "<option value='".$option['categoryId']."' selected='selected'>".$option['categoryName']."</option>";
		else
			echo "<option value='".$option['categoryId']."'>".$option['categoryName']."</option>";
	}
?>
	</select><br />

Item Price: <input type="text" name="txtItemPrice" id="txtItemPrice" value="<?= $row['itemPrice'] ?>"><br />
Item Thumbnail: <input type="hidden" name="MAX_FILE_SIZE" value="3145728" />
<input type="file" accept="image/*" name="imgItemImage" id="imgItemImage" onchange="CheckImage();"/><br />
<img src='../<?= $row['itemImage'] ?>' width="300" height="400"><br />
Item Description: <textarea name="txtDescription" id="txtDescription"><?= $row['description'] ?></textarea><br />
Latest Item: <input type="checkbox" name="chkLatest" id="chkLatest" <?= $checked ?> /><br />
<input type="submit" name="edit" value="Save">
<input type="reset" value="Reset">
<input type="button" value="Cancel" onclick="history.back(-1);">

</form>
		
<?php

	require_once('../lib/footer.php');

?>