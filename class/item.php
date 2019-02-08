<?php

class Item {
    private $itemId;
    private $itemName;
    private $itemCategory;
    private $itemPrice;
    private $itemImage;
    private $description;
    private $onHand;

    // basic constructor of item
    function __construct()
    {
        $this->itemId = null;
        $this->itemName = "";
        $this->itemCategory = "";
        $this->itemPrice = 0;
        $this->itemImage = "";
        $this->description = "";
        $this->onHand = 0;
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
    
    // Add a new item
    public function AddItem()
    {

    }

    public function EditItem()
    {

    }

    public function DeleteItem()
    {

    }

    public function UpdateOnhand()
    {
        
    }
}

?>