<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/order.class.php');

    $db = getDatabaseConnection();
    
    Order::rateOrderItem ($db, intval($_POST['idFoodOrder']), intval($_POST['idDish']), intval($_POST['rate']));

    header('Location: ../pages/order_history.php'); 
?>