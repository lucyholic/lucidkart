<?php
    require_once('lib/header.php');	
    
    // title setting
    $title = "::LUCIDKART:: - Order management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
    
    require_once('lib/menu.php');
	
	if(empty($_GET['orderid']))
		header('Location: ordermanagement.php');		
		
	$id = $_GET['orderid'];
    $_SESSION['orderid'] = $id;
    
    $headerSql = "SELECT * FROM orderHeader
        WHERE orderId='".$id."'";
    $headerResult = mysqli_query($conn, $headerSql);
	
	if ($headerResult -> num_rows == 0)
		header('Location: ordermanagement.php');
	
    $headerRow = mysqli_fetch_assoc($headerResult);

    echo "<h2>Order Detail for Order# $id</h2>
        <h3>Ordered by: customer# ".$headerRow['customerId']."</h3>
        <p>Delivered to: ".$headerRow['firstName']." ".$headerRow['lastName']."<br />"
        .$headerRow['address']."<br />"
        .$headerRow['city'].", "
        .$headerRow['province'].", "
        .$headerRow['postalCode']."</p>";
    $province = $headerRow['province'];
?>

<h3>Item List</h3>
<table>
<tr><th>Item Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>

<?php
$total = (float)0;
$tax = (float)0;

$detailSql = "SELECT * FROM orderDetail
    LEFT JOIN item USING (itemId)
    LEFT JOIN province ON province.code = '".$province."'
    WHERE orderId='".$id."'";
$detailResult = mysqli_query($conn, $detailSql);

while($row = mysqli_fetch_assoc($detailResult))
{
    $subtotal = (float)$row['itemPrice'] * (float)$row['qty'];
    $total += $subtotal;

    if ($tax == 0)
        $tax = (float)$row['taxrate'];
    
    echo '<tr>
        <td>'.$row['itemName'].'</td>
        <td>'.$row['itemPrice'].'</td>
        <td>'.$row['qty'].'</td>
        <td>'.$subtotal.'</td>
        </tr>';
}

echo '<tr>
    <td></td>
    <td></td>
    <td>Total: </td>
    <td>'.$total.'</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td>Tax: </td>
    <td>'.round(($total * $tax), 2).'</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td>Grand Total: </td>
    <td>'.round(($total + $total * $tax), 2).'</td>
    </tr>
    </table>';

if ($headerRow['dispatchedDate'] == null)
{
    echo '<input type="button" value="Dispatch Order" onclick="ConfirmDispatch();" />';
}

else
{
    echo '<p>Dispatched Date: '.$headerRow['dispatchedDate'].'</p>';
}

echo '<a href="ordermanagement.php">Go back to order management page</a>';

require_once('../lib/footer.php');

?>

<script>
function ConfirmDispatch()
{
    var action = confirm("Dispatch order?");
    if (action == true)
    {
        window.location = 'orderdispatch.php';
    }
}
</script>
