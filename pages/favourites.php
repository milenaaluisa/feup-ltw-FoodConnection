<?php
    declare(strict_types = 1);

    session_start();
    
    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/favourites.tpl.php');
  
    $db = getDatabaseConnection();

    $favourite_restaurants = Restaurant::getUserFavouriteRestaurants($db, intval($_SESSION['idUser']));

    $favourite_dishes = Dish::getUserFavouriteDishes($db,  intval($_SESSION['idUser']));

    $css_files = array('restaurants_list.css', 'dishes_list.css');
    output_header($css_files);
    output_favourites($favourite_restaurants, $favourite_dishes);    
    output_footer();
?>