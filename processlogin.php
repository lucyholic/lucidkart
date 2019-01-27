<?php
	session_start();
	require("config/config.php");
	require("lib/db.php");
	$conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
	
	
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
		    echo "<script>alert('User ID or Password is wrong.');
			    window.location='login.php';</script>";
		}
	}
	
	else 
	{
		echo "<script>alert('User ID not found.');
			    window.location='login.php';</script>";
	}
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Loggin in...</title>
		<meta charset="utf-8">
		<!-- <link rel="stylesheet" href="style.css"> -->
		
	</head>
	
</html>