<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/order.class.php');

    if(!isset($_SESSION['cart'])) {
        header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
    }

    $db = getDatabaseConnection();

    $orderDate = intval(time());
    $state = 'preparing';

    $idFoodOrder = Order::newOrder($db, $state, $orderDate, '', intval($_SESSION['idUser']));

    

    header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
?>