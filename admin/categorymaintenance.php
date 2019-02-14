<?php
	require_once('lib/header.php');	
    require_once('lib/authentication.php');
    require_once('../class/category.php');
	
	// title setting
    $title = "::LUCIDKART:: - Category Maintenance";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/admin/adminSubpages.css">';
	
	require_once('lib/adminmenu.php');

    // update category name
    if(isset($_POST['update']))
    {
        $category = new Category();

        $category->categoryId = mysqli_real_escape_string($conn, $_POST['txtId']);
        $category->categoryName = mysqli_real_escape_string($conn, $_POST['txtName']);

        $category->UpdateCategory();
    }

    if(isset($_POST['add']))
    {
        $category = new Category();

        $category->categoryName = mysqli_real_escape_string($conn, $_POST['txtName']);

        $category->AddCategory();
    }

    // set message
    if (isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
	else
		$message = "";	

    if ($message != "")
	{
		echo "<div id='message' class='alert alert-success' role='alert'>$message</div>";
    }
    
?>
<h2>Category Maintenance</h2>
<br><br>
<table class="reflow">
    <tr>
        <th colspan="2">Category Name</th>
    </tr>

<?php

    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result))
    {
        // string for deletion
        $confirm = '"Delete Category '.$row['categoryName'].'?"';
        $delete = '"categorydelete.php?id='.$row['categoryId'].'"';

        // form that passes category id as hidden and category name
        $form = '<form action="'.$_SERVER['PHP_SELF'].'" class="categoryMaintenanceForm" method="post">
        <input type="hidden" name="txtId" id="txtId" value="'.$row['categoryId'].'" />
        <input type="text" name="txtName" id="txtName" value="'.$row['categoryName'].'" />
        <input class="submit categoryMaintenance" type="submit" name="update" value="Update" />
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

<input class="submit white" type="button" value="Add a Category" onclick="AddCategory();" />

<br><br><br>

<script>
    // add a div for new category dynamically
    function AddCategory()
    {
        var newCategory = "<form action='categorymaintenance.php' method='post'><input type='text' name='txtName' id='txtName' placeholder='Enter Category Name' /><input type='submit' name='add' value='Add' /></form>";
        document.getElementById("add").innerHTML = newCategory;
    }

    //table reflow
	$('table.reflow').find('th').each(function(index, value){

		var $this = $(this),
		title = '<b class="cell-label">' + $this.html() + '</b>';

		// add titles to cells
		$('table.reflow')
		.find('tr').find('td:eq('+index+')').wrapInner('<span class="cell-content"></span>').prepend( title );
    });
    
</script>

<?php

	require_once('../lib/footer.php');

?>