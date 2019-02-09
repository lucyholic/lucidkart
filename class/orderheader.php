<?php

require_once('connectdb.php');
require_once('validate.php');


class OrderHeader {
    
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
    private $conn;

    // basic constructor of orderHeader
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

    // Add a new order
    public function AddOrderHeader()
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
        
        mysqli_query($conn, $sql);
    }

    public function DispatchOrder()
    {
        
    }
}

?>