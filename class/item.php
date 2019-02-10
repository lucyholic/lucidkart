<?php

require_once('connectdb.php');
require_once('validate.php');

class Item {

    private $itemId;
    private $itemName;
    private $itemCategory;
    private $categoryName;
    private $itemPrice;
    private $itemImage;
    private $description;
    private $onHand;
    private $latestCollection;
    private $conn;

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
        $this->latestCollection = 0;

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
    
    // Add a new item
    public function AddItem()
    {
        // adjust description
        $this->description = $this->ReplaceBR($this->description);

        $this->itemPrice = number_format($this->itemPrice, 2);
        
        $sql = "INSERT INTO item (itemName, 
            itemCategory,
            itemPrice,
            itemImage, 
            description,
            latestCollection) VALUES('".		
            $this->itemName."', '".
            $this->itemCategory."', '".
            $this->itemPrice."', '".
            $this->itemImage."', '".
            $this->description."', '".
            $this->latestCollection."')";
        
        $result = mysqli_query($this->conn, $sql);

    }

    public function EditItem()
    {
        $this->CheckExist();

        if($this->itemImage != "")
        {
            mysqli_query($this->conn, "UPDATE item SET itemImage='".$this->itemImage."' WHERE itemId='".$this->itemId."'");
		}
        
        // adjust description
        $this->description = $this->ReplaceBR($this->description);

        $this->itemPrice = number_format($this->itemPrice, 2);

        $sql = "UPDATE item SET
            itemName = '".$this->itemName."',
            itemCategory ='".$this->itemCategory."',
            itemPrice = '".$this->itemPrice."',
            description='".$this->description."', 
		    latestCollection='".$this->latestCollection."' 
		    WHERE itemId='".$this->itemId."'";
        mysqli_query($this->conn, $sql);

    }

    public function DeleteItem()
    {
        $this->CheckExist();

        // delete img file from server
        $imgPath = "../".$this->itemImage;
        unlink($imgPath);

        $sql = "DELETE FROM item WHERE itemId = '".$this->itemId."'";
        mysqli_query($this->conn, $sql);

        $_SESSION['message'] = "Item ".$this->itemName." is deleted.";
    }

    public function UpdateOnhand($qty)
    {
        $this->CheckExist();

        
    }

    public function GetItem($itemId)
    {
        $sql = "SELECT * FROM item 
            JOIN category ON item.itemCategory = category.categoryId 
            WHERE itemId='".$itemId."'";
        $result = mysqli_query($this->conn, $sql);

        if ($result -> num_rows == 0)
            throw new Exception('Item ID Error');
        
        $row = mysqli_fetch_assoc($result);

        $this->itemId = $itemId;
        $this->itemName = $row['itemName'];
        $this->itemCategory = $row['itemCategory'];
        $this->categoryName = $row['categoryName'];
        $this->itemPrice = $row['itemPrice'];
        $this->itemImage = $row['itemImage'];
        $this->description = $row['description'];
        $this->onHand = $row['onHand'];
        $this->latestCollection = $row['latestCollection'];

        // replace <br> to \n in description
        $this->description = str_replace('<br />', "\n", $this->description);

        return $this;
    }

    function CheckExist()
    {
        $sql = "SELECT 0 FROM item WHERE itemId = '".$this->itemId."'";
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($result) == 0)
            throw new Exception('No item found');
    }

    function ReplaceBR($input)
    {
        $input = str_replace(array("\r\n", "\n", "\r"), '<br />', $input);
        return $input;
    }
}

?>