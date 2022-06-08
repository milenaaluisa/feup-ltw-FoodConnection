<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/category.class.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/review.class.php');
    require_once('../database/user.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/category.tpl.php');
    require_once('../templates/restaurant.tpl.php');
  
    $db = getDatabaseConnection();

    if (User::canEditRestaurant($db, intval($_GET['id']), intval($_SESSION['idUser']))) {

        $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));

        $categories = Category::getRestaurantCategories($db, intval($_GET['id']));

        $shifts = $restaurant->getRestaurantShifts($db);

        $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));

        $reviews = Review::getRestaurantReviews($db, intval($restaurant->idRestaurant));
        
        $css_files = array('edit_restaurant.css');
        output_header($css_files);
        output_restaurant_categories($restaurant, $categories);
        output_single_restaurant($restaurant, $dishes, $shifts, $reviews, True); 
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
?>