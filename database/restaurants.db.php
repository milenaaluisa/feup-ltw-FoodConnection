<?php
    function getAllRestaurants(PDO $db) {
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant, name, averagePrice, averageRate
                              FROM Restaurant
                              ORDER BY name');
        $stmt->execute();
        $restaurants = $stmt->fetchAll();
        return $restaurants;
    }

    function getCategoryRestaurants(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant, name, averagePrice, averageRate
                              FROM Restaurant
                              JOIN RestaurantCategory USING (idRestaurant) 
                              WHERE idCategory = ?
                              ORDER BY name');
        $stmt->execute(array($_GET['id']));
        $restaurants = $stmt->fetchAll();
        return $restaurants;
    }

    function getUserFavouriteRestaurants(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT FavRestaurant.username, Restaurant.*
                              FROM FavRestaurant
                              JOIN Restaurant USING (idRestaurant)
                              WHERE username /* MUDAR QUANDO TRATAR DAS SESSOES*/');
        $stmt->execute(array($_GET['id']));
        $favourite_restaurants = $stmt->fetchAll();
        return $favourite_restaurants;
    }

    function getRestaurant(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                              FROM Restaurant
                              WHERE idRestaurant = ?');
        $stmt->execute(array($_GET['id']));
        $restaurant = $stmt->fetch();
        return $restaurant;
    }

    function getRestaurantShifts(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Shift.*
                              FROM Shift
                              JOIN RestaurantShift USING (idShift)
                              WHERE idRestaurant = ?');
        $stmt->execute(array($_GET['id']));
        $shifts = $stmt->fetchAll();
        return $shifts;
    }

    function getRestaurantReviews(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT Review.*
                              FROM Review
                              JOIN Dish USING (idDish)
                              JOIN Restaurant USING (idRestaurant)
                              WHERE Dish.idRestaurant = ?');
        $stmt->execute(array($_GET['id']));
        $reviews = $stmt->fetchAll();
        return $reviews;
    }

    function getUserRestaurants(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                             FROM Restaurant
                              WHERE username /*QUANDO TRATAR DAS SESSOES*/
                              ORDER BY name');
        $stmt->execute(array($_GET['id']));
        $my_restaurants = $stmt->fetchAll();
        return $my_restaurants;
    }
?>