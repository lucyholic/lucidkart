<?php
	// This line must be on the top
	require_once('lib/php_header.php');
	require_once('class/customer.php');

	$message = "";

	// if the page requires log in, keep below codes
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}

	// Get customer object
	$customer = new Customer();
	$customer = $customer->GetCustomer($_SESSION['userId']);


	// when edit profile
	if (isset($_POST['edit']))
	{
		try
		{
			$customer->firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
			$customer->lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
			$customer->phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
			$customer->email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
			$customer->address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
			$customer->city = mysqli_real_escape_string($conn, $_POST['txtCity']);
			$customer->province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
			$customer->postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);

			if(Validate::ValidateCustomer($customer, false))
			{
				$customer->EditCustomer();
				$_SESSION['userName'] = $customer->firstName;
				$message = "Your information is updated";
			}
		}

		catch (Exception $ex)
		{
			$message = "Try again: Error(".$ex->getMessage().")";
		}
	}

	
	// title setting
    $title = "::LUCIDKART:: - ".$_SESSION['userName']."'s Profile";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	// menu
	require_once('lib/menu.php');
	
	// body contents
	if ($message != "")
	{
		echo "<div id='message' class='alert alert-success' role='alert'>$message</div>";
	}

	echo "<h2>".$_SESSION['userName']."'s Profile</h2>";
?>

<form name="profile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return Validate_Create();">
	First Name: <input type="text" name="txtFirstName" id="txtFirstName" value="<?= $customer->firstName ?>" onfocusout="Trim('txtFirstName');"><br /><br />
	Last Name: <input type="text" name="txtLastName" id="txtLastName" value="<?= $customer->lastName ?>" onfocusout="Trim('txtLastName');"><br /><br />
	Phone Number: <input type="text" name="txtPhone" id="txtPhone" value="<?= $customer->phone ?>" onfocusout="Trim('txtPhone');"><br /><br />
	Email: <input type="text" name="txtEmail" id="txtEmail" value="<?= $customer->email ?>" onfocusout="Trim('txtEmail');"><br /><br />
	Address: <input type="text" name="txtAddress" id="txtAddress" value="<?= $customer->address ?>" onfocusout="Trim('txtAddress');"><br /><br />
	City: <input type="text" name="txtCity" id="txtCity" value="<?= $customer->city ?>" onfocusout="Trim('txtCity');"><br /><br />
	
	Province: <select name="txtProvince" id="txtProvince">
	<option value="" disabled selected>Select province</option>
	<?php 
		$result = mysqli_query($conn, "SELECT * FROM province");
		while($row = mysqli_fetch_assoc($result))
		{
			if ($row['code'] == $customer->province)
				echo '<option value="'.$row['code'].'" selected="selected">'.$row['name'].'</option>';
			else
				echo '<option value="'.$row['code'].'">'.$row['name'].'</option>';
		}
	?>
	</select><br /><br />
	Postal Code: <input type="text" name="txtPostalCode" id="txtPostalCode" value="<?= $customer->postalCode ?>" onfocusout="Trim('txtPostalCode');"><br /><br />
	<input type="submit" name="edit" value="Edit" class="button"><br /><br />
	<input type="button" value="Cancel" class="button" onclick="history.back(-1);">
</form>	


<?php

	// footer
	require_once('lib/footer.php');

?>
	