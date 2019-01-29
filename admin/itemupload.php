<?php
	require_once('lib/header.php');	
	require_once('lib/authentication.php');

	// title setting
    $title = "::LUCIDKART:: - Item Upload";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');

	if (isset($_POST['upload']))
	{
		$itemName = mysqli_real_escape($conn, $_POST['txtItemName']);
		$itemCategory = mysqli_real_escape($conn, (int)$_POST['lstItemCategory']);
		$itemPrice = mysqli_real_escape($conn, (float)$_POST['txtItemPrice']);
		$itemPrice = number_format($itemPrice, 2);
		$description = mysqli_real_escape($conn, $_POST['txtDescription']);
		$description = str_replace(array("\r\n", "\n", "\r"), '<br />', $description);
		$latestItem = isset($_POST['chkLatest']);
		
		$upload_dir = '../images/';
		$uploaded_file = $upload_dir . basename($_FILES['imgItemImage']['name']);
			
		if (move_uploaded_file($_FILES['imgItemImage']['tmp_name'], $uploaded_file))
		{
			$itemImage = 'images/'.basename($_FILES['imgItemImage']['name']);
			
			$sql = "INSERT INTO item (itemName, 
			itemCategory,
			itemPrice,
			itemImage, 
			description,
			latestItem) VALUES('".		
			$itemName."', '".
			$itemCategory."', '".
			$itemPrice."', '".
			$itemImage."', '".
			$description."', '".
			$latestItem."')";
			
			$result = mysqli_query($conn, $sql);
			
			$_SESSION['message'] = "Item added";
			echo "<script>window.location='itemmaintenance.php';</script>";
		}
		
		else
		{
			$_SESSION['message'] = $_FILES['imgItemImage']['error'];
			echo "window.location='itemmaintenance.php'";
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