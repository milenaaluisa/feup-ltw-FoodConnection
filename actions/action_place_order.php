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

    $idRES = intval($_POST['idRestaurant']);
    echo "$idRES";
    $orderDate = intval(time());
    $state = 'received';
    $notes = htmlspecialchars($_POST['notes']);

    $idFoodOrder = Order::newOrder($db, $state, $orderDate, $notes, intval($_SESSION['idUser']));
    foreach($_SESSION['cart'] as $id => $quantity){
        echo "$quantity";
        Order::addOrderItem($db, $quantity, $idFoodOrder, $id);
    }

    header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
?>