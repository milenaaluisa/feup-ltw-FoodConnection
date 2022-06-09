<?php 
    declare(strict_types = 1); 
    require_once('restaurant.class.php');

    class Order {
        public int $idFoodOrder;
        public string $state;
        public int $orderDate;
        public int $idUser;
        public $notes;
        public array $items;
        public float $total;
        public bool $rated;
        public Restaurant $restaurant;

        public function __construct(int $idFoodOrder, string $state, int $orderDate, int $idUser, $notes, array $items, float $total, bool $rated, Restaurant $restaurant) {
            $this->idFoodOrder = $idFoodOrder;
            $this->state = $state;
            $this->orderDate = $orderDate;
            $this->idUser = $idUser;
            $this->notes = $notes;
            $this->items = $items;
            $this->total = $total;
            $this->rated = $rated;
            $this->restaurant = $restaurant;
        }

        static function getOrder (PDO $db, int $idFoodOrder) : ?Order {
            $stmt = $db->prepare('SELECT FoodOrder.*, sum(quantity * price), Review.idReview, idRestaurant
                                  FROM FoodOrder
                                  JOIN Selection USING (idFoodOrder)
                                  JOIN Dish USING (idDish)
                                  LEFT JOIN Review USING (idFoodOrder)
                                  GROUP BY idFoodOrder
                                  HAVING FoodOrder.idFoodOrder = ?');
            $stmt->execute(array($idFoodOrder));

            if (($order = $stmt->fetch())) {
                $items = Order::getOrderItems($db, intval($order['idFoodOrder']));
                $restaurant = Restaurant::getRestaurant($db, intval($order['idRestaurant']));

                return new Order(
                    intval($order['idFoodOrder']),
                    $order['state'],
                    intval($order['orderDate']),
                    intval($order['idUser']),
                    $order['notes'],
                    $items,
                    floatval($order['total']),
                    boolval($order['rated']), 
                    $restaurant);     
            }
            return null;
        }

        static function getUserOrders(PDO $db, int $idUser) : array {
            $stmt = $db->prepare('SELECT FoodOrder.*, sum(quantity * price) as total, Review.idReview as rated, idRestaurant
                                  FROM FoodOrder
                                  JOIN Selection USING (idFoodOrder)
                                  JOIN Dish USING (idDish)
                                  LEFT JOIN Review USING (idFoodOrder)
                                  GROUP BY FoodOrder.idFoodOrder
                                  HAVING FoodOrder.idUser = ?');
            $stmt->execute(array($idUser));
            $orders = array();
    
            while ($order = $stmt->fetch()) {
                $items = Order::getOrderItems($db, intval($order['idFoodOrder']));
                $restaurant = Restaurant::getRestaurant($db, intval($order['idRestaurant']));

                $orders[] = new Order(
                    intval($order['idFoodOrder']),
                    $order['state'],
                    intval($order['orderDate']),
                    intval($order['idUser']),
                    $order['notes'],
                    $items,
                    floatval($order['total']),
                    boolval($order['rated']), 
                    $restaurant);     
            }
            return $orders;
        }

        public static function getOrderItems(PDO $db, int $idFoodOrder) : array {
            $stmt = $db->prepare('SELECT Dish.*, Selection.*
                                    FROM Dish
                                    JOIN Selection USING (idDish)
                                    WHERE idFoodOrder = ?');    
            $stmt->execute(array($idFoodOrder));
            $items =array();

            while($item = $stmt->fetch()) {
                $item['rated'] = Order::itemIsRated($db, intval($item['idFoodOrder']), intval($item['idDish']));
                $items[] = $item;
            }
            return $items;
        }

        static function getRestaurantOrders(PDO $db, Restaurant $restaurant) {
            $stmt = $db->prepare('SELECT FoodOrder.*, sum(quantity * price) as total, Review.idReview as rated
                                  FROM FoodOrder
                                  JOIN Selection USING (idFoodOrder)
                                  JOIN Dish USING (idDish)
                                  LEFT JOIN Review USING (idFoodOrder)
                                  GROUP BY FoodOrder.idFoodOrder
                                  HAVING idRestaurant = ?
                                  ORDER BY FoodOrder.orderDate DESC');    
            $stmt->execute(array($restaurant->idRestaurant));
            $order = array();

            while ($order = $stmt->fetch()) {
                $items = Order::getOrderItems($db, intval($order['idFoodOrder']));
                $orders[] = new Order(
                    intval($order['idFoodOrder']),
                    $order['state'],
                    intval($order['orderDate']),
                    intval($order['idUser']),
                    $order['notes'],
                    $items,
                    floatval($order['total']),
                    boolval($order['rated']),
                    $restaurant);     
            }
            return $orders; 
        }

        static function rateOrderItem(PDO $db, int $idFoodOrder, int $idDish, int $rate){
            $stmt = $db->prepare('INSERT INTO RateDish (rate, idFoodOrder, idDish)
                                  VALUES (?, ?, ?)');
            $stmt->execute(array($rate, $idFoodOrder, $idDish));
        } 

        static function itemIsRated(PDO $db, int $idFoodOrder, int $idDish) : bool {
            $stmt = $db->prepare('SELECT * 
                                  FROM RateDish 
                                  WHERE idFoodOrder = ? AND idDish = ?');
            $stmt->execute(array($idFoodOrder, $idDish));
            if ($item =  $stmt->fetch()) {
                return true;
            }
            return false;
        }
    }
?>