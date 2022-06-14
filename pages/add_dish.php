<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');
    require_once('../database/category.class.php');
    require_once('../database/user.class.php');
    require_once('../database/allergen.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    if (User::isRestaurantOwner($db, intval($_GET['id']), intval($_SESSION['idUser']))) {
        
        $allergens = Allergen::getAllAllergens($db);   
        $categories = Category::getAllCategories($db);

        output_header();
        output_new_dish_form($allergens, $categories, intval($_GET['id']));
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
?>