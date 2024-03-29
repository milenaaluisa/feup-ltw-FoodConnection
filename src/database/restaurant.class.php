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
        public bool $is_favourite;

        public function __construct(int $idRestaurant, string $name, int $phoneNum, string $address, string $zipCode, string $city, int $owner, $file, float $averagePrice = 0, int $averageRate, bool $is_favourite)
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
            $this->is_favourite = $is_favourite;
        }

        static function isUserFavourite(PDO $db, int $idRestaurant, int $idUser) : int{
            $stmt = $db->prepare('SELECT *
                                  FROM FavRestaurant 
                                  WHERE FavRestaurant.idUser = ? AND FavRestaurant.idRestaurant = ?');
            $stmt->execute(array($idUser, $idRestaurant));
            if($stmt->fetch()) return 1;
            return 0;
        }

        static function getAllRestaurants(PDO $db) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant)
                                  ORDER BY name');
            $stmt->execute();
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $is_favourite = Restaurant::isUserFavourite($db, intval($restaurant['idRestaurant']), intval($_SESSION['idUser']));

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
                    boolval($is_favourite)
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
                $is_favourite = Restaurant::isUserFavourite($db, intval($restaurant['idRestaurant']), intval($_SESSION['idUser']));

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
                    boolval($is_favourite)
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
                $is_favourite = Restaurant::isUserFavourite($db, intval($restaurant['idRestaurant']), intval($_SESSION['idUser']));
                
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
                        boolval($is_favourite)
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

        static function getUserRestaurants(PDO $db, int $idUser) : array {
            $stmt = $db->prepare('SELECT Restaurant.*, file
                                  FROM Restaurant
                                  LEFT JOIN Photo USING (idRestaurant) 
                                  WHERE owner = ?
                                  ORDER BY name');
            $stmt->execute(array($idUser));
            $restaurants = array();

            while ($restaurant = $stmt->fetch()) {
                $is_favourite = Restaurant::isUserFavourite($db, intval($restaurant['idRestaurant']), intval($_SESSION['idUser']));

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
                    boolval($is_favourite)
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
                    true
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

        static function getSearchedRestaurants(PDO $db, string $search, int $count) {
            if(is_numeric($search)) {
                $rate = intval($search);
                $stmt = $db->prepare('SELECT DISTINCT Restaurant.*, Photo.file
                                      FROM Restaurant
                                      JOIN Photo USING (idRestaurant)
                                      WHERE averageRate = ?
                                      LIMIT ?');
                $stmt->execute(array($rate, $count));
            }
            else {
                $stmt = $db->prepare('SELECT DISTINCT Restaurant.*, Photo.file
                                    FROM Restaurant
                                    JOIN Photo USING (idRestaurant)
                                    JOIN Dish USING (idRestaurant)
                                    WHERE lower(Restaurant.name) like ? OR
                                    lower(Dish.name) like ?
                                    LIMIT ?');
                $stmt->execute(array('%' . strtolower($search) . '%', '%' . strtolower($search) . '%', $count));
            }

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
                    false
                );
            }
            return $restaurants;
        }

        function getRestaurantNum (PDO $db) {
            $stmt = $db->prepare('SELECT count(idRestaurant)
                                  FROM Restaurant');
            $stmt->execute(array());
            $count = $stmt->fetch();
            return intval($count[0]);
        }
    } 
?>