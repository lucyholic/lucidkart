<?php

class orderHeader {
    
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
        $this->dispatchedDate = "";  
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

    }

    public function DispatchOrder()
    {
        
    }
}

?>