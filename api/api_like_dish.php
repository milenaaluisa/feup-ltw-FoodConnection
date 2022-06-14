<?php

    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die();
    }

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/dish.class.php');

    $db = getDatabaseConnection();

    $dish = Dish::getDish($db, intval($_GET['id']));
    $user = User::getUser($db, intval($_SESSION['idUser']));

    if ($dish && $user) {
        if(Dish::isUserFavouriteDish($db, intval($dish->idDish),intval($_SESSION['idUser']))) {
            $user->dislikeDish($db, intval($dish->idDish), intval($_SESSION['idUser']));
        }

        else {
            $user->likeDish($db, intval($dish->idDish), intval($_SESSION['idUser']));
        }
    }
?>