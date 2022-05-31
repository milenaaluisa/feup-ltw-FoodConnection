<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');

    $db = getDatabaseConnection();

    $dish = Dish::getDish($db, intval($_POST['idDish']));

    if ($dish) {
        $dish->name = $_POST['name'];
        $dish->ingredients = $_POST['ingredients'];
        $user->price = floatval($_POST['price']);

        $dish->updateDishInfo($db);
    }

    
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>