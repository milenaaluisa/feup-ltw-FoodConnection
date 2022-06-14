<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/photo.class.php');
    require_once('../database/dish.class.php');

    $db = getDatabaseConnection();

    $idDish = Dish::registerDish ($db, $_POST['name'], $_POST['ingredients'], floatval($_POST['price']), intval($_POST['idRestaurant']));

    $dish = Dish::getDish($db, intval($idDish));

    if(isset($_POST['categories']) && !empty($_POST['categories'])){
        $dish->registerDishCategories ($db, $_POST['categories']);
    }

    if(isset($_POST['allergens']) && !empty($_POST['allergens'])){
        $dish->registerDishAllergens ($db, $_POST['allergens']);
    }

    if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
        $filename = "dish". $dish->idDish . ".jpg";
        $location = "../images/dishes/$filename";

        Photo::saveDishPhoto($db, intval($dish->idDish), $filename);
        
        move_uploaded_file($_FILES['photo']['tmp_name'], $location);

        
        $original = imagecreatefrompng($location);
        if (!$original) $original = imagecreatefrompng($location);
        if (!$original) $original = imagecreatefromgif($location);

        if (!$original) die('../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);

        $width = imagesx($original);     // width of the original image
        $height = imagesy($original);    // height of the original image

        $mediumwidth = $width;
        $mediumheight = $height;

        if ($mediumwidth > 1000) {
            $mediumwidth = 1000;
            $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
        }

        // Create and save a medium image
        $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
        imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
        imagejpeg($medium, $location);     
    }
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>