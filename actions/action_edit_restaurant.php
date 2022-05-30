<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');

    $db = getDatabaseConnection();
    
    updateRestaurantInfo($db, $_POST['name'], intval($_POST['number']), $_POST['address'], $_POST['zipCode'], $_POST['city'], intval($_POST['idRestaurant']));
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>
