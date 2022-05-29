<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/categories.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/dishes.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/restaurants.tpl.php');
  
    $db = getDatabaseConnection();

    $restaurant = getRestaurant($db, intval($_GET['id']));

    $categories = getRestaurantCategories($db, intval($_GET['id']));

    $shifts = getRestaurantShifts($db, intval($_GET['id']));

    $dishes = getRestaurantDishes($db, intval($_GET['id']));

    $reviews = getRestaurantReviews($db, intval($_GET['id']));
    
    $css_files = array('edit_restaurant.css');
    output_header($css_files);
    output_restaurant_categories($restaurant, $categories);
    output_single_restaurant($restaurant, $dishes, $shifts, $reviews, True); 
    output_footer();
?>