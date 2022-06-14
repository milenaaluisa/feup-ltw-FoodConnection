<?php
    declare(strict_types = 1);

    session_start();
    
    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');
    require_once('../database/allergen.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/dish.tpl.php');
      
    $db = getDatabaseConnection();

    $dish = Dish::getDish($db, intval($_GET['id']));

    $allergens = Allergen::getDishAllergens($db, $dish->idDish);

    $css_files = array ('dish.css');
    output_header($css_files);
    output_single_dish($dish, $allergens);
    output_footer();
?>