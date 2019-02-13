<?php
	require_once('lib/header.php');	
	require_once('lib/authentication.php');
	require_once('../class/item.php');

	if(empty($_GET['itemid']))
	{
		$_SESSION['message'] = "Delete error: Invalid access";
		echo "<script>window.location='itemmaintenance.php'</script>";
	}
	
	$id = mysqli_real_escape_string($conn, $_GET['itemid']);

	try
	{
		$item = new Item();
		$item = $item->GetItem($id);

		$item->DeleteItem();
		echo "<script>window.location='itemmaintenance.php'</script>";
	}

	catch(Exception $ex)
	{
		$_SESSION['message'] = "Error in Delete: ".$ex->getMessage();
		echo "<script>window.location='itemmaintenance.php'</script>";
	}

	
?>