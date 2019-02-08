<?php

class Validate {

    static function ValidateCustomer(customer $c, bool $isAdd)
    {
        $userId = trim($c->GetUserId()."");
        $password = trim($c->GetPassword()."");
        $firstName = trim($c->GetFirstName()."");
        $lastName = trim($c->GetLastName()."");
        $phone = trim($c->GetPhone()."");
        $email = trim($c->GetEmail()."");
        $address = trim($c->GetAddress()."");
        $city = trim($c->GetCity()."");
        $province = trim($c->GetProvince()."");
        $postalCode = trim($c->GetPostalCode()."");

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

}

?>