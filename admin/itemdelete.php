<?php
	require_once('lib/header.php');
	
	if(empty($_GET['itemid']))
		echo "<script>window.location='notfound.php'</script>";
	
	$id = $_GET['itemid'];
	
	$sql = "SELECT * FROM item WHERE itemId=".$id;
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
		echo "<script>window.location='itemmaintenance.php'</script>";
	
	$row = mysqli_fetch_assoc($result);
	
	$img_path = "../".$row['itemImage'];
	unlink($img_path);	
	$sql = "DELETE FROM item WHERE itemId='".$id."'";
	$result = mysqli_query($conn, $sql);

	echo "<script>window.location='itemmaintenance.php'</script>";
?>