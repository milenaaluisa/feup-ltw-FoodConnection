<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');

    $db = getDatabaseConnection();

    registerRestaurant ($db, $_POST['name'], intval($_POST['number']), $_POST['address'], $_POST['zipCode'], $_POST['city'], $_SESSION['username']);
    header('Location: ../pages/my_restaurants.php'); 
?>