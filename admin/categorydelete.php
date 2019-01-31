<?php
/*

Delete category if it is empty

*/

	require_once('lib/header.php');
	require_once('lib/authentication.php');
	
	// if parameter is empty,
	// display error message and redirect to categorymaintenance page
	if(empty($_GET['id']))
	{
		$_SESSION['message'] = "Invalid access";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}
	
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	
	$sql = "SELECT 0 FROM category WHERE categoryId='".$id."'";
	$result = mysqli_query($conn, $sql);
	
	// if id is invalid,
	// pass error message to category maintenance page
	if(mysqli_num_rows($result) == 0)
	{
		$_SESSION['message'] = "No item found.";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}

	$check = "SELECT 0 FROM item WHERE itemCategory='".$id."'";
    $result = mysqli_query($conn, $check);
	
	// if category is not empty,
	// pass error message to category maintenance page
    if(mysqli_num_rows($result) != 0)
	{
		$_SESSION['message'] = "Category cannot be deleted: Items exist";
		echo "<script>window.location='categorymaintenance.php';</script>";
	}
	
	// execute delete and pass message to category maintenance page
	else
	{
		$sql = "DELETE FROM category WHERE categoryId='".$id."'";
		$result = mysqli_query($conn, $sql);
		$_SESSION['message'] = "Category deleted";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}
?>