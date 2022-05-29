<?php
    declare(strict_types = 1);

    session_start();
    
    if (!isset($_SESSION['username'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/dishes.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/favourites.tpl.php');
  
    $db = getDatabaseConnection();

    $favourite_restaurants = getUserFavouriteRestaurants($db, $_SESSION['username']);

    $favourite_dishes = getUserFavouriteDishes($db, intval($_GET['id']));

    $css_files = array('restaurants_list.css', 'dishes_list.css');
    output_header($css_files);
    output_favourites($favourite_restaurants, $favourite_dishes);    
    output_footer();
?>