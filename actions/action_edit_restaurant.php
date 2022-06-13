<?php

    declare(strict_types = 1);
    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/user.class.php');
    require_once('../database/photo.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();

    if (!User::isRestaurantOwner($db, intval($_POST['idRestaurant']), $_SESSION['idUser']))
        die(header('Location: ../pages/index.php'));

    $restaurant = Restaurant::getRestaurant($db, intval($_POST['idRestaurant']));
    
    if ($restaurant) {
        if (!validPhoneNumber($_POST['number'])) { 
            echo "Invalid number";
            die();
        }
    
        if ( !validZipCode($_POST['zipCode'])) {
            echo "Invalid zip-code.";
            die();
        }

        //filter inserted name, city and address
        filterName($_POST['name']);
        filterAddress($_POST['address']);
        filterCity($_POST['city']);

        $restaurant->name = $_POST['name'];
        $restaurant->phoneNum = intval($_POST['number']);
        $restaurant->address = $_POST['address'];
        $restaurant->zipCode = $_POST['zipCode'];
        $restaurant->city =  $_POST['city'];

        $restaurant->updateRestaurantInfo($db);

        if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
            $filename = "restaurant". "$restaurant->idRestaurant" . ".jpg";
            $location = "../images/restaurants/$filename";
            
            if (!isset($restaurant->file))
                Photo::saveRestaurantPhoto($db, intval($restaurant->idRestaurant), $filename);
            
            move_uploaded_file($_FILES['photo']['tmp_name'], $location);
    
            $original = imagecreatefromjpeg($location);
            if (!$original) $original = imagecreatefrompng($location);
            if (!$original) $original = imagecreatefromgif($location);
    
            if (!$original) die('../pages/my_restaurants.php');
    
            $width = imagesx($original);     // width of the original image
            $height = imagesy($original);    // height of the original image
    
            $mediumwidth = $width;
            $mediumheight = $height;
    
            if ($mediumwidth > 2000) {
                $mediumwidth = 2000;
                $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
            }
    
            // Create and save a medium image
            $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
            imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
            imagejpeg($medium, $location);
        }
    }
    
    else {
        echo "Invalid Restaurant";
        die();
    }
        
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>
