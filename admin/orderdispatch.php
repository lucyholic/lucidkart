<?php

require_once('lib/header.php');	
require_once('lib/authentication.php');
require_once('../class/orderheader.php');;
require_once('../class/item.php');

if(!isset($_SESSION['orderid']))
{
    $_SESSION['message'] = "Invalid access";
    echo "<script>window.location='ordermanagement.php';</script>";
}

$orderId = $_SESSION['orderid'];

try
{
    $order = new Order();
    $order = $order->GetOrderHeader($orderId);
    $order->GetOrderDetail();

    $i = new Item();
    $i->CheckOnHandValid($order->orderDetails);

    foreach($order->orderDetails as $id=>$q)
    {
        $item = new Item();
        $item = $item->GetItem($id);
        $item->UpdateOnhand($q);
    }

    $order->DispatchOrder();
    echo '<script>window.location = "ordermanagement.php";</script>';
    
}

catch(Exception $ex)
{
    $_SESSION['message'] = $ex->getMessage();
    echo "<script>window.location='ordermanagement.php';</script>";
}

?>