<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }
    
    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/restaurants.tpl.php');
  
    $db = getDatabaseConnection();

    $my_restaurants = getUserRestaurants($db, intval($_SESSION['idUser']));

    $css_files = array('my_restaurants.css');
    output_header($css_files);
    output_my_restaurants_list($my_restaurants); ?>
    <a href="add_restaurant.php">Add new restaurant</a>
    <?php output_footer();
?>