<?php

require_once('connectdb.php');
require_once('validate.php');

class Order {
    
    private $orderId;
    private $customerId;
    private $orderDate;
    private $firstName;
    private $lastName;
    private $phone;
    private $address;
    private $city;
    private $province;
    private $postalCode;
    private $dispatchedDate;
    private $orderDetails;
    private $numOfItems;
    private $subtotal;
    private $tax;
    private $total;
    private $conn;

    // basic constructor of order
    public function __construct()
    {
        $this->orderId = null;
        $this->customerId = 0;
        $this->orderDate = "";
        $this->firstName = "";
        $this->lastName = "";
        $this->phone = "";
        $this->email = "";
        $this->address = "";
        $this->city = "";
        $this->province = "";
        $this->postalCode = "";
        $this->dispatchedDate = null; 
        $this->orderDetails = array();
        $this->numOfItems = 0;
        $this->subtotal = (float)0;
        $this->tax = (float)0;
        $this->total = (float)0;

        $open = new ConnectDB();
        $this->conn = $open->Connect();
    }

    // Get and Set
    public function __set( $name, $value ) 
    {
        if (property_exists($this, $name))
    	    $this->$name = $value;
    }
    
    public function __get( $name ) 
    {
        if(property_exists($this, $name))
            return $this->$name;
    }

    // Create a new order
    public function CreateNewOrder()
    {
        // create a header
        $this->AddOrderHeader();

        // add items
        $this->AddOrderDetail();

        // get total
        $this->GetTotal();
    }

    // Add a new order header
    function AddOrderHeader()
    {
        Validate::Uniformize($this);

        $sql = "INSERT INTO orderHeader (customerId,
		orderDate,
		firstName,
		lastName,
		phoneNumber,
		address,
		city,
		province,
		postalCode) VALUES('".
		$this->customerId."', '".
		$this->orderDate."', '".
		$this->firstName."', '".
		$this->lastName."', '".
		$this->phone."', '".
		$this->address."', '".
		$this->city."', '".
		$this->province."', '".
        $this->postalCode."')";
        
        mysqli_query($this->conn, $sql);

        $this->orderId = mysqli_insert_id($this->conn);
    }

    function AddOrderDetail()
    {
        foreach($this->orderDetails as $id => $q)
        {
            $this->numOfItems++;

            $sql = "INSERT INTO orderDetail (orderId, itemId, qty) VALUES('".$this->orderId."', '".
                $id."', '". 
                $q."')";

            mysqli_query($this->conn, $sql);

            $this->subtotal += $this->GetItemPrice($id) * (int)$q;
        }
    }

    function GetItemPrice($itemId)
    {
        $sql = "SELECT itemPrice FROM item WHERE itemId = '".$itemId."'";
        $result = mysqli_query($this->conn, $sql);
        $price = number_format((float)mysqli_fetch_row($result)[0], 2);
        return $price;
    }

    function GetTotal()
    {
        $result = mysqli_query($this->conn, "SELECT taxrate FROM province 
            WHERE code='".$this->province."'");
        $taxRate = floatval(mysqli_fetch_row($result)[0]);

        $this->tax = number_format($this->subtotal * $taxRate, 2);
        $this->total = $this->subtotal + $this->tax;
    }

    public function DispatchOrder()
    {
        $this->CheckExist();

        $date = date("Y/m/d");

        $sql = "UPDATE orderHeader SET dispatchedDate = '".$date."'
            WHERE orderId = '".$this->orderId."'";
        mysqli_query($this->conn, $sql);
        
        $_SESSION['message'] = "Order dispatched";
    }

    function GetOrderHeader($orderId)
    {
        $sql = "SELECT * FROM orderHeader WHERE orderId='".$orderId."'";
        $result = mysqli_query($this->conn, $sql);

        if($result->num_rows == 0)
            throw new Exception('Order header ID error');

        $row = mysqli_fetch_assoc($result);

        $this->orderId = $orderId;
        $this->customerId = $row['customerId'];
		$this->orderDate = $row['orderDate'];
		$this->firstName = $row['firstName'];
		$this->lastName = $row['lastName'];
		$this->phone = $row['phoneNumber'];
		$this->address = $row['address'];
		$this->city = $row['city'];
		$this->province = $row['province'];
        $this->postalCode = $row['postalCode'];
        
        if($row['dispatchedDate'] != null)
            $this->dispatchedDate = $row['dispatchedDate'];

        return $this;
    }

    function GetOrderDetail()
    {
        $sql = "SELECT * FROM orderDetail
            JOIN item USING(itemId)
            WHERE orderId='".$this->orderId."'' AND customerId=''".$this->customerId."'";
        $result = mysqli_query($this->conn, $sql);

        if($result->num_rows == 0)
            throw new Exception('No Item in Order');

        while($row = mysqli_fetch_assoc($result))
        {
            $this->orderDetails[$row['itemId']] = $row['qty'];
            $this->subtotal += (float)$row['itemPrice'] * (float)$row['qty'];
        }
        
        $this->subtotal = number_format($this->subtotal, 2);
    }

    function CheckExist()
    {
        $sql = "SELECT 0 FROM orderHeader WHERE orderId = '".$this->orderId."'";
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($result) == 0)
            throw new Exception('No order found');
    }
}

?>