<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/photo.class.php');

    $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db, intval($_POST['idRestaurant']));
    
    if ($restaurant) {
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
    
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>
