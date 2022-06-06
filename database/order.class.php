<?php 
    declare(strict_types = 1); 
    require_once('restaurant.class.php');

    class Order {
        public int $idFoodOrder;
        public string $state;
        public int $orderDate;
        public $notes;
        public array $items;
        public float $total;
        public bool $rated;
        public Restaurant $restaurant;

        public function __construct(int $idFoodOrder, string $state, int $orderDate, $notes, array $items, float $total, bool $rated, Restaurant $restaurant) {
            $this->idFoodOrder = $idFoodOrder;
            $this->state = $state;
            $this->orderDate = $orderDate;
            $this->notes = $notes;
            $this->items = $items;
            $this->total = $total;
            $this->rated = $rated;
            $this->restaurant = $restaurant;
        }

        static function getOrder (PDO $db, int $idFoodOrder) : ?Order {
            $stmt = $db->prepare('SELECT FoodOrder.*, sum(quantity * price) as total, Review.idReview as rated, idRestaurant
                                  FROM FoodOrder
                                  JOIN Selection USING (idFoodOrder)
                                  JOIN Dish USING (idDish)
                                  LEFT JOIN Review USING (idFoodOrder)
                                  WHERE FoodORder.idFoodOrder = ?');
            $stmt->execute(array($idFoodOrder));

            if ($order = $stmt->fetch()) {
                $items = Order::getOrderItems($db, intval($order['idFoodOrder']));
                $restaurant = Restaurant::getRestaurant($db, intval($order['idRestaurant']));

                return new Order(
                    intval($order['idFoodOrder']),
                    $order['state'],
                    intval($order['orderDate']),
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
                    $order['notes'],
                    $items,
                    floatval($order['total']),
                    boolval($order['rated']), 
                    $restaurant);     
            }
            return $orders;
        }

        public static function getOrderItems(PDO $db, int $idFoodOrder) : array {
            $stmt = $db->prepare('SELECT Dish.*, quantity
                                    FROM Dish
                                    JOIN Selection USING (idDish)
                                    WHERE idFoodOrder = ?');    
            $stmt->execute(array($idFoodOrder));
            $items =$stmt->fetchAll();
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
                    $order['notes'],
                    $items,
                    floatval($order['total']),
                    boolval($order['rated']),
                    $restaurant);     
            }
            return $orders; 
        }

        static function getOrderState(PDO $db, int $idFoodOrder) : string {
            $stmt = $db->prepare('SELECT FoodOrder.state
                                  FROM FoodOrder
                                  WHERE idFoodOrder = ?'); 
            $stmt->execute(array($idFoodOrder));
            $state = $stmt->fetch();
            return $state[0];
        }
    }
?>