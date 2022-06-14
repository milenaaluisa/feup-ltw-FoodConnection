<?php
    declare(strict_types = 1);

    session_start();
    
    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/order.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/user_orders.tpl.php');

    $db = getDatabaseConnection();

    $my_orders = Order::getUserOrders($db, intval($_SESSION['idUser']));

    output_header();
    output_user_orders_list($my_orders);
    output_footer();
?>