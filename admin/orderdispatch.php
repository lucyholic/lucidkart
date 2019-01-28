<?php
require_once('lib/header.php');

if(!isset($_SESSION['orderid']))
{
    echo "<script>alert('Invalid Access.');
		window.location='ordermanagement.php';</script>";
}

$id = $_SESSION['orderid'];

// Update stock
$sql = "SELECT itemId, orderId, itemName, onHand-qty AS newOnHand
    FROM orderDetail
    JOIN item USING (itemId)
    WHERE orderId = '".$id."'";
$result = mysqli_query($conn, $sql);

// while($row = mysqli_fetch_assoc($result))
// {
//     if ($row['newOnHand'] < 0)
//     {
//         echo '<script>alert("Cannot dispatch: Item '.$row['itemName'].' is out of stock.");
//             window.location = "ordermanager.php?orderid='.$id.'";</script>';
//         exit();
//     }
// }


while($row = mysqli_fetch_assoc($result))
{
    echo '<script>console.info("New onHand: '.$row['newOnHand'].'");</script>';
    $stockUpdate = "UPDATE item SET
        onHand = '".$row['newOnHand']."'
        WHERE itemId = '".$row['itemId']."'";
    
    mysqli_query($conn, $stockUpdate);
}

// Update dispatchedDate
$date = date("Y/m/d");
$dispatch = "UPDATE orderHeader SET dispatchedDate = '$date'
    WHERE orderId = '$id'";
mysqli_query($conn, $dispatch);

echo '<script>window.location = "ordermanagement.php";</script>';

?>