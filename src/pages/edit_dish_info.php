<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dish.class.php');
    require_once('../database/user.class.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    if (User::canEditDish($db, intval($_GET['id']), intval($_SESSION['idUser']))) {
        $dish = Dish::getDish($db, intval($_GET['id']));

        output_header();
        output_edit_dish_form($dish);
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
?>