<?php
    declare(strict_types = 1);

    class Category {
        public int $idCategory;
        public string $name;

        public function __construct(int $idCategory, string $name)
        {
            $this->idCategory = $idCategory;
            $this->name = $name;
        }

        static function getAllCategories(PDO $db) : array {
            $stmt = $db->prepare('SELECT * FROM Category ORDER BY name');
            $stmt->execute();
            $categories = array();

            while ($category = $stmt->fetch()) {
                $categories[] = new Category(
                  intval($category['idCategory']), 
                  $category['name']
                );
            }
          
            return $categories;
        }

        static function getAllOtherCategories(PDO $db, int $id) : array {
            $stmt = $db->prepare('SELECT *
                                  FROM Category 
                                  WHERE idCategory <> ?
                                  ORDER BY name');
            $stmt->execute(array($id));
            $categories = array();
 
            while ($category = $stmt->fetch()) {
                $categories[] = new Category(
                  intval($category['idCategory']), 
                  $category['name']
                );
            }
            return $categories;
        }

        static function getRestaurantCategories(PDO $db, int $id) {
            $stmt = $db->prepare('SELECT *
                                  FROM Category
                                  JOIN RestaurantCategory USING (idCategory)
                                  WHERE idRestaurant = ?
                                  ORDER BY name');
            $stmt->execute(array($id));
            $categories = array();

            while ($category = $stmt->fetch()) {
                $categories[] = new Category(
                  intval($category['idCategory']), 
                  $category['name']
                );
            }
            return $categories;
        }

    } 
?>