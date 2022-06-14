<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/review.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();

    filterText($_POST['reply']);
    
    $orderDate = time(); //date of the current day
    
    if (!empty($_POST['reply'])) {
        Review::replyReview ($db, $_POST['reply'], intval($_SESSION['idUser']), intval($_POST['idReview']));
    }
   
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>