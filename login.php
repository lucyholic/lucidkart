<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	
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
		
	// sql setting
	$orderSql = "SELECT *";
	
	$orderResult = mysqli_query($conn, $orderSql);

	// title setting
	$title = "::LUCIDKART:: -";
		
	// include css
	$css = '<link rel="stylesheet" type="text/css" href="css/login.css">';

	// menu
	require_once('lib/menu.php');

?>

	<form id="mainSignIn" name="frmLogin" action="processlogin.php" method="post" onsubmit="return Check();">
		<h1>Sign In</h1>	
		<br />

		<?php
			if ($message != "")
			{
				echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>";	
			}
		?>

		<input class="signin" type="text" id="txtUserId" name="txtUserId" placeholder="User ID"><br /><br />
		<input class="signin" type="password" id="txtPassword" name="txtPassword" placeholder="Password"><br /><br />
		<input class="submit" type="submit" id="login" value="Login"><br /><br />

		<a href="create.php">Create a new account</a>
	</form>
		
		
	
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
			document.getElementById("message").innerHTML = '<span style="color: red; font-weight: bold">' + error + '</span>';
			return false;
		}
	}

	</script>
	
<!--footer-->
<?php require_once('lib/footer.php');?>