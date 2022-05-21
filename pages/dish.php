<?php
    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/dishes.tpl.php');
      
    $db = getDatabaseConnection();

    $dish = getSelectedDish($db, $_GET['id']);

    $allergens = getDishAllergens($db, $_GET['id']);

    output_header();
    output_single_dish($dish, $allergens);
    output_footer();
?>