<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');

    $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db, intval($_POST['idRestaurant']));
    
    if ($restaurant) {
        $restaurant->name = $_POST['name'];
        $restaurant->phoneNum = intval($_POST['number']);
        $restaurant->address = $_POST['address'];
        $restaurant->zipCode = $_POST['zipCode'];
        $restaurant->city =  $_POST['city'];

        $restaurant->updateRestaurantInfo($db);
    }
    
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>
