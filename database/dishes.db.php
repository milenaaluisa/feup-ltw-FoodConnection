<?php
    function getSelectedDish(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Dish.*, file
                              FROM Dish
                              LEFT JOIN Photo USING (idDish)
                              WHERE Dish.idDish = ?');
        $stmt->execute(array($_GET['id']));
        $dish = $stmt->fetch();
        return $dish;
    }
    
    function getDishAllergens(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT name
                              FROM DishAllergen
                              JOIN Allergen Using (idAllergen)
                              WHERE idDish = ?
                              ORDER BY name');
        $stmt->execute(array($_GET['id']));
        $allergens = $stmt->fetchAll();
        return $allergens;
    }

    function getUserFavouriteDishes(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT FavDish.username, Dish.*
                              FROM FavDish
                              JOIN Dish USING (idDish)
                              WHERE username /* MUDAR QUANDO TRATAR DAS SESSOES*/');
        $stmt->execute(array($_GET['id']));
        $favourite_dishes = $stmt->fetchAll();
        return $favourite_dishes;
    }

    function getRestaurantDishes(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT idDish, name, price, averageRate, file
                              FROM Dish
                              LEFT JOIN Photo USING (idDish)
                              WHERE Dish.idRestaurant = ?
                              ORDER BY name');
        $stmt->execute(array($_GET['id']));
        $dishes = $stmt->fetchAll();
        return $dishes;
    }
?>