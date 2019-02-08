<?php

class Customer{
    private $customerId;
    private $userId;
    private $password;
    private $firstName;
    private $lastName;
    private $phone;
    private $email;
    private $address;
    private $city;
    private $province;
    private $postalCode;

    // basic constructor for customer
    function __construct($customerId, $userId, $password, $firstName, $lastName, $phone, 
        $email, $address, $city, $province, $postalCode)
    {
        $this->customerId = $customerId;
        $this->userId = strtolower($userId);
        $this->password = $password;
        $this->firstName = Validate::Capitalize($firstName);
        $this->lastName = Validate::Capitalize($lastName);
        $this->phone = $phone;
        $this->email = $email;
        $this->address = Validate::Capitalize($address);
        $this->city = Validate::Capitalize($city);
        $this->province = $province;
        $this->postalCode = strtoupper($postalCode);
    }

    // Getters
    public function GetUserId()
    {
        return $this->userId;
    }

    public function GetPassword()
    {
        return $this->password;
    }

    public function GetFirstName()
    {
        return $this->firstName;
    }

    public function GetLastName()
    {
        return $this->lastName;
    }

    public function GetPhone()
    {
        return $this->phone;
    }

    public function GetEmail()
    {
        return $this->email;
    }

    public function GetAddress()
    {
        return $this->address;
    }

    public function GetCity()
    {
        return $this->city;
    }

    public function GetProvince()
    {
        return $this->province;
    }

    public function GetPostalCode()
    {
        return $this->postalCode;
    }


    // Add a new customer
    public function AddCustomer()
    {
        $sql = "INSERT INTO customer (userId, 
            password, 
            firstName, 
            lastName, 
            phone, 
            email, 
            address, 
            city, 
            province, 
            postalCode) VALUES('".		
            $this->userId."', '".
            $this->password."', '".
            $this->firstName."', '".
            $this->lastName."', '".
            $this->phone."', '".
            $this->email."', '".
            $this->address."', '".
            $this->city."', '".
            $this->province."', '".
            $this->postalCode."')";
        
        return $sql;
    }

    public function EditCustomer()
    {
        $sql = "UPDATE customer SET
			firstName='".$this->firstName."', 
			lastName='".$this->lastName."', 
			phone='".$this->phone."',
			email='".$this->email."',
			address='".$this->address."',
			city='".$this->city."',
			province='".$this->province."',
			postalCode='".$this->postalCode."'
            WHERE customerId='".$this->customerId."'";
            
        return $sql;
    }


}

?>