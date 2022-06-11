<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/photo.class.php');

    $db = getDatabaseConnection();

    $idRestaurant = Restaurant::registerRestaurant ($db, $_POST['name'], intval($_POST['number']), $_POST['address'], $_POST['zipCode'], $_POST['city'], intval($_SESSION['idUser']));

    $restaurant = Restaurant::getRestaurant($db, intval($idRestaurant));

    if(isset($_POST['categories']) && !empty($_POST['categories'])){
        $restaurant->registerRestaurantCategories ($db, $_POST['categories']);
    }

    if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
        $filename = "restaurant". "$restaurant->idRestaurant" . ".jpg";
        $location = "../images/restaurants/$filename";

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
   
    header('Location: ../pages/my_restaurants.php'); 
?>