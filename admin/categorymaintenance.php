<?php
	require_once('lib/header.php');	
	require_once('lib/authentication.php');
	
	// title setting
    $title = "::LUCIDKART:: - Item Detail";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
	
	require_once('lib/adminmenu.php');
    
    // set message
    if (isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
	else
		$message = "";	

    // if update is executed, check if the name is duplicated
    if(isset($_POST['update']))
    {
        $id = mysqli_real_escape_string($conn, $_POST['txtId']);
        $name = mysqli_real_escape_string($conn, $_POST['txtName']);

        $search = "SELECT 0 FROM category WHERE categoryName = '".$name."'";
        $result = mysqli_query($conn, $search);
        
        if(mysqli_num_rows($result) != 0)
        {
            $message = "Category cannot be updated: name already exists";
        }

        else
        {
            $update = mysqli_query($conn, "UPDATE category SET categoryName='".$name."' WHERE categoryId = '".$id."'");
            $message = "Category name Updated";
        }
    }

    if(isset($_POST['add']))
    {
        $name = $_POST['txtName'];
        
        $search = "SELECT 0 FROM category WHERE categoryName = '".$name."'";
        $result = mysqli_query($conn, $search);
        
        if(mysqli_num_rows($result) != 0)
        {
            $message = "Category cannot be added: name already exists";
        }

        else
        { 
            $add = mysqli_query($conn, "INSERT INTO category (categoryName) VALUES ('$name')");
            $message = "Category added";
        }
    }
?>

<span style="color: red; font-weight: bold"><?= $message ?></span>
<h2>Category Maintenance</h2>

<table>
    <tr>
        <th>Category Name</th>
        <th>Delete</th>
    </tr>

<?php
    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result))
    {
        $confirm = '"Delete Category '.$row['categoryName'].'?"';
        $delete = '"categorydelete.php?id='.$row['categoryId'].'"';

        // form that passes category id as hidden and category name
        $form = '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
        <input type="hidden" name="txtId" id="txtId" value="'.$row['categoryId'].'" />
        <input type="text" name="txtName" id="txtName" value="'.$row['categoryName'].'" />
        <input type="submit" name="update" value="Update" />
        </form>';
        
        // link to delete the category
        echo "<tr>
            <td>$form</td>
            <td><a href='javascript:if(confirm(".$confirm.")) document.location.href=".$delete."'>Delete</a></td>
            </tr>";
    }

?>

</table>

<!-- Div for a form for new category -->
<div id="add">
</div>

<input type="button" value="Add a Category" onclick="AddCategory();" />

<script>
// add a div for new category dynamically
function AddCategory()
{
    var newCategory = "<form action='categorymaintenance.php' method='post'><input type='text' name='txtName' id='txtName' placeholder='Enter Category Name' /><input type='submit' name='add' value='Add' /></form>";
    document.getElementById("add").innerHTML = newCategory;
}
</script>

<?php

	require_once('../lib/footer.php');

?>