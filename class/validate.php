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
            throw new Excption($error);
        }
            
    }

    static function ValidateOrder()
    {

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
            
        $o->userId = strtolower($o->userId); 
        $o->firstName = Validate::Capitalize($o->firstName);
        $o->lastName = Validate::Capitalize($o->lastName);
        $o->address = Validate::Capitalize($o->address);
        $o->city = Validate::Capitalize($o->city);
        $o->postalCode = strtoupper($o->postalCode);
    }

}

?>