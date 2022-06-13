<?php

    declare(strict_types = 1);
    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/photo.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, intval($_SESSION['idUser']));

    if ($user) {
        if (!validUsername( $_POST['username'])){
            echo "Invalid username";
            die();
        }

        if(!validEmail($_POST['email'])) {
            echo "Invalid email";
            die();
        }

        if (!validPhoneNumber($_POST['phoneNum'])) { 
            echo "Invalid number";
            die();
        }

        if ( !validZipCode($_POST['zipCode'])) {
            echo "Invalid zip-code.";
            die();
        }

        if (!empty($_POST['password']) && !validPassword($_POST['password'])) {
            echo "Your password must have at least 8 characters.";
            die();
        } 

        //filter inserted name, city and address
        filterName($_POST['name']);
        filterAddress($_POST['address']);
        filterCity($_POST['city']);

        if ( $user-> email != strtolower($_POST['email']) &&  User::existsUserWithEmail($db, $_POST['email'])) {
            echo 'Choose another email'; 
            die();
        } 

        if ($user->username !== strtolower($_POST['username']) && User::existsUserWithUsername($db, $_POST['username'])){
            echo 'Choose another username'; 
            die();
        }

        if ($user->phoneNum !== intval($_POST['phoneNum']) && User::existsUserWithPhoneNumber($db, intval($_POST['phoneNum']))){
            echo 'Choose another phone number'; 
            die();
        }

        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        }
        

        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->phoneNum = intval($_POST['phoneNum']);
        $user->address = $_POST['address'];
        $user->city = $_POST['city'];
        $user->zipCode = $_POST['zipCode'];
        $user->username = $_POST['username'];

        if ($user->updateUserInfo($db, $password)) {
            echo "Success!";
            $_SESSION['idUser'] = $user->idUser;
            $_SESSION['name'] = $user->name;

            if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
            
                $filename = "user". $user->idUser . ".jpg";
                $location = "../images/users/$filename";
        
                if(!isset($user->file))
                    Photo::saveUserPhoto($db, intval($user->idUser), $filename);
                
                move_uploaded_file($_FILES['photo']['tmp_name'], $location);
    
                $original = imagecreatefromjpeg($location);
                if (!$original) $original = imagecreatefrompng($location);
                if (!$original) $original = imagecreatefromgif($location);
    
                if (!$original) die('../pages/my_restaurants.php');
    
                $width = imagesx($original);     // width of the original image
                $height = imagesy($original);    // height of the original image
    
                $mediumwidth = $width;
                $mediumheight = $height;
    
                if ($mediumwidth > 700) {
                    $mediumwidth = 700;
                    $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
                }
    
                // Create and save a medium image
                $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
                imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
                imagejpeg($medium, $location);

                $_SESSION['file'] = $filename; 
            }

            header('Location: ../pages/index.php');  
        }
    }

    echo "Invalid user!";
?>