<?php
/*

Delete category if it is empty

*/

	require_once('lib/header.php');
	require_once('lib/authentication.php');
	require_once('../class/category.php');
	
	// if parameter is empty,
	// display error message and redirect to categorymaintenance page
	if(empty($_GET['id']))
	{
		$_SESSION['message'] = "Invalid access";
		echo "<script>window.location='categorymaintenance.php'</script>";
	}

	$id = mysqli_real_escape_string($conn, $_GET['id']);
	
	try
	{
		$c = new Category();
		$c = $c->GetCategory($id);
		
		$c->DeleteCategory();
	}

	catch (Exception $ex)
	{
		$_SESSION['message'] = $ex;
	}

	echo "<script>window.location='categorymaintenance.php'</script>";

?>