<?php
    session_start();
    if (isset($_SESSION['userId']) || isset($_SESSION['userName']))
	{
		echo "<script>alert('You already logged in.');
			window.location='index.php';</script>";
	}
	
	if (isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
		$message = "";	

?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Log in page</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		<span id="message" style="color: red; font-weight: bold"><?= $message ?></span>
		<form name="login" action="processlogin.php" method="post" onsubmit="return Check();">
			<input type="text" name="txtUserId" placeholder="User ID"><br /><br />
			<input type="password" name="txtPassword" placeholder="Password"><br /><br />
			<input type="submit" id="submit" value="Login"><br /><br />
			
		    <a href="create.php">Create a new account</a>
		</form>
		
		<h1>Sign in</h1>
		<h1 id="logo">Lucid Kart</h1>
		
	</body>
	
	<script>
	    function Check()
	    {
	        var userId = document.getElementById("txtUserId").value;
	        var password = document.getElementById("txtPassword").value;
	        
	        var error = "";
	        
	        if (userId == "")
	            error += "Enter User ID.\n";
	            
	        if (password == "")
	            error += "Enter password.\n";
	            
	        if (error == "")
	            return true;
	        else 
            {
                document.getElementById("message").innerHTML = error;
                return false;
            }
	    }
	</script>
</html>