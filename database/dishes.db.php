<?php
    declare(strict_types = 1);

    function getSelectedDish(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Dish.*, file
                              FROM Dish
                              LEFT JOIN Photo USING (idDish)
                              WHERE Dish.idDish = ?');
        $stmt->execute(array($id));
        $dish = $stmt->fetch();
        return $dish;
    }
    
    function getDishAllergens(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT name
                              FROM DishAllergen
                              JOIN Allergen Using (idAllergen)
                              WHERE idDish = ?
                              ORDER BY name');
        $stmt->execute(array($id));
        $allergens = $stmt->fetchAll();
        return $allergens;
    }

    function getRestaurantDishes(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Dish.*, file
                              FROM Dish
                              LEFT JOIN Photo USING (idDish)
                              WHERE Dish.idRestaurant = ?
                              ORDER BY name');
        $stmt->execute(array($id));
        $dishes = $stmt->fetchAll();
        return $dishes;
    }

    function getUserFavouriteDishes(PDO $db, string $username) {
        $stmt = $db->prepare('SELECT Dish.*, file
                              FROM Dish
                              JOIN FavDish USING (idDish)
                              LEFT JOIN Photo USING (idDish)
                              WHERE FavDish.username = ?');
        $stmt->execute(array($username));
        $favourite_dishes = $stmt->fetchAll();
        return $favourite_dishes;
    }

    function getAllAllergens(PDO $db) {
        $stmt = $db->prepare('SELECT *
                              FROM Allergen
                              ORDER BY name');
        $stmt->execute();
        $allergens = $stmt->fetchAll();
        return $allergens;
    }
?>