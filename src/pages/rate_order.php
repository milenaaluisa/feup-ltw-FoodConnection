<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/review.class.php');
    require_once('../database/order.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    $order = Order::getOrder($db, intval($_GET['id']));

    if ($order) {
        if ($order->state !== 'delivered' || $order->rated === true || $order->idUser !== $_SESSION['idUser']) 
            die(header('Location: index.php'));

        output_header();
        output_rate_order_form(intval($_GET['id']));
        output_footer();
    }
    else{
        die(header('Location: index.php'));
    }
?>