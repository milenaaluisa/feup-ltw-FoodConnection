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

    function registerDish(PDO $db, string $name, string $ingredients, float $price, int $idRestaurant) {
        $stmt = $db->prepare('INSERT INTO Dish (name, ingredients, price, idRestaurant)
                              VALUES(?, ?, ?, ?)');
        $stmt->execute(array($name, $ingredients, $price, $idRestaurant));

        return $db->lastInsertId();
    }

    function registerDishCategories (PDO $db, int $idDish, array $categories){
        foreach($categories as $category) {
            registerDishCategory ($db, $idDish, intval($category));
        }
    }

    function registerDishCategory (PDO $db, int $idDish, int $category){
        $stmt = $db->prepare('INSERT INTO DishCategory(idDish, idCategory)
                                    VALUES(?, ?)');
        $stmt->execute(array($idDish, $category));
    }

    function registerDishAllergens (PDO $db, int $idDish, array $allergens){
        foreach($allergens as $allergen) {
            registerDishAllergen ($db, $idDish, intval($allergen));
        }
    }

    function registerDishAllergen (PDO $db, int $idDish, int $allergen){
        $stmt = $db->prepare('INSERT INTO DishAllergen(idDish, idAllergen)
                                    VALUES(?, ?)');
        $stmt->execute(array($idDish, $allergen));
    }
?>