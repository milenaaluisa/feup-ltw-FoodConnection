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

    function getUserRestaurants(PDO $db, string $username) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              LEFT JOIN Photo USING (idRestaurant) 
                              WHERE owner = ?
                              ORDER BY name');
        $stmt->execute(array($username));
        $my_restaurants = $stmt->fetchAll();
        return $my_restaurants;
    }

    function getUserFavouriteRestaurants(PDO $db, string $username) {
        $stmt = $db->prepare('SELECT Restaurant.*, file
                              FROM Restaurant
                              JOIN FavRestaurant USING (idRestaurant)
                              LEFT JOIN Photo USING (idRestaurant) 
                              WHERE FavRestaurant.username = ?');
        $stmt->execute(array($username));
        $favourite_restaurants = $stmt->fetchAll();
        return $favourite_restaurants;
    }
?>