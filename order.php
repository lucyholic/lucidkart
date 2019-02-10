<?php
	require_once('lib/php_header.php');
	
	if (!isset($_SESSION['userId']) && !isset($_SESSION['userName']))
	{
		echo '<script>alert("Log in first");
			window.location = "index.php"</script>';
	}
	
	else if (!isset($_SESSION['items']) || $_SESSION['items'] == null)
	{
		$_SESSION['message'] = "Cart is empty!";
		echo '<script>window.location = "cart.php"</script>';
	}
	
	$sql = "SELECT * FROM customer WHERE customerId=".$_SESSION['userId'];
	$result = mysqli_query($conn, $sql);
	
	if ($result -> num_rows == 0)
		header('Location: notfound.php');
	
	$row = mysqli_fetch_assoc($result);

	$items = $_SESSION['items'];
	$taxsql = mysqli_query($conn, "SELECT * FROM province WHERE code='".$row['province']."'");
	$taxrow = mysqli_fetch_assoc($taxsql);
	$tax = $taxrow['taxrate'];
	$total = 0;
	
	// create a string fetching province data from db
	// to create an associative array in js later
	$taxString = "";
	$taxtable = mysqli_query($conn, "SELECT * FROM province");

	while($taxrow = mysqli_fetch_assoc($taxtable))
	{
		$add = $taxrow['code'].', '.$taxrow['taxrate'].'::';
		$taxString = $taxString.$add;
	}

	// title setting
    $title = "::LUCIDKART:: - " . $_SESSION['userName'] . "'s Order";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="css/item.css">';
	
	require_once('lib/menu.php');

?>
	
<script>
function UpdateAddress()
{
	document.getElementById("txtFirstName").value = "<?= $row['firstName'] ?>";
	document.getElementById("txtLastName").value = "<?= $row['lastName'] ?>";
	document.getElementById("txtPhone").value = "<?= $row['phone'] ?>";
	document.getElementById("txtAddress").value = "<?= $row['address'] ?>";
	document.getElementById("txtCity").value = "<?= $row['city'] ?>";
	document.getElementById("txtProvince").value = "<?= $row['province'] ?>";
	document.getElementById("txtPostalCode").value = "<?= $row['postalCode']?>";
	
	document.getElementById("txtFirstName").readOnly = true;
	document.getElementById("txtLastName").readOnly = true;
	document.getElementById("txtPhone").readOnly = true;
	document.getElementById("txtAddress").readOnly = true;
	document.getElementById("txtCity").readOnly = true;
	document.getElementById("txtProvince").readOnly = true;
	document.getElementById("txtPostalCode").readOnly = true;
	
}

function ClearAddress()
{
	document.getElementById("txtFirstName").value = "";
	document.getElementById("txtLastName").value = "";
	document.getElementById("txtPhone").value = "";
	document.getElementById("txtAddress").value = "";
	document.getElementById("txtCity").value = "";
	document.getElementById("txtProvince").value = "";
	document.getElementById("txtPostalCode").value = "";
	
	document.getElementById("txtFirstName").readOnly = false;
	document.getElementById("txtLastName").readOnly = false;
	document.getElementById("txtPhone").readOnly = false;
	document.getElementById("txtAddress").readOnly = false;
	document.getElementById("txtCity").readOnly = false;
	document.getElementById("txtProvince").readOnly = false;
	document.getElementById("txtPostalCode").readOnly = false;
}
</script>	
	
<?php

	echo "<h2>Processing ".$_SESSION['userName']."'s Order</h2>";

?>

<!-- Form starts -->
<form name="orderForm" action="ordercomplete.php" method="post" onsubmit="return Validate_Order();">

	<div>
		<h3>Delivery Address</h3>
		<input type="radio" name="ad" value="1" onclick="UpdateAddress();">Existing Address<br />
		<input type="radio" name="ad" value="2" onclick="ClearAddress();">New Address<br />
		First Name: <input type="text" name="txtFirstName" id="txtFirstName" onfocusout="Trim('txtFirstName');"><br />
		Last Name: <input type="text" name="txtLastName" id="txtLastName" onfocusout="Trim('txtLastName');"><br />
		Phone Number: <input type="text" name="txtPhone" id="txtPhone" placeholder="111-222-3333" onfocusout="Trim('txtPhone');" /><br />
		Address: <input type="text" name="txtAddress" id="txtAddress" onfocusout="Trim('txtAddress');" /><br />
		City: <input type="text" name="txtCity" id="txtCity" onfocusout="Trim('txtCity');" /><br />
		Province: <select name="txtProvince" id="txtProvince" onchange="UpdateTax();">
		<option value="" disabled selected>Select province</option>
		
		<?php	
			$taxtable = mysqli_query($conn, "SELECT * FROM province");
			while($row= mysqli_fetch_assoc($taxtable))
			{
				echo '<option value="'.$row['code'].'">'.$row['name'].'</option>';
			}
		?>
		</select><br />
		
		Postal Code: <input type="text" name="txtPostalCode" id="txtPostalCode" placeholder="A1A 2B2" onfocusout="Trim('txtPostalCode');" /><br />
		
	</div>
	
	<!-- Order list div --> 
	<div>
		<h3>Order list</h3>
		<table id='tblCart' name='tblCart'>
		<tr>
			<th>Item Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Subtotal</th>
		</tr>
		
		<?php

		foreach($_SESSION['items'] as $id => $q)
		{
			$sql = "SELECT * FROM item WHERE itemId=".$id;
			$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			$subtotal = floatval($q) * $row['itemPrice'];
			$total += $subtotal;
			$key = $row['itemId'];
			
			echo "<tr>
				<td>".$row['itemName']."</td>
				<td>".$row['itemPrice']."</td>
				<td>".$q."</td>
				<td>".$subtotal."</td>			
			</tr>";
		}
		
		echo "<tr>
				<td></td>
				<td></td>
				<td>Total:</td>
				<td>".$total."</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Tax:</td>
				<td id='numTax'>".round($tax * $total, 2)."</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>GrandTotal:</td>
				<td id='numGrandTotal'>".round((1 + $tax) * $total, 2)."</td>
			</tr>";
		
		?>
		
		</table>
	</div>


	<!-- Payment method div -->
	<div>
		<h3>Payment Method</h3>
		Card Number: <input type="text" name="txtCardNumber" id="txtCardNumber" /><br />
		Card Holder: <input type="text" name="txtCardHolder" id="txtCardHolder" /><br />
		Expiry Date: <input type="text" name="txtExpiryDate" id="txtExpiryDate" /><br />
		Security Number: <input type="password" name="txtSecurityNumber" id="txtSecurityNumber" /><br />
	</div>

	<input type="submit" name="confirm" value="Confirm" /><br />
	<input type="button" value="Cancel" onClick="window.location='cart.php'" />
</form>


<script>
function UpdateTax()
{
	// create an associative array from $taxString
	// it seems like that if I knew how to manipulate ajax
	// this could've been way less compmlicated though
	var taxString = "<?= $taxString ?>";
	var tempArray = taxString.split('::');
	var taxArray = new Array();
	
	for (var i in tempArray)
	{
		var temp = tempArray[i].split(",");
		taxArray[temp[0]] = temp[1];
	}
	
	var province = document.getElementById("txtProvince").value;
	
	var taxrate = parseFloat(taxArray[province]);
	var total = parseFloat(<?= $total ?>);
	var tax = (taxrate * total).toFixed(2);
	
	document.getElementById("numTax").innerHTML = tax;
	
	document.getElementById("numGrandTotal").innerHTML = (parseFloat(total) + parseFloat(tax)).toFixed(2);
	
}
</script>

<?php
	
	require_once('lib/footer.php');

?>
	