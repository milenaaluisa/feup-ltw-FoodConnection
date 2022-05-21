<?php
    require_once('../database/connection.db.php');
    require_once('../database/categories.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/dishes.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/restaurants.tpl.php');
  
    $db = getDatabaseConnection();

    $restaurant = getRestaurant($db, $_GET['id']);

    $categories = getRestaurantCategories($db, $_GET['id']);

    $shifts = getRestaurantShifts($db, $_GET['id']);

    $dishes = getRestaurantDishes($db, $_GET['id']);

    $reviews = getRestaurantReviews($db, $_GET['id']);
    
    output_header(); ?>
    <main>
        <?php output_single_restaurant($restaurant, $categories, $dishes, $shifts, $reviews); ?>
    </main>    

    <?php output_footer();
?>