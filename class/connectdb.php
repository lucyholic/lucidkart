<?php

class ConnectDB {
    private $host;
    private $user;
    private $password;
    private $dbname;

    function __construct()
    {
        $this->host = "lucidkart.ctpaoqmnzm15.us-east-2.rds.amazonaws.com";
        $this->user = "admin";
        $this->password = "admin123";
        $this->dbname = "lucidkart";

    }

    public function Connect() 
    {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
        mysqli_select_db($conn, $this->dbname);

        return $conn;
    }
}

?>