<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['username'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');
    require_once('../database/categories.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    $allergens = getAllAllergens($db);   
    $categories = getAllCategories($db);

    output_header();
    output_new_dish_form($allergens, $categories);
    output_footer();
?>