<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');
    require_once('../database/order.class.php');

    if(!isset($_SESSION['cart'])) {
        header('Location: ../pages/edit_restaurant.php?id='.$_POST['idRestaurant']);
    }

    function deleteCart(){
        unset($_SESSION['cart']);
    }

    function deleteDishCart($idDish){
        foreach($_SESSION['cart'] as $item => $value){
            if($idDish == $item){
                echo 'entrei';
                unset($_SESSION['cart'][$item]);
                if(sizeof($_SESSION['cart']) == 0 ){
                    deleteCart();
                }
            }
        }
    }

    if(isset($_POST["eliminate"])){

        deleteDishCart($_POST['eliminate']);
        echo $_POST['eliminate'];

        header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
        exit(0);
    }

    if(isset($_POST["cancel"])){
        deleteCart();
        header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
        exit(0);
    }

    if(isset($_POST["submit"])){
        $db = getDatabaseConnection();

        $idRES = intval($_POST['idRestaurant']);
        $orderDate = intval(time());
        $state = 'received';
        $notes = htmlspecialchars($_POST['notes']);

        $idFoodOrder = Order::newOrder($db, $state, $orderDate, $notes, intval($_SESSION['idUser']));
        foreach($_SESSION['cart'] as $id => $quantity){
            Order::addOrderItem($db, $quantity, $idFoodOrder, $id);
        }

        deleteCart();
    }

    header('Location: ../pages/restaurant.php?id='.$_POST['idRestaurant']);
?>