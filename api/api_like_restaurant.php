<?php

    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die();
    }

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/restaurant.class.php');

    $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    $user = User::getUser($db, intval($_SESSION['idUser']));

    if ($restaurant && $user) {
        if(Restaurant::isUserFavourite($db, intval($restaurant->idRestaurant),intval($_SESSION['idUser']))) {
            $user->dislikeRestaurant($db, intval($restaurant->idRestaurant), intval($_SESSION['idUser']));
        }

        else {
            $user->likeRestaurant($db, intval($restaurant->idRestaurant), intval($_SESSION['idUser']));
        }
    }
    
?>