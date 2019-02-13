<?php
    require_once('lib/header.php');		
    require_once('lib/authentication.php');
    require_once('../class/orderheader.php');;
    require_once('../class/item.php');

    if(empty($_GET['orderid']))
    {
        $_SESSION['message'] = "No order found";
        header('Location: ordermanagement.php');
    }

    $id = mysqli_real_escape_string($conn, $_GET['orderid']);
    $_SESSION['orderid'] = $id;

    try 
    {
        $order = new Order();
        $order = $order->GetOrderHeader($id);

        $order->GetOrderDetail();
        $order->GetTotal();
    } 
    catch (Exception $ex) 
    {
        $_SESSION['message'] = $ex->getMessage();
        echo "<script>window.location='ordermanagement.php'</script>";
    }

    // title setting
    $title = "::LUCIDKART:: - Order management";
    
    // include css
	$css = '<link rel="stylesheet" type="text/css" href="../css/cart.css">';
    
    // admin menu
    require_once('lib/adminmenu.php');
	
    // body

    echo "<h2>Order# $id</h2>
        <h3>Ordered by: customer# ".$order->customerId."</h3>
        <p>Delivered to: ".$order->firstName." ".$order->lastName."<br />"
        .$order->address."<br />"
        .$order->city.", "
        .$order->province.", "
        .$order->postalCode."</p>";

    $province = $order->province;
?>

<h3>Item List</h3>
<table>
<tr><th>Item Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>

<?php

foreach($order->orderDetails as $id => $q)
{
    $item = new Item();
    $item = $item->GetItem($id);

    $subtotal = number_format((float)$item->itemPrice * $q, 2);

    echo '<tr>
        <td>'.$item->itemName.'</td>
        <td>'.$item->itemPrice.'</td>
        <td>'.$q.'</td>
        <td>'.$subtotal.'</td>
        </tr>';
}


echo '<tr>
    <td></td>
    <td></td>
    <td>Total: </td>
    <td>'.$order->subtotal.'</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td>Tax: </td>
    <td>'.$order->tax.'</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td>Grand Total: </td>
    <td>'.$order->total.'</td>
    </tr>
    </table>';


if($order->dispatchedDate == "")
{
    echo '<input type="button" value="Dispatch Order" onclick="ConfirmDispatch();" />';
}
else
{
    echo '<p>Dispatched Date: '.$order->dispatchedDate.'</p>';
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
