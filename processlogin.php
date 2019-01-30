<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
	$u = mysqli_real_escape_string($conn, $_POST['txtUserId']);
	$p = mysqli_real_escape_string($conn, $_POST['txtPassword']);
	
	$valid = "SELECT * FROM customer WHERE userId ='".$u."'";
	$result = mysqli_query($conn, $valid);
	
	if ($result -> num_rows == 1)
	{
		$row = mysqli_fetch_assoc($result);
		
		if ($row['password'] == $p)
		{
		    $_SESSION['userId'] = $row['customerId'];
			$_SESSION['userName'] = $row['firstName'];
			
			echo "<script>alert('Welcome, ".$_SESSION['userName']."!');
			    window.location='index.php';</script>";
		}
		
		else
		{
			$_SESSION['message'] = "User ID or Password is invalid";
		    echo "<script>window.location='login.php';</script>";
		}
	}
	
	else 
	{
		$_SESSION['message'] = "User ID not found";
		echo "<script>window.location='login.php';</script>";
	}

	
	// sql setting
	
	// title setting
    $title = "::LUCIDKART:: - Loggin in...";
    
    // include css
	// if it doesn't include any css other than home.css,
	// declare it as an empty string ($css = "")
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents

	// footer
	require_once('lib/footer.php');

?>