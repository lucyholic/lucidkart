<?php
	require_once('lib/header.php');
	require_once('lib/authentication.php');
	
	if(empty($_GET['id']))
	{
		$_SESSION['message'] = "Invalid access";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}
	
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	
	$sql = "SELECT 0 FROM category WHERE categoryId='".$id."'";
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result) == 0)
	{
		$_SESSION['message'] = "No item found.";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}

	$check = "SELECT 0 FROM item WHERE itemCategory='".$id."'";
    $result = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($result) != 0)
	{
		$_SESSION['message'] = "Category cannot be deleted: Items exist";
		echo "<script>window.location='categorymaintenance.php';</script>";
	}
	
	else
	{
		$sql = "DELETE FROM category WHERE categoryId='".$id."'";
		$result = mysqli_query($conn, $sql);

		echo "<script>window.location='categorymaintenance.php'</script>";
	}
?>