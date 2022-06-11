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
        $filename = "dish". $dish->idDish . "jpg";
        $location = "../images/dishes/$filename";

        Photo::saveDishPhoto($db, intval($dish->idDish), $filename);
        
        move_uploaded_file($_FILES['photo']['tmp_name'], $location);

        /*
        $original = imagecreatefrompng($filename);
        if (!$original) $original = imagecreatefrompng($filename);
        if (!$original) $original = imagecreatefromgif($filename);

        if (!$original) die();

        $width = imagesx($original);     // width of the original image
        $height = imagesy($original);    // height of the original image
        $square = min($width, $height);  // size length of the maximum square

        // Create and save a small square thumbnail
        $small = imagecreatetruecolor(200, 200);
        imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
        imagejpeg($small, $filename);*/
                
        }
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>