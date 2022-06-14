<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');

    $db = getDatabaseConnection();

    $idDish = intval($_GET['id']);	
    $quantity = intval($_POST['quantity']);
    $price = $_POST['price'];
    $name = $_POST['name'];

    $dish = Dish::getDish($db, intval($idDish));

    if (!isset($_SESSION['cart'])){
        $_SESSION ['idRestaurant'] = $dish->idRestaurant;
    }

    if ($dish->idRestaurant != $_SESSION ['idRestaurant']){
        header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
        exit(0);
    }

    if(!isset($_SESSION['cart'][$idDish])) {
        $_SESSION['cart'][$idDish]['quantity'] = 0;
        $_SESSION['cart'][$idDish]['price'] = $price;
        $_SESSION['cart'][$idDish]['name'] = $name;
    }

    $_SESSION['cart'][$idDish]['quantity'] += $quantity;

    header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
?>