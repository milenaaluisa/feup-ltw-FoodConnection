<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/order.class.php');

    $db = getDatabaseConnection();

    $order = Order:: getOrder($db, intval($_GET['idOrder']));

    if ($_GET['state'] !== 'received' && $_GET['state'] != 'preparing' &&
        $_GET['state'] !== 'ready' && $_GET['state'] !== 'delivered')
        die();

    if ($order) {
        $order->changeState($db, $_GET['state']);
    }
?>