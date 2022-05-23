<?php

    declare(strict_types = 1);

    session_start();
    
    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/dishes.tpl.php');
      
    $db = getDatabaseConnection();

    $dish = getSelectedDish($db, $_GET['id']);

    $allergens = getDishAllergens($db, $_GET['id']);

    $css_files = array ('dish.css');
    output_header($css_files);
    output_single_dish($dish, $allergens);
    output_footer();
?>