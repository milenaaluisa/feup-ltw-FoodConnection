<?php
    function getAllCategories(PDO $db) {
        $stmt = $db->prepare('SELECT * FROM Category ORDER BY name');
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }

    function getAllOtherCategories(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                              FROM Category 
                              WHERE idCategory <> ?
                              ORDER BY name');
        $stmt->execute(array($id));
        $categories = $stmt->fetchAll();
        return $categories;
    }

    function getRestaurantCategories(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                              FROM Category
                              JOIN RestaurantCategory USING (idCategory)
                              WHERE idRestaurant = ?
                              ORDER BY name');
        $stmt->execute(array($_GET['id']));
        $categories = $stmt->fetchAll();
        return $categories;
    }
?>