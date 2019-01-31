<?php
	require("lib/php_header.php");
	$_SESSION['create'] = "create";
	$message = "";

	if (isset($_POST['create']))
	{
		try
		{
			$userId = mysqli_real_escape_string($conn, $_POST['txtUserId']);
			$password = mysqli_real_escape_string($conn, $_POST['txtPassword']);
			$firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
			$lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
			$phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
			$email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
			$address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
			$city = mysqli_real_escape_string($conn, $_POST['txtCity']);
			$province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
			$postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);

			
			$sql = "INSERT INTO customer (userId, 
				password, 
				firstName, 
				lastName, 
				phone, 
				email, 
				address, 
				city, 
				province, 
				postalCode) VALUES('".		
				$userId."', '".
				$password."', '".
				$firstName."', '".
				$lastName."', '".
				$phone."', '".
				$email."', '".
				$address."', '".
				$city."', '".
				$province."', '".
				$postalCode."')";
				
			$result = mysqli_query($conn, $sql);
			
			echo "<script>alert('Account Created for".$firstName." (User Id: ".$userId.")');
				window.location='login.php';</script>";
			
			echo "Account Created for $firstName (User Id: $userId)<br />
				<a href='login.php'>Log in</a>";
		}

		catch(Exception $ex)
		{
			$message = "Try again (Sign up Error: ".$this.logException($ex).")"; 
		}
	}
?>


<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Create an account page</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/create.css">		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/validate.js"></script>
	</head>
	
	<body>
		<span style="color: red; font-weight: bold"><?= $message ?></span>
	    <h1 id="logo">Lucid Kart</h1>
		<h1>Sign up</h1>
		<form name="create" action="<?= $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Create();">
			<input type="text" name="txtUserId" id="txtUserId" placeholder="User ID" onfocusout="Trim('txtUserId');" onclick="OpenIdCheck();" readonly /><br /><br />
			<input type="password" name="txtPassword" id="txtPassword" placeholder="Password" onfocusout="Trim('txtPassword');"><br /><br />
			<input type="password" name="txtPasswordCheck" id="txtPasswordCheck" placeholder="Re-enter Password" onfocusout="Trim('txtPasswordCheck');"><br /><br />
			<input type="text" name="txtFirstName" id="txtFirstName" placeholder="First Name" onfocusout="Trim('txtFirstName');">
			<input type="text" name="txtLastName" id="txtLastName" placeholder="Last Name" onfocusout="Trim(txtLastName);"><br /><br />
			<input type="text" name="txtPhone" id="txtPhone" placeholder="Phone (111-222-3333)" onfocusout="Trim(txtPhone);"><br /><br />
			<input type="text" name="txtEmail" id="txtEmail" placeholder="Email" onfocusout="Trim('txtEmail');"><br /><br />
			<input type="text" name="txtAddress" id="txtAddress" placeholder="Address" onfocusout="Trim('txtAddress');"><br /><br />
			<input type="text" name="txtCity" id="txtCity" placeholder="City" onfocusout="Trim('txtCity');">
			<input type="text" name="txtPostalCode" id="txtPostalCode" placeholder="Postal Code (A1A 2B2)" onfocusout="Trim('txtPostalCode');"><br /><br />
			<select name="txtProvince" id="txtProvince">
            	<option value="" disabled selected>Select province</option>
            	<?php 
            		$result = mysqli_query($conn, "SELECT * FROM province");
            		while($row = mysqli_fetch_assoc($result))
            		{
            			if ($row['code'] == $customerRow['province'])
            				echo '<option value="'.$row['code'].'" selected="selected">'.$row['name'].'</option>';
            			else
            				echo '<option value="'.$row['code'].'">'.$row['name'].'</option>';
            		}
            	?>
            </select><br /><br />
			<input type="submit" name="create" value="Submit" class="button">
			<input type="reset" value="Reset" class="button">
		</form>
	</body>

	<script>
	function OpenIdCheck()
	{
		window.open("idcheck.php", "", "width=400, height=300");
	}
	
	</script>
</html>