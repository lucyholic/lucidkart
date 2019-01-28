<?php
	require_once('lib/header.php');
	require_once('lib/authentication.php');
	
	if(empty($_GET['id']))
		echo "<script>window.location='categorymaintenance.php'</script>";
	
	$id = $_GET['id'];
	
	$sql = "SELECT 0 FROM category WHERE categoryId='".$id."'";
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result) == 0)
		echo "<script>window.location='categorymaintenance.php'</script>";

	$check = "SELECT 0 FROM item WHERE itemCategory='".$id."'";
    $result = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($result) != 0)
	{
		echo "<script>alert('Category cannot be deleted: items exist');
			window.location='categorymaintenance.php';</script>";
	}
	
	$sql = "DELETE FROM category WHERE categoryId='".$id."'";
	$result = mysqli_query($conn, $sql);

	echo "<script>window.location='categorymaintenance.php'</script>";
?>