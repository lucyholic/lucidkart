<?php
    
require_once('connectdb.php');
require_once('validate.php');

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
    private $conn;


    // basic constructor of customer
    function __construct()
    {
        $this->customerId = null;
        $this->userId = "";
        $this->password = "";
        $this->firstName = "";
        $this->lastName = "";
        $this->phone = "";
        $this->email = "";
        $this->address = "";
        $this->city = "";
        $this->province = "";
        $this->postalCode = "";

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

    // Add a new customer
    public function AddCustomer()
    {
        Validate::Uniformize($this);

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
        
        mysqli_query($this->conn, $sql);
    }

    public function EditCustomer()
    {
        Validate::Uniformize($this);

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
            
        mysqli_query($this->conn, $sql);
    }

    public function GetCustomer($customerId)
    {
        $sql = "SELECT * FROM customer WHERE customerId=".$customerId;
        $result = mysqli_query($this->conn, $sql);

        if ($result -> num_rows == 0)
            throw new Exception('Customer ID Error');
        
        $row = mysqli_fetch_assoc($result);

        $this->userId = $row['userId'];
        $this->password = $row['password'];
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->address = $row['address'];
        $this->city = $row['city'];
        $this->province = $row['province'];
        $this->postalCode = $row['postalCode'];

        return $this;
    }

}

?>