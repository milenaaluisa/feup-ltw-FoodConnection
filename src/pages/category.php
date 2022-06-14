<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/category.class.php');
    require_once('../database/restaurant.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/category.tpl.php');
    require_once('../templates/restaurant.tpl.php');


    $db = getDatabaseConnection();

    $categories = Category::getAllOtherCategories($db, intval($_GET['id']));

    if(intval($_GET['id']) == 0) {
        $restaurants = Restaurant::getAllRestaurants($db);
        $all_restaurants = 1;
    }
    else {
        $restaurants = Restaurant::getCategoryRestaurants($db, intval($_GET['id']));
        $all_restaurants = 0;
    }
    
    $css_files = array('restaurants_list.css');

    output_header($css_files);
    output_categories($categories);
    output_restaurant_list($restaurants, boolval($all_restaurants));
    output_footer();
?>