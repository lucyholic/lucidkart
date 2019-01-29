<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	$message = "";

	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}

	// when edit profile
	else if (isset($_POST['edit']))
	{
		$firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
		$lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
		$phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
		$email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
		$address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
		$city = mysqli_real_escape_string($conn, $_POST['txtCity']);
		$province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
		$postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);
		
		$editSql = "UPDATE customer SET
			firstName='".$firstName."', 
			lastName='".$lastName."', 
			phone='".$phone."',
			email='".$email."',
			address='".$address."',
			city='".$city."',
			province='".$province."',
			postalCode='".$postalCode."'
			WHERE customerId=".$_SESSION['userId'];
			
		$result = mysqli_query($conn, $editSql);
		$_SESSION['userName'] = $firstName;
		$message = "Your information is updated";
	}
	
	// sql setting
	$customerSql = "SELECT * FROM customer WHERE customerId=".$_SESSION['userId'];
	$customerResult = mysqli_query($conn, $customerSql);
	
	if ($customerResult -> num_rows ==0)
		echo "<script>alert('Error'); window.location='index.php';</script>";
	
	$customerRow = mysqli_fetch_assoc($customerResult);
	
	// title setting
    $title = "::LUCIDKART:: - ".$_SESSION['userName']."'s Profile";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents
	echo "<font color='red'><strong>$message</strong></font>";
	echo "<h2>".$_SESSION['userName']."'s Profile</h2>";
?>

<form name="profile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Create();">
	First Name: <input type="text" name="txtFirstName" id="txtFirstName" value="<?= $customerRow['firstName'] ?>" onfocusout="Trim('txtFirstName');"><br /><br />
	Last Name: <input type="text" name="txtLastName" id="txtLastName" value="<?= $customerRow['lastName'] ?>" onfocusout="Trim(txtLastName);"><br /><br />
	Phone Number: <input type="text" name="txtPhone" id="txtPhone" value="<?= $customerRow['phone'] ?>" onfocusout="Trim(txtPhone);"><br /><br />
	Email: <input type="text" name="txtEmail" id="txtEmail" value="<?= $customerRow['email'] ?>" onfocusout="Trim('txtEmail');"><br /><br />
	Address: <input type="text" name="txtAddress" id="txtAddress" value="<?= $customerRow['address'] ?>" onfocusout="Trim('txtAddress');"><br /><br />
	City: <input type="text" name="txtCity" id="txtCity" value="<?= $customerRow['city'] ?>" onfocusout="Trim('txtCity');"><br /><br />
	
	Province: <select name="txtProvince" id="txtProvince">
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
	Postal Code: <input type="text" name="txtPostalCode" id="txtPostalCode" value="<?= $customerRow['postalCode'] ?>" onfocusout="Trim('txtPostalCode');"><br /><br />
	<input type="submit" name="edit" value="Edit" class="button"><br /><br />
	<input type="button" value="Cancel" class="button" onclick="history.back(-1);">
</form>	



<?php

	// footer
	require_once('lib/footer.php');

?>
	