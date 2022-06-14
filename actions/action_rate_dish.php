<?php
    declare(strict_types = 1);
    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');
    require_once('../database/order.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();
    
    if (!is_numeric($_POST['rate']) || $_POST['rate'] < 1 || $_POST['rate'] > 5){
        echo "invalid rate";
        die();
    }

    $order = Order::getOrder($db, intval($_POST['idFoodOrder']));
    $dish = Dish::getDish($db, intval($_POST['idDish']));

    if($order && $dish) {
        if ($order->state !== 'delivered' || $order->idUser !== $_SESSION['idUser']) 
            die(header('Location: index.php'));

        else if (Order::itemIsRated($db, $order->idFoodOrder, $dish->idDish))
            die(header('Location: index.php'));
        
        Order::rateOrderItem ($db, intval($_POST['idFoodOrder']), intval($_POST['idDish']), intval($_POST['rate']));
    
        header('Location: ../pages/order_history.php'); 
    }
    else {
        die(header('Location: ../pages/index.php'));
    }
    
?>