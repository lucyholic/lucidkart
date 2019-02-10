<?php
require_once('connectdb.php');

class Category {

    private $categoryId;
    private $categoryName;
    private $numOfItems;
    private $conn;

    // constructor
    public function __construct()
    {
        $this->categoryId = null;
        $this->categoryName = "";
        $this->numOfItems = 0;

        $open = new ConnectDB();
        $this->conn = $open->Connect();
    }

    // Get and Set
    public function __set( $name, $value ) 
    {
        if (property_exists($this, $name))
    	    $this->$name = $value;
    }

    public function __get($name)
    {
        if(property_exists($name))
        {
            return $this->$name;
        }
    }

    // methods
    public function AddCategory()
    {
        if ($this->CheckName())
        {
            $sql = "INSERT INTO category (categoryName)
                VALUES ('".$this->categoryName."')";
            mysqli_query($this->conn, $sql);

            $_SESSION['message'] = "New category added.";
        }
        else
        {
            $_SESSION['message'] = "Category cannot be added: Category name already exists.";
        }
    }

    public function GetCategory($categoryId)
    {
        $sql = "SELECT * FROM category WHERE categoryId = '".$categoryId."'";
        $result = mysqli_query($this->conn, $sql);

        if ($result -> num_rows == 0)
            throw new Exception('Category ID Error');

        $row = mysqli_fetch_assoc($result);

        $this->categoryId = $categoryId;
        $this->categoryName = $row['categoryName'];

        return $this;
    }
    
    public function DeleteCategory()
    {
        $this->CheckExist();

        if ($this->GetNumOfItems() != 0)
        {
            $_SESSION['message'] = "Category cannot be deleted: Items exist";
        }

        else
        {
            $_SESSION['message'] = "Category '".$this->categoryName."' is deleted";

            $sql = "DELETE FROM category WHERE categoryId='".$this->categoryId."'";
		    mysqli_query($this->conn, $sql);
        }

    }

    public function UpdateCategory()
    {
        $this->CheckExist();

        if ($this->CheckName())
        {
            $sql = "UPDATE category SET categoryName = '".$this->categoryName."'
                WHERE categoryId = '".$this->categoryId."'";
            mysqli_query($this->conn, $sql);

            $_SESSION['message'] = "Category name updated.";
        }

        else
        {
            $_SESSION['message'] = "Category cannot be updated: Category name already exists.";
        }
    }

    // Get number of items in the category
    function GetNumOfItems()
    {
        $sql = "SELECT 0 FROM item WHERE itemCategory='".$this->categoryId."'";
        $result = mysqli_query($this->conn, $sql);

        return mysqli_num_rows($result);
    }

    // Check if category name is duplicated
    function CheckName()
    {
        $sql = "SELECT 0 FROM category WHERE categoryName = '".$this->categoryName."'";
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($result) != 0)
            return false;

        else
            return true;
            
    }

    function CheckExist()
    {
        $sql = "SELECT 0 FROM category WHERE categoryId = '".$this->categoryId."'";
        $result = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($result) == 0)
            throw new Exception('No category found');
    }
}

?>