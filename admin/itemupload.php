<?php
	require_once('lib/header.php');	
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	// title setting
    $title = "::LUCIDKART:: - Item Upload";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');

	if (isset($_POST['upload']))
	{
		try
		{
			$item = new Item();

			$item->itemName = mysqli_real_escape($conn, $_POST['txtItemName']);
			$item->itemCategory = mysqli_real_escape($conn, (int)$_POST['lstItemCategory']);
			$item->itemPrice = mysqli_real_escape($conn, (float)$_POST['txtItemPrice']);
			$item->itemPrice = number_format($itemPrice, 2);
			$item->description = mysqli_real_escape($conn, $_POST['txtDescription']);
			$item->description = str_replace(array("\r\n", "\n", "\r"), '<br />', $description);
			$item->latestItem = isset($_POST['chkLatest']);
			
			$item->AddItem();
				
			$_SESSION['message'] = "Item added";
			echo "<script>window.location='itemmaintenance.php';</script>";
		}

		catch (Exception $ex)
		{
			$_SESSION['message'] = $ex->getMessage();
			echo "<script>window.location='itemmaintenance.php';</script>";
		}

	}
	
?>

<form name="itemupload" action="<?= $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Item();" enctype="multipart/form-data">

	Item Name: <input type="text" name="txtItemName" id="txtItemName" onfocusout="Trim('txtItemName');"><br />
	Item Category: <select name="lstItemCategory" id="lstItemCategory">
		<option value="" disabled selected>Select Category</option>
	
	<?php
		$selectBox = mysqli_query($conn, "SELECT * FROM category ORDER BY categoryName");
	
		while($row = mysqli_fetch_assoc($selectBox))
		{
			echo "<option value='".$row['categoryId']."'>".$row['categoryName']."</option>";
		}
	?>
		</select><br />

	Item Price: <input type="text" name="txtItemPrice" id="txtItemPrice" onfocusout="Trim('txtItemPrice');"><br />
	Item Thumbnail: <input type="hidden" name="MAX_FILE_SIZE" value="3145728" />
	<input type="file" accept="image/*" name="imgItemImage" id="imgItemImage" onchange="CheckImage();"/><br />
	Item Description: <textarea name="txtDescription" id="txtDescription"></textarea><br />
	Latest Item: <input type="checkbox" name="chkLatest" id="chkLatest" checked /><br />
	<input type="submit" name="upload" value="Submit">
	<input type="reset" value="Reset">
	<input type="button" value="Cancel" onclick="history.back(-1);">

</form>

<?php

require_once('../lib/footer.php');

?>