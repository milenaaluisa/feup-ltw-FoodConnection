<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser']) || !isset($_GET['id']) || !isset($_GET['order'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');
    require_once('../database/order.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    $order = Order::getOrder($db, intval($_GET['order']));
    $dish = Dish::getDish($db, intval($_GET['id']));

    if ($order && $dish) {
        if ($order->state !== 'delivered' || $order->idUser !== $_SESSION['idUser']) 
            die(header('Location: index.php'));

        else if (Order::itemIsRated($db, $order->idFoodOrder, $dish->idDish))
            die(header('Location: index.php'));

        output_header();
        output_rate_dish_form($dish, $order);
        output_footer();
    }
    
    else {
        die(header('Location: index.php'));
    }

?>