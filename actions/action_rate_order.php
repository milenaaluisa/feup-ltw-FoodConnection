<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/review.class.php');

    $db = getDatabaseConnection();

    $orderDate = time(); //date of the current day
    
    Review::saveReview ($db, intval($_POST['rate']), $_POST['comment'], intval($orderDate), intval($_POST['idFoodOrder']));

    header('Location: ../pages/order_history.php'); 
?>