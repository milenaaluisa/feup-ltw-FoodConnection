<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/dishes.db.php');

    $db = getDatabaseConnection();

    $idDish = registerDish ($db, $_POST['name'], $_POST['ingredients'], floatval($_POST['price']), intval($_POST['idRestaurant']));

    if(isset($_POST['categories']) && !empty($_POST['categories'])){
        registerDishCategories ($db, intval($idDish), $_POST['categories']);
    }

    if(isset($_POST['allergens']) && !empty($_POST['allergens'])){
        registerDishAllergens ($db, intval($idDish), $_POST['allergens']);
    }

    header('Location: ../pages/my_restaurants.php'); 
?>