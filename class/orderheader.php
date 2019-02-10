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
        $this->orderDetails = null;
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

            $this->subtotal += $this->GetPrice($id) * (int)$q;
        }
    }

    function GetPrice($itemId)
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
        
    }

    function GetOrderHeader()
    {

    }

    function GetOrderDetail()
    {

    }
}

?>