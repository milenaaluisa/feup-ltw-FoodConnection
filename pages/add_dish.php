<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['username'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');
    require_once('../database/categories.db.php');
    require_once('../database/user.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    if (canEditRestaurant($db, intval($_GET['id']), $_SESSION['username'])) {
        $allergens = getAllAllergens($db);   
        $categories = getAllCategories($db);

        output_header();
        output_new_dish_form($allergens, $categories, intval($_GET['id']));
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
?>