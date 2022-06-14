<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/order.class.php');

    $db = getDatabaseConnection();

    $idFoodOrder = intval($_GET['id']);
    $old_order = Order::getOrder($db, $idFoodOrder);

    $idUser = $old_order->idUser;
    $orderDate = intval(time());
    $items = Order::getOrderItems($db, $idFoodOrder);

    $new_idFoodOrder = Order::newOrder($db, 'received', $orderDate, '', $idUser);
    echo "$new_idFoodOrder";
    foreach($items as $item){
        $idDish = $item[0];
        $quantity = Order::getDishQuantity($db, $idFoodOrder, $idDish);

        Order::addOrderItem($db, $new_idFoodOrder, $idDish, $quantity);
    }

    header('Location: ../pages/order_history.php'); 
?>