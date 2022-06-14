<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');

    $db = getDatabaseConnection();

    $search = $_GET['search'];

    $restaurant_count = Restaurant::getRestaurantNum($db);

    $restaurants = Restaurant::getSearchedRestaurants($db, $search, $restaurant_count);

    echo json_encode($restaurants);
?>