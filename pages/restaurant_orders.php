<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/order.class.php');
    require_once('../database/user.class.php');
    require_once('../templates/restaurant_orders.tpl.php');
    require_once('../templates/common.tpl.php');

    $db = getDatabaseConnection();

    if (User::isRestaurantOwner($db, intval($_GET['id']), intval($_SESSION['idUser']))) {

        $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
        $restaurantOrders = Order::getRestaurantOrders($db, $restaurant);

        $css_files = array('restaurant_orders.css');
        output_header($css_files);

        if (!empty($restaurantOrders)) {
            output_restaurant_orders_list($restaurantOrders, $restaurant);
        }
        
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
    
?>