<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');

    $db = getDatabaseConnection();

    $idRestaurant = Restaurant::registerRestaurant ($db, $_POST['name'], intval($_POST['number']), $_POST['address'], $_POST['zipCode'], $_POST['city'], intval($_SESSION['idUser']));

    $restaurant = Restaurant::getRestaurant($db, intval($idRestaurant));

    if(isset($_POST['categories']) && !empty($_POST['categories'])){
        $restaurant->registerRestaurantCategories ($db, $_POST['categories']);
    }
   
    header('Location: ../pages/my_restaurants.php'); 
?>