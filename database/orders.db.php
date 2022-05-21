<?php
    function getUserOrders(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT FoodOrder.*, Restaurant.name as restName
                              FROM FoodOrder
                              JOIN Selection USING (idFoodOrder)
                              JOIN Dish USING (idDish)
                              JOIN Restaurant USING (idRestaurant)
                              WHERE username /*QUANDO TRATAR DAS SESSOES*/');
        $stmt->execute(array($_GET['id']));
        $my_orders = $stmt->fetchAll();
        return $my_orders;
    }

    function getOrderDishes(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Dish.*, Selection.*, FoodOrder.*
                              FROM Dish
                              JOIN Selection USING (idDish)
                              JOIN FoodOrder USING (idFoodOrder)
                              WHERE username /*QUANDO TRATAR DAS SESSOES*/');
        $stmt->execute(array($_GET['id']));
        $ordered_dishes = $stmt->fetchAll();
        return $ordered_dishes;
    }
?>