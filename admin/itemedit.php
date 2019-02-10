<?php
	require_once('lib/header.php');		
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	// title setting
    $title = "::LUCIDKART:: - Edit";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/item.css">';
	
	require_once('lib/adminmenu.php');

	// Check if item id is passed
	// if not, redirect to item maintenance page
	if(!isset($_GET['itemid']))
	{
		$_SESSION['message'] = "No item found";
		echo '<script>window.location="itemmaintenance.php"</script>';
	}
	
	$itemId = mysqli_real_escape_string($conn, $_GET['itemid']);
	$message = "";

	try
	{
		$item = new Item();
		$item = $item->GetItem($itemId);

		if($item->latestCollection == 0)
			$checked = "";
		else
			$checked = "checked";
	}
	catch(Exception $ex)
	{
		$_SESSION['message'] = $ex->getMessage();
		echo '<script>window.location="itemmaintenance.php"</script>';
	}

	// If the form is sutmitted, update database
	if (isset($_POST['edit']))
	{
		try
		{
			$item = new Item();

			$item->itemId = $_POST['numItemId'];
			$item->itemName = mysqli_real_escape_string($conn, $_POST['txtItemName']);
			$item->itemCategory = mysqli_real_escape_string($conn, $_POST['lstItemCategory']);
			$item->itemPrice = mysqli_real_escape_string($conn, $_POST['txtItemPrice']);
			$item->description = mysqli_real_escape_string($conn, $_POST['txtDescription']);
			$item->latestCollection = isset($_POST['chkLatest']);

			if($_POST['imgItemImage'] != "")
			{
				$uploaded_file = '../images/' . basename($_FILES['imgItemImage']['name']);
			
				if (move_uploaded_file($_FILES['imgItemImage']['tmp_name'], $uploaded_file))
				{
					$item->itemImage = 'images/'.basename($_FILES['imgItemImage']['name']);
				}
				else
				{
					throw new Exception($_FILES['imgItemImage']['error']);
				}
			}
			
			if(Validate::ValidateItem($item, false))
			{
				$item->EditItem();
				
				$_SESSION['message'] = "Item ".$item->itemName." edited";
				echo "<script>window.location='itemmaintenance.php';</script>";
			}
		}

		catch (Exception $ex) 
		{
			$_SESSION['message'] = $ex->getMessage();
		}
		
	}
	
	echo '<div id="message">';

	if($message != "")
		echo "<div class='alert alert-danger' role='alert'>$message</div>";	

    echo  '</div>';
	
?>

<form name="itemedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Item();" enctype="multipart/form-data">
<input type="hidden" name="numItemId" id="numItemId" value=<?= $item->itemId ?> readonly>
Item Name: <input type="text" name="txtItemName" id="txtItemName" value="<?= $item->itemName?>"><br />
Item Category: <select name="lstItemCategory" id="lstItemCategory">
	<option value="" disabled>Select Category</option>

<?php
	$selectBox = mysqli_query($conn, "SELECT * FROM category ORDER BY categoryName");

	while($option = mysqli_fetch_assoc($selectBox))
	{
		if ($option['categoryId'] == $item->itemCategory)
			echo "<option value='".$option['categoryId']."' selected='selected'>".$option['categoryName']."</option>";
		else
			echo "<option value='".$option['categoryId']."'>".$option['categoryName']."</option>";
	}
?>
	</select><br />

Item Price: <input type="text" name="txtItemPrice" id="txtItemPrice" value="<?= $item->itemPrice ?>"><br />
Item Thumbnail: <input type="hidden" name="MAX_FILE_SIZE" value="3145728" />
<input type="file" accept="image/*" name="imgItemImage" id="imgItemImage" onchange="CheckImage();"/><br />
<img src='../<?= $item->itemImage ?>' width="300" height="400"><br />
Item Description: <textarea name="txtDescription" id="txtDescription"><?= $item->description ?></textarea><br />
Latest Item: <input type="checkbox" name="chkLatest" id="chkLatest" <?= $checked ?> /><br />
<input type="submit" name="edit" value="Save">
<input type="button" value="Cancel" onclick="history.back(-1);">

</form>
		
<?php

	require_once('../lib/footer.php');

?>