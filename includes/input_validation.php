<?php 

    declare(strict_types = 1);

    //check if the username is valid: it can only have letters/numbers/underscore
    //and should not have a number/underscore in the beginning
    function validUsername (string $username) {
        return preg_match ('/^[a-z][a-z0-9_]*$/', $_POST['username']);
    }

    //check if email is in the right format
    function validEmail(string $email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //check if phone number is valid (9 disgits)
    function validPhoneNumber(string $phoneNum) {
        return preg_match('/^[0-9]{9}+$/', $phoneNum);
    }

    //check if zipCode is in the right format (format XXXX-XXX)
    function validZipCode(string $zipCode) {
        return preg_match ("/^[0-9]{4}[-][0-9]{3}+$/", $zipCode);
    }
    
    //check if password lenght >= 8
    function validPassword(string $password) {
        return strlen($password) >= 8;
    }

    //remove special chars from name
    function filterName(string &$name) {
        $name = preg_replace ("/[^a-zA-Z\s-]/", '', $name);
    }

    //remove special chars from address
    function filterAddress(string &$address) {
        $address = preg_replace ("/[^a-zA-Z0-9\s-]/", '', $address);
    }

    //remove special chars from city
    function filterCity(string &$city) {
        $city = preg_replace ("/[^a-zA-Z\s-]/", '', $city);
    }
?>