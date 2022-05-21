<?php
    function getAllCategories(PDO $db) {
        $stmt = $db->prepare('SELECT * FROM Category');
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }

    function getAllOtherCategories(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                              FROM Category 
                              WHERE idCategory <> ?');
        $stmt->execute(array($id));
        $categories = $stmt->fetchAll();
        return $categories;
    }

    function getRestaurantCategories(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT *
                              FROM Category
                              JOIN RestaurantCategory USING (idCategory)
                              WHERE idRestaurant = ?');
        $stmt->execute(array($_GET['id']));
        $categories = $stmt->fetchAll();
        return $categories;
    }
?>