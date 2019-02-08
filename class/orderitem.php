<?php

class orderItem {
    private $orderId;
    private $itemId;
    private $qty;

    function __construct()
    {
        $this->orderId = 0;
        $this->itemId = 0;
        $this->qty = 0;
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

    public function AddOrderItem()
    {
        $sql = "INSERT INTO orderDetail (orderId,
        itemId,
        qty) VALUES('".
        $this->orderId."', '".
        $this->itemId."', '".
        $this->qty."')";

        return $sql;
    }


}

?>