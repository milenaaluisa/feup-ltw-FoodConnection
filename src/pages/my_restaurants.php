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

    output_header();
    output_my_restaurants_list($my_restaurants); ?>
    <?php output_footer();
?>