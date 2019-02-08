// Check fields for item upload and edit
function Validate_Item()
{
	var error = "";
	var itemName = document.getElementById("txtItemName").value;
	var itemCategory = document.getElementById("lstItemCategory").value;
	var itemPrice = document.getElementById("txtItemPrice").value;
	var itemImage = document.getElementById("imgItemImage").value;
	var itemDescription = document.getElementById("txtDescription").value;
	
	if (itemName === "")
		error += "Item name cannot be blank.\n";
	else if (itemName.length < 5 || itemName.length > 50)
		error += "Item name must be longer than 5 and shorter than 50 characters.\n";
	
	if (itemCategory === "")
		error += "Select Item Category.\n";
	
	if (itemPrice === "")
		error += "Item price cannot be blank.\n";
	else if (!PriceCheck(itemPrice))
		error += "Item price is not valid.\n";
	
    if (document.forms[0].name == "itemupload" && itemImage === "")
		error += "Item image is not selected.\n";
	
	if (itemDescription === "")
		error += "Item description cannot be blank.\n";
	
	if (error !== "")
	{
		alert(error);
		return false;
	}
	
	return true;
}

// Validate image
function CheckImage()
{
	var selectedFile = document.getElementById('imgItemImage').files[0];
	var error = "";
	
	if (selectedFile.type.indexOf("image") == -1)
	{
		error += "Image type is invalid.";
		document.getElementById('imgItemImage').value = "";
	}

	else if (selectedFile.size>3145728)
	{
		error += "Image size must not be greater than 3MB";
		document.getElementById('imgItemImage').value = "";
	}
	
	if (error !== "")
		alert(error);
}

// Check if price is numeric
function PriceCheck(price)
{
	var regexp = /^[0-9]*(\.[0-9]{1,2})?$/;
	var result = price.match(regexp);
	return result;
}

// Validation for new account
function Validate_Create()
{
	var error = "";
	
	var userId = document.getElementById("txtUserId").value;
	var password = document.getElementById("txtPassword").value;
	var passwordCheck = document.getElementById("txtPasswordCheck").value;
    var firstName = document.getElementById("txtFirstName").value;
    var lastName = document.getElementById("txtLastName").value;
	var phone = document.getElementById("txtPhone").value;
	var email = document.getElementById("txtEmail").value;
    var address = document.getElementById("txtAddress").value;
    var city = document.getElementById("txtCity").value;
    var province = document.getElementById("txtProvince").value;
    var postalCode = document.getElementById("txtPostalCode").value;

	
	if (userId == "")
		error += "Check ID First.\n";
	
	if (password == "")
		error += "Password cannot be blank.\n";	
	else if (password.length < 5 || password.length > 15)
		error += "Password must be between 5 and 15 characters.\n";
	
	if (password != passwordCheck)
		error += "Password is not match.\n";
	
	if (firstName == "")
		error += "First name cannot be blank.\n"; 
	
	if (lastName == "")
		error += "Last name cannot be blank.\n";
	
	if (phone == "")
		error += "Phone number cannot be blank.\n";
	else if (!Check('txtPhone'))
		error += "Enter a valid phone number. (111-222-3333)\n";
	
	if (email == "")
		error += "Email address cannot be blank.\n"; 	
	else if (!Check('txtEmail'))
		error += "Enter a valid email address.\n";
	
	if (address == "")
		error += "Street address cannot be blank.\n"; 
	
	if (city == "")
		error += "City cannot be blank.\n"; 
	
	if (province == "")
		error += "Select province.\n"; 
	
	if (postalCode == "")
		error += "Postal code cannot be blank.\n";
	else if (!Check('txtPostalCode'))
		error += "Enter a valid postal code. (ex. A1A 2B2)\n";
	
	// If there is any error
	if (error != "")
	{
		alert(error);
		return false;
	}
	
	//all clear, good to go
	else
		return true;
}

function Check(id) {
	var input = document.getElementById(id).value;
	var regexp = "";
	
	if (id == "txtPhone")
		regexp = /^\d{3}-\d{3}-\d{4}$/;
	
	else if (id == "txtEmail")
		regexp = /^[A-Za-z][A-Za-z0-9._]*@[A-Za-z][A-Za-z0-9_]*\.[A-Za-z]+$/;
	
	else if (id == "txtPostalCode")
		regexp = /^[A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]$/;
	
	else
		return false;
	
	return input.match(regexp);
}

function Trim(id)
{
	var input = document.getElementById(id).value;
	document.getElementById(id).value = input.trim();
}


function ID_Check()
{
    let id = document.getElementById('txtCheckId').value;
    let error = "";

    if(id == null || id.trim() == "")
        error = "Enter USER ID";
    
    else if (id.length < 3 || id.length > 15)
		error = "User ID must be between 3 and 15 characters.";

    if(error == "") 
        return true;

    else
    {
        document.getElementById('message').innerHTML = error;
        return false;
    }
        
}

// Check if search keyword is blank
function SearchCheck()
{
	var keyword = document.getElementById('search').value;
	
	if (keyword.trim() == "")
	{
		alert ('Enter keyword.');
		return false;
	}
	
	return true;
}

function CheckQty()
{
	var qty = document.getElementById('numQty').value;
	
	if (qty == 0)
	{
		alert('Quantity cannot be 0.');
		return false;
	}
	
	return true;
}


function Validate_Order()
{
	var error = "";
	
	var phone = document.getElementById("txtPhone").value;
    var address = document.getElementById("txtAddress").value;
    var city = document.getElementById("txtCity").value;
    var province = document.getElementById("txtProvince").value;
    var postalCode = document.getElementById("txtPostalCode").value;
	
	var cardNumber = document.getElementById("txtCardNumber").value;
	var cardHolder = document.getElementById("txtCardHolder").value;
	var expiryDate = document.getElementById("txtExpiryDate").value;
	var securityNumber = document.getElementById("txtSecurityNumber").value;
	
	if (phone == "")
		error += "Phone number cannot be blank.\n";
	else if (!Check('txtPhone'))
		error += "Enter a valid phone number. (111-222-3333)\n";
	
	if (address == "")
		error += "Street address cannot be blank.\n"; 
	
	if (city == "")
		error += "City cannot be blank.\n"; 
	
	if (province == "")
		error += "Select province.\n"; 
	
	if (postalCode == "")
		error += "Postal code cannot be blank.\n";
	else if (!Check('txtPostalCode'))
		error += "Enter a valid postal code. (ex. A1A 2B2)\n";
	
	if (cardNumber == "")
		error += "Card number cannot be blank.\n";
	
	if (cardHolder == "")
		error += "Card holder cannot be blank.\n"; 
	
	if (expiryDate == "")
		error += "Expiry date cannot be blank.\n"; 
	
	if (securityNumber == "")
		error += "Security number cannot be blank.\n"; 
	
	
	// If there is any error
	if (error != "")
	{
		alert(error);
		return false;
	}
	
	//all clear, good to go
	else
		return true;
	
}

function LoginCheck()
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
		document.getElementById("message").innerHTML =  '<span style="color: red; font-weight: bold">' + error + '</span>';
		return false;
	}
}
