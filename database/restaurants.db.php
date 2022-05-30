<?php
    declare(strict_types = 1);

    function getAllRestaurants(PDO $db) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              LEFT JOIN Photo USING (idRestaurant)
                              ORDER BY name');
        $stmt->execute();
        $restaurants = $stmt->fetchAll();
        return $restaurants;
    }

    function getCategoryRestaurants(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              LEFT JOIN Photo USING (idRestaurant) 
                              JOIN RestaurantCategory USING (idRestaurant)
                              WHERE idCategory = ?
                              ORDER BY name');
        $stmt->execute(array($id));
        $restaurants = $stmt->fetchAll();
        return $restaurants;
    }

    function getRestaurant(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              LEFT JOIN Photo USING (idRestaurant) 
                              WHERE idRestaurant = ?');
        $stmt->execute(array($id));
        $restaurant = $stmt->fetch();
        return $restaurant;
    }

    function getRestaurantShifts(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Shift.*
                              FROM Shift
                              JOIN RestaurantShift USING (idShift)
                              WHERE idRestaurant = ?');
        $stmt->execute(array($id));
        $shifts = $stmt->fetchAll();
        return $shifts;
    }

    function getRestaurantReviews(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT distinct Review.*, file
                              FROM Review
                              LEFT JOIN Photo USING (idReview)
                              NATURAL JOIN FoodOrder
                              NATURAL JOIN Selection
                              NATURAL JOIN Dish
                              WHERE idRestaurant = ?
                              ORDER BY reviewDate DESC');
        $stmt->execute(array($id));
        $reviews = $stmt->fetchAll();
        return $reviews;
    }

    function getUserRestaurants(PDO $db, int $idUser) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              LEFT JOIN Photo USING (idRestaurant) 
                              WHERE owner = ?
                              ORDER BY name');
        $stmt->execute(array($idUser));
        $my_restaurants = $stmt->fetchAll();
        return $my_restaurants;
    }

    function getUserFavouriteRestaurants(PDO $db, int $idUser) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              JOIN FavRestaurant USING (idRestaurant)
                              LEFT JOIN Photo USING (idRestaurant) 
                              WHERE FavRestaurant.idUser = ?');
        $stmt->execute(array($idUser));
        $favourite_restaurants = $stmt->fetchAll();
        return $favourite_restaurants;
    }

    function registerRestaurant(PDO $db, string $name, int $phoneNum, string $address,  string $zipCode, string $city, int $owner) {
        $stmt = $db->prepare('INSERT INTO Restaurant(name, phoneNum, address, zipCode, city, owner)
                              VALUES(?, ?, ?, ?, ?, ?) ');
        $stmt->execute(array($name, $phoneNum, $address, $zipCode, $city, $owner));

        return $db->lastInsertId();
    }

    function registerRestaurantCategories (PDO $db, int $idRestaurant, array $categories){
        foreach($categories as $category) {
            registerRestaurantCategory ($db, $idRestaurant, intval($category));
        }
    }

    function registerRestaurantCategory (PDO $db, int $idRestaurant, int $category){
        $stmt = $db->prepare('INSERT INTO RestaurantCategory(idRestaurant, idCategory)
                                    VALUES(?, ?)');
        $stmt->execute(array($idRestaurant, $category));
    }

    function updateRestaurantInfo (PDO $db, string $name, int $phoneNum, string $address, string $zipCode, string $city, int $idRestaurant) {
        $stmt = $db->prepare('UPDATE Restaurant
                                SET name = ?,
                                phoneNum = ?,
                                address = ?,
                                zipCode = ?,
                                city = ?
                                WHERE idRestaurant = ?');
        $stmt->execute(array($name, $phoneNum, $address, $zipCode, $city, $idRestaurant));
    }
?>