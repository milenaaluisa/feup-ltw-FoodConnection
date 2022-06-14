<?php

declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/dish.class.php');

    if (!isset($_SESSION['idUser'])) {
        die();
    }

    $db = getDatabaseConnection();

    $dish = Dish::getDish($db, intval($_GET['id']));

    if ($dish && User::canEditDish($db, intval($_GET['id']), intval($_SESSION['idUser']))) {
        $dish->deleteDish($db);
    }

?> 