<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');

    $db = getDatabaseConnection();

    updateDishInfo($db, $_POST['name'], $_POST['ingredients'], floatval($_POST['price']), intval($_POST['idDish']));
    
    header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
?>