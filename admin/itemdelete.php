<?php
	require_once('lib/header.php');	
	require_once('lib/authentication.php');

	if(empty($_GET['itemid']))
	{
		$_SESSION['message'] = "Invalid access";
		echo "<script>window.location='notfound.php'</script>";
	}
	
	$id = mysqli_real_escape_string($conn, $_GET['itemid']);
	
	$sql = "SELECT 0 FROM item WHERE itemId=".$id;
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
	{
		$_SESSION['message'] = "No item found";
		echo "<script>window.location='itemmaintenance.php'</script>";
	}
	
	$row = mysqli_fetch_assoc($result);
	
	// delete img file
	$img_path = "../".$row['itemImage'];
	unlink($img_path);	
	$sql = "DELETE FROM item WHERE itemId='".$id."'";
	$result = mysqli_query($conn, $sql);

	$_SESSION['message'] = "Item deleted";
	echo "<script>window.location='itemmaintenance.php'</script>";
?>