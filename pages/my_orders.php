<?php
    declare(strict_types = 1);

    session_start();
    
    if (!isset($_SESSION['username'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/orders.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/orders.tpl.php');

    $db = getDatabaseConnection();

    $my_orders = getUserOrders($db, intval($_GET['id']));

    $ordered_dishes = getOrderDishes($db, intval($_GET['id']))
    
    $subtotal = 0;

    $css_files = array('user_orders.css');

    output_header($css_files);
    output_order_list($my_orders, $ordered_dishes, $subtotal);
    output_footer();
?>