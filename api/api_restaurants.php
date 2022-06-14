<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../pages/index.php');


    $db = getDatabaseConnection();

    $search = $_GET['search'];

    $restaurants = Restaurant::getSearchedRestaurants($db, $search, 8);

    echo json_encode($restaurants);
?>