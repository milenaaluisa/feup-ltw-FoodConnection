<?php
    declare(strict_types = 1);

    class Dish {
        public int $idDish;
        public string $name;
        public $ingredients;
        public float $price;
        public string $priceHistory;
        public int $averageRate;
        public int $idRestaurant;
        public $file;

        public function __construct(int $idDish, string $name, float $price, int $idRestaurant, $ingredients, $file, string $priceHistory= ' ', int $averageRate= 0, bool $is_favourite)
        {
            $this->idDish = $idDish;
            $this->name = $name;
            $this->ingredients = $ingredients;
            $this->price = $price;
            $this->priceHistory = $priceHistory;
            $this->averageRate = $averageRate;
            $this->idRestaurant = $idRestaurant;
            $this->file = $file;
            $this->is_favourite = $is_favourite;
        }

        static function isUserFavouriteDish(PDO $db, int $idDish, int $idUser) : int{
            $stmt = $db->prepare('SELECT *
                                  FROM FavDish
                                  WHERE FavDish.idUser = ? AND FavDish.idDish = ?');
            $stmt->execute(array($idUser, $idDish));
            if($stmt->fetch()) return 1;
            return 0;
        }

        static function getDish(PDO $db, int $id) : ?Dish {
            $stmt = $db->prepare('SELECT Dish.*, file
                                  FROM Dish
                                  LEFT JOIN Photo USING (idDish)
                                  WHERE Dish.idDish = ?');
            $stmt->execute(array($id));
            if ($dish = $stmt->fetch()) {
                $is_favourite = Dish::isUserFavouriteDish($db, intval($dish['idDish']), intval($_SESSION['idUser']));
                return new Dish(
                        intval($dish['idDish']), 
                        $dish['name'],
                        floatval($dish['price']),
                        intval($dish['idRestaurant']),
                        $dish['ingredients'],
                        $dish['file'],
                        $dish['priceHistory'],
                        intval($dish['averageRate']),
                        boolval($is_favourite)
                );
            }
            return null;
        }

        static function getRestaurantDishes(PDO $db, int $idRestaurant) : array {
            $stmt = $db->prepare('SELECT Dish.*, file
                                  FROM Dish
                                  LEFT JOIN Photo USING (idDish)
                                  WHERE Dish.idRestaurant = ?
                                  ORDER BY name');
            $stmt->execute(array($idRestaurant));
            $dishes =  array();

            while ($dish = $stmt->fetch()) {
                $is_favourite = Dish::isUserFavouriteDish($db, intval($dish['idDish']), intval($_SESSION['idUser']));

                $dishes[] = new Dish(
                        intval($dish['idDish']), 
                        $dish['name'],
                        floatval($dish['price']),
                        intval($dish['idRestaurant']),
                        $dish['ingredients'],
                        $dish['file'],
                        $dish['priceHistory'],
                        intval($dish['averageRate']),
                        boolval($is_favourite)
                    );
            }
            return $dishes;
        }

        static function getUserFavouriteDishes(PDO $db, int $idUser) : array{
            $stmt = $db->prepare('SELECT Dish.*, file
                                  FROM Dish
                                  JOIN FavDish USING (idDish)
                                  LEFT JOIN Photo USING (idDish)
                                  WHERE FavDish.idUser = ?
                                  ORDER BY name');
            $stmt->execute(array($idUser));
            $dishes =  array();

            while ($dish = $stmt->fetch()) {

                $dishes[] = new Dish(
                    intval($dish['idDish']), 
                    $dish['name'],
                    floatval($dish['price']),
                    intval($dish['idRestaurant']),
                    $dish['ingredients'],
                    $dish['file'],
                    $dish['priceHistory'],
                    intval($dish['averageRate']),
                    true
                );
            }
            return $dishes;
        }

        function registerDish(PDO $db, string $name, string $ingredients, float $price, int $idRestaurant) : int{
            $stmt = $db->prepare('INSERT INTO Dish (name, ingredients, price, idRestaurant)
                                VALUES(?, ?, ?, ?)');
            $stmt->execute(array($name, $ingredients, $price, $idRestaurant));

            return intval($db->lastInsertId());
        }

        function registerDishCategories (PDO $db, array $categories){
            foreach($categories as $category) {
                $this->registerDishCategory ($db, intval($category));
            }
        }
    
        function registerDishCategory (PDO $db, int $category){
            $stmt = $db->prepare('INSERT INTO DishCategory(idDish, idCategory)
                                        VALUES(?, ?)');
            $stmt->execute(array($this->idDish, $category));
        }

        function registerDishAllergens (PDO $db, array $allergens){
            foreach($allergens as $allergen) {
                $this->registerDishAllergen ($db, intval($allergen));
            }
        }
    
        function registerDishAllergen (PDO $db, int $allergen){
            $stmt = $db->prepare('INSERT INTO DishAllergen(idDish, idAllergen)
                                        VALUES(?, ?)');
            $stmt->execute(array($this->idDish, $allergen));
        }
    
        function updateDishInfo(PDO $db) {
            $stmt = $db->prepare('UPDATE Dish
                                    SET name = ?,
                                    ingredients = ?,
                                    price = ?
                                    WHERE idDish = ?');
            $stmt->execute(array($this->name, $this->ingredients, $this->price, $this->idDish));
        }
        
        function deleteDish(PDO $db) {
            $stmt = $db->prepare('DELETE FROM Dish WHERE idDish = ?');
            $stmt->execute(array($this->idDish));
        }
    }
    
?>