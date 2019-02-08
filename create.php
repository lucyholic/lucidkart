<?php
require("lib/php_header.php");

// class setting
require_once("class/customer.php");
require_once("class/validate.php");

// sql setting

// title setting
$title = "::LUCIDKART:: - Create an Account";
    
// include css
$css = '<link rel="stylesheet" type="text/css" href="css/login.css">';

// menu
require_once('lib/menu.php');

$message = "";
$checkedId = "";
$isChecked = false;


// if id is submitted for duplication check
if (isset($_POST['txtCheckId']))
{
    $checkedId = trim(mysqli_real_escape_string($conn, $_POST['txtCheckId']));

    if ($checkedId != "")
    {
        $sql = "SELECT 0 FROM customer WHERE userId = '".$checkedId."'";
        $result = mysqli_query($conn, $sql);

        if ($result -> num_rows == 0)
        {
            $isChecked = true;
        }

        else
        {
            $message = "ID exists: Try another ID.";
            $isChecked = false;
        }    
    }
}


// if form submitted, add customer to database
if (isset($_POST['create']))
{
    try
    {
        $customer = new Customer();

        $customer->userId = mysqli_real_escape_string($conn, $_POST['txtUserId']);
        $customer->password = mysqli_real_escape_string($conn, $_POST['txtPassword']);
        $customer->firstName = mysqli_real_escape_string($conn, $_POST['txtFirstName']);
        $customer->lastName = mysqli_real_escape_string($conn, $_POST['txtLastName']);
        $customer->phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
        $customer->email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
        $customer->address = mysqli_real_escape_string($conn, $_POST['txtAddress']);
        $customer->city = mysqli_real_escape_string($conn, $_POST['txtCity']);
        $customer->province = mysqli_real_escape_string($conn, $_POST['txtProvince']);
        $customer->postalCode = mysqli_real_escape_string($conn, $_POST['txtPostalCode']);

        if(Validate::ValidateCustomer($customer, true))
        {
            $sql = $customer->AddCustomer();
            mysqli_query($conn, $sql);

            echo "<script>alert('Account Created for".$customer->firstName." (User Id: ".$customer->userId.")');
                window.location='login.php';</script>";
        }
    }

    catch(Exception $ex)
    {
        $message = "Try again (Sign up Error: ".$ex->getMessage().")";
        echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>
            <p><a href='create.php'>Go back to Sign up page.</a></p>";
    }
}

// todo: remove alert box when message is null
// when doing if ($message!=null), the form is not being validated

    echo "<div id='message' class='alert alert-danger' role='alert'>$message</div>";	            


// If isChecked is false, display userId input only
if ($isChecked == false)
{
    ?>
    
    <form id="mainSignIn" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" onsubmit="return ID_Check();">
        <h1>Sign Up</h1>	
        <br />

        <input class="signin" type="text" name="txtCheckId" id="txtCheckId" placeholder="Enter ID" /><br /><br />
        <input class="submit" type="submit" name="idCheck" id="idCheck" value="Check User ID" /><br /><br />
    </form>

    <?php
}

// if id check passed, display rest of the form

else
{
    ?>

    <form name="create" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return Validate_Create();">
        <input type="text" name="txtUserId" id="txtUserId" placeholder="User ID" value="<?= $checkedId ?>" readonly /><br /><br />
        <input type="password" name="txtPassword" id="txtPassword" placeholder="Password" onfocusout="Trim('txtPassword');"><br /><br />
        <input type="password" name="txtPasswordCheck" id="txtPasswordCheck" placeholder="Re-enter Password" onfocusout="Trim('txtPasswordCheck');"><br /><br />
        <input type="text" name="txtFirstName" id="txtFirstName" placeholder="First Name" onfocusout="Trim('txtFirstName');">
        <input type="text" name="txtLastName" id="txtLastName" placeholder="Last Name" onfocusout="Trim('txtLastName');"><br /><br />
        <input type="text" name="txtPhone" id="txtPhone" placeholder="Phone (111-222-3333)" onfocusout="Trim('txtPhone');"><br /><br />
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
                    echo '<option value="'.$row['code'].'">'.$row['name'].'</option>';
                }
            ?>
        </select><br /><br />
        <input type="submit" name="create" value="Submit" class="button" />
        <input type="reset" value="Reset" class="button" />
    </form>

    <?php
}

require_once('lib/footer.php');

?>
