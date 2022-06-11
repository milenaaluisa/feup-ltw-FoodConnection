<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');

    $db = getDatabaseConnection();

    $idDish = intval($_GET['id']);		 //enviado pelo link da pagina
    $quantity = intval($_POST['quantity']);

    $dish = Dish::getDish($db, intval($idDish));

    if (!isset($_SESSION['cart'])){?>
        <script>
            console.log('click1');
            //TO DO MENSAGEM DE ALERTA JAVASCRIPT
        </script><?php
        $_SESSION ['idRestaurant'] = $dish->idRestaurant;
    }

    if ($dish->idRestaurant != $_SESSION ['idRestaurant']){?>
        <script>
            console.log('click');
            //TO DO MENSAGEM DE ALERTA JAVASCRIPT
        </script>
        <?php header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
        exit(0);
    }

    if(!isset($_SESSION['cart'][$idDish])) {
        $_SESSION['cart'][$idDish] = 0;	
    }

    $_SESSION['cart'][$idDish] += $quantity;

    header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
?>