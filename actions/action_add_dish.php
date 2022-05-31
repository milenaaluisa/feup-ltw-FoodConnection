<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
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

    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>