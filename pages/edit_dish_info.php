<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/dishes.db.php');
    require_once('../database/user.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $db = getDatabaseConnection();

    if (canEditDish($db, intval($_GET['id']), intval($_SESSION['idUser'])) {
        $dish = getSelectedDish($db, intval($_GET['id']));

        output_header();
        output_edit_dish_form($dish);
        output_footer();
    }

    else {
        die(header('Location: index.php'));
    }
?>