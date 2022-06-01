<?php
    declare(strict_types = 1);

    class Restaurant {
        public int $idRestaurant;
        public string $name;
        public float $averagePrice;
        public int $phoneNum;
        public string $address;
        public string $zipCode;
        public string $city;
        public int $averageRate;
        public int $owner;
        public $file;

        public function __construct(int $idRestaurant, string $name, int $phoneNum, string $address, string $zipCode, string $city, int $owner, $file, float $averagePrice = 0, int $averageRate)
        {
            $this->idRestaurant = $idRestaurant;
            $this->name = $name;
            $this->phoneNum = $phoneNum;
            $this->address = $address;
            $this->zipCode = $zipCode;
            $this->city = $city;
            $this->owner = $owner;
            $this->file = $file;
            $this->averagePrice = $averagePrice;
            $this->averageRate = $averageRate;
        }

        static function getAllRestaurants(PDO $db) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant)
                                  ORDER BY name');
            $stmt->execute();
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $restaurants[] = new Restaurant(
                    intval($restaurant['idRestaurant']), 
                    $restaurant['name'],
                    intval($restaurant['phoneNum']),
                    $restaurant['address'],
                    $restaurant['zipCode'],
                    $restaurant['city'],
                    intval($restaurant['owner']),
                    $restaurant['file'],
                    floatval($restaurant['averagePrice']),
                    intval($restaurant['averageRate']),
                );
            }
            return $restaurants;
        }

        static function getCategoryRestaurants(PDO $db, int $idCategory) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant) 
                                  JOIN RestaurantCategory USING (idRestaurant)
                                  WHERE idCategory = ?
                                  ORDER BY name');
            $stmt->execute(array($idCategory));
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $restaurants[] = new Restaurant(
                    intval($restaurant['idRestaurant']), 
                    $restaurant['name'],
                    intval($restaurant['phoneNum']),
                    $restaurant['address'],
                    $restaurant['zipCode'],
                    $restaurant['city'],
                    intval($restaurant['owner']),
                    $restaurant['file'],
                    floatval($restaurant['averagePrice']),
                    intval($restaurant['averageRate']),
                );
            }
            return $restaurants;
        }

        static function getRestaurant(PDO $db, int $id) : ?Restaurant {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant) 
                                  WHERE idRestaurant = ?');
            $stmt->execute(array($id));
            if ($restaurant = $stmt->fetch()) {
                return new Restaurant(
                        intval($restaurant['idRestaurant']), 
                        $restaurant['name'],
                        intval($restaurant['phoneNum']),
                        $restaurant['address'],
                        $restaurant['zipCode'],
                        $restaurant['city'],
                        intval($restaurant['owner']),
                        $restaurant['file'],
                        floatval($restaurant['averagePrice']),
                        intval($restaurant['averageRate']),
                );
            }
            return null;
        }

        function getRestaurantShifts(PDO $db) {
            $stmt = $db->prepare('SELECT Shift.*
                                  FROM Shift
                                  JOIN RestaurantShift USING (idShift)
                                  WHERE idRestaurant = ?');
            $stmt->execute(array($this->idRestaurant));
            $shifts = $stmt->fetchAll();
            return $shifts;
        }

        function getRestaurantReviews(PDO $db) {
            $stmt = $db->prepare('SELECT distinct Review.*, file
                                  FROM Review
                                  LEFT JOIN Photo USING (idReview)
                                  NATURAL JOIN FoodOrder
                                  NATURAL JOIN Selection
                                  NATURAL JOIN Dish
                                  WHERE idRestaurant = ?
                                  ORDER BY reviewDate DESC');
            $stmt->execute(array($this->idRestaurant));
            $reviews = $stmt->fetchAll();
            return $reviews;
        }

        static function getUserRestaurants(PDO $db, int $idUser) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant) 
                                  WHERE owner = ?
                                  ORDER BY name');
            $stmt->execute(array($idUser));
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $restaurants[] = new Restaurant(
                    intval($restaurant['idRestaurant']), 
                    $restaurant['name'],
                    intval($restaurant['phoneNum']),
                    $restaurant['address'],
                    $restaurant['zipCode'],
                    $restaurant['city'],
                    intval($restaurant['owner']),
                    $restaurant['file'],
                    floatval($restaurant['averagePrice']),
                    intval($restaurant['averageRate']),
                );
            }
            return $restaurants;
        }

        static function getUserFavouriteRestaurants(PDO $db, int $idUser) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  JOIN FavRestaurant USING (idRestaurant)
                                  LEFT JOIN Photo USING (idRestaurant) 
                                  WHERE FavRestaurant.idUser = ?
                                  ORDER BY NAME');
            $stmt->execute(array($idUser));
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $restaurants[] = new Restaurant(
                    intval($restaurant['idRestaurant']), 
                    $restaurant['name'],
                    intval($restaurant['phoneNum']),
                    $restaurant['address'],
                    $restaurant['zipCode'],
                    $restaurant['city'],
                    intval($restaurant['owner']),
                    $restaurant['file'],
                    floatval($restaurant['averagePrice']),
                    intval($restaurant['averageRate']),
                );
            }
            return $restaurants;
        }

        function registerRestaurant(PDO $db, string $name, int $phoneNum, string $address,  string $zipCode, string $city, int $owner) {
            $stmt = $db->prepare('INSERT INTO Restaurant(name, phoneNum, address, zipCode, city, owner)
                                  VALUES(?, ?, ?, ?, ?, ?) ');
            $stmt->execute(array($name, $phoneNum, $address, $zipCode, $city, $owner));
    
            return $db->lastInsertId();
        }

        function registerRestaurantCategories (PDO $db, array $categories){
            foreach($categories as $category) {
                $this->registerRestaurantCategory ($db, intval($category));
            }
        }

        function registerRestaurantCategory (PDO $db, int $category){
            $stmt = $db->prepare('INSERT INTO RestaurantCategory(idRestaurant, idCategory)
                                        VALUES(?, ?)');
            $stmt->execute(array($this->idRestaurant, $category));
        }

        function updateRestaurantInfo (PDO $db) {
            $stmt = $db->prepare('UPDATE Restaurant
                                    SET name = ?,
                                    phoneNum = ?,
                                    address = ?,
                                    zipCode = ?,
                                    city = ?
                                    WHERE idRestaurant = ?');
            $stmt->execute(array($this->name, $this->phoneNum, $this->address, $this->zipCode, $this->city, $this->idRestaurant));
        }
    } 
?>