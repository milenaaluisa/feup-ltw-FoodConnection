<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }
    
    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/restaurant.tpl.php');
  
    $db = getDatabaseConnection();

    $my_restaurants = Restaurant::getUserRestaurants($db, intval($_SESSION['idUser']));

    $css_files = array('my_restaurants.css');
    
    output_header($css_files);
    output_my_restaurants_list($my_restaurants); ?>
    <a href="add_restaurant.php">Add new restaurant <i class="fa-regular fa-plus"></i></a>
    <?php output_footer();
?>