<?php

require_once('connectdb.php');

class Item {

    private $itemId;
    private $itemName;
    private $itemCategory;
    private $categoryName;
    private $itemPrice;
    private $itemImage;
    private $description;
    private $onHand;
    private $latestItem;
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
        $upload_dir = 'images/';
		$uploaded_file = $upload_dir . basename($_FILES['imgItemImage']['name']);
			
		if (move_uploaded_file($_FILES['imgItemImage']['tmp_name'], $uploaded_file))
		{
			$this->itemImage = 'images/'.basename($_FILES['imgItemImage']['name']);
			
			$sql = "INSERT INTO item (itemName, 
                itemCategory,
                itemPrice,
                itemImage, 
                description,
                latestItem) VALUES('".		
                $this->itemName."', '".
                $this->itemCategory."', '".
                $this->itemPrice."', '".
                $this->itemImage."', '".
                $this->description."', '".
                $this->latestItem."')";
			
			$result = mysqli_query($this->conn, $sql);
		}
		
		else
		{
			throw new Exception($_FILES['imgItemImage']['error']);
		}
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
        $this->latestItem = $row['latestItem'];

        return $this;
    }
}

?>