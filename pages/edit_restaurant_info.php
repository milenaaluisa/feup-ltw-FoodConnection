<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/categories.db.php');
    require_once('../database/user.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    if (canEditRestaurant($db, intval($_GET['id']), intval($_SESSION['idUser']))) {

        $restaurant = getRestaurant($db, intval($_GET['id']));

        output_header();
        output_edit_restaurant_form($restaurant);
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
    
?>