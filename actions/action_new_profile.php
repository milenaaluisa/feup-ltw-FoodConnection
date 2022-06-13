<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/photo.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();

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

    if (!validPassword($_POST['password'])) {
        echo "Your password must have at least 8 characters.";
        die();
    } 

    //filter inserted name, city and address
    filterName($_POST['name']);
    filterAddress($_POST['address']);
    filterCity($_POST['city']);


    //check if the inserted email/username/phone number matches is already associated to another user
    if (User::existsUserWithEmail($db, $_POST['email'])) {
        echo 'Choose another email'; 
        die();
    } 

    if (User::existsUserWithUsername($db, $_POST['username'])){
        echo 'Choose another username'; 
        die();
    }

    if (User::existsUserWithPhoneNumber($db, intval($_POST['phoneNum']))){
        echo 'Choose another phone number'; 
        die();
    }

    if ($idUser = User::registerUser($db, $_POST['name'], $_POST['email'], intval($_POST['phoneNum']), $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['username'], $_POST['password'])) {
        echo "Success!";

        //If a photo was uploaded
        if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
            
            $filename = "user". $idUser . ".jpg";
            $location = "../images/users/$filename";
    
            Photo::saveUserPhoto($db, intval($idUser), $filename);
            
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

        }

        $user = User::getUser($db, intval($idUser));

        $_SESSION['idUser'] = $user->idUser;
        $_SESSION['name'] = $user->name;
        $_SESSION['file'] = $user->file; 
    }

    header('Location: ../pages/index.php'); 
    
?>