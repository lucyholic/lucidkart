<?php

class Validate {

    static function ValidateCustomer(customer $c, bool $isAdd)
    {
        $userId = trim($c->userId."");
        $password = trim($c->password."");
        $firstName = trim($c->firstName."");
        $lastName = trim($c->lastName."");
        $phone = trim($c->phone."");
        $email = trim($c->email."");
        $address = trim($c->address."");
        $city = trim($c->city."");
        $province = trim($c->province."");
        $postalCode = trim($c->postalCode."");

        $error = "";

        if ($isAdd == true)
        {
            if($userId == "")
                $error .= "User ID is missing.\n";
            elseif(strlen($userId) < 3 || strlen($userId) > 15)
                $error .= "User ID must be between 3 and 15 characters.\n";
        
            if($password == "")
                $error .= "Password is missing.\n";
            elseif(strlen($password) < 5 || strlen($password) > 15)
                $error .= "Password must be between 5 and 15 characters.\n";
        }

        if($firstName == "")
            $error .= "First name is missing.\n";
        
        if($lastName == "")
            $error .= "Last name is missing.\n";

        if($phone == "")
            $error .= "Phone number is missing.\n";
        
        if($email == "")
            $error .= "Email address is missing.\n";

        if($address == "")
            $error .= "Address is missing.\n";

        if($city == "")
            $error .= "City is missing.\n";

        if($province == "")
            $error .= "Province is missing.\n";

        if($postalCode == "")
            $error .= "Postal code is missing.\n";

        if ($error == "")
        {
            return true;
        }
            
        else
        {
            throw new Exception($error);
        }
            
    }

    static function ValidateItem(Item $i, bool $isAdd)
    {
        $itemName = ucfirst(trim($i->itemName.""));
        $itemCategory = trim($i->itemCategory."");
        $itemPrice = trim($i->itemPrice."");
        $itemImage = trim($i->itemImage."");
        $description = trim($i->description."");

        $error = "";

        if($itemName == "")
            $error .= "Item name is missing\n";
        
        if($itemCategory == "")
            $error .= "Item category is missing\n";
        
        if($itemPrice == "")
            $error .= "Item price is missing\n";
        
        if ($isAdd)
        {
            if($itemImage == "")
            $error .= "Item image is missing\n";
        }
        
        if($description == "")
            $error .= "Description is missing\n";

        if ($error == "")
        {
            return true;
        }
            
        else
        {
            throw new Exception($error);
        }

    }

    static function ValidateOrder(Order $o)
    {
        $customerId = $o->customerId;
        $orderDate = $o->orderdate;
        $firstName = trim($o->firstName."");
        $lastName = trim($o->lastName."");
        $phone = trim($o->phone."");
        $email = trim($o->email."");
        $address = trim($o->address."");
        $city = trim($o->city."");
        $province = trim($o->province."");
        $postalCode = trim($o->postalCode."");

        $error = "";

        if($customerId == "")
            $error .= "Customer ID is missing.\n";
        
        if($orderDate == "")
            $error .= "Order date is missing.\n";
        
        if($firstName == "")
            $error .= "First name is missing.\n";
        
        if($lastName == "")
            $error .= "Last name is missing.\n";

        if($phone == "")
            $error .= "Phone number is missing.\n";
        
        if($email == "")
            $error .= "Email address is missing.\n";

        if($address == "")
            $error .= "Address is missing.\n";

        if($city == "")
            $error .= "City is missing.\n";

        if($province == "")
            $error .= "Province is missing.\n";

        if($postalCode == "")
            $error .= "Postal code is missing.\n";

        if ($error == "")
        {
            return true;
        }
            
        else
        {
            throw new Exception($error);
        }
        
    }

    static function Capitalize(string $input)
    {
        $newInput = "";
        $tokens = explode(" ", $input);

        foreach($tokens as $token)
        {
            $newInput .= ucfirst($token)." ";
        }

        return trim($newInput);
    }

    static function Uniformize($o)
    {
        if(property_exists($o, $userId))
            $o->userId = strtolower($o->userId);

        $o->firstName = Validate::Capitalize($o->firstName);
        $o->lastName = Validate::Capitalize($o->lastName);
        $o->address = Validate::Capitalize($o->address);
        $o->city = Validate::Capitalize($o->city);
        $o->postalCode = strtoupper($o->postalCode);
    }

}

?>