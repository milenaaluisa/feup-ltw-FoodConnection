<?php 
    declare(strict_types = 1); 
    require_once('restaurant.class.php');

    class Review {
        public int $idReview;
        public $comment;
        public int $rate;
        public int $reviewDate;
        public int $idFoodOrder;
        public string $username;
        public $reply;
        public $profilePhoto;
        public $file;

        public function __construct(int $idReview, $comment, int $rate, int $reviewDate, int $idFoodOrder, string $username, $reply, $profilePhoto, $file)
        {
            $this->idReview = $idReview;
            $this->comment = $comment;
            $this->rate = $rate;
            $this->reviewDate = $reviewDate;
            $this->idFoodOrder = $idFoodOrder;
            $this->username = $username;
            $this->reply = $reply;
            $this->profilePhoto = $profilePhoto;
            $this->file = $file;
        }


        static function getReview(PDO $db, int $idReview) : ?Review{

        }


        static function getRestaurantReviews(PDO $db, int $idRestaurant) : array{
            $stmt = $db->prepare('SELECT RestReview.*, Photo.file as profilePhoto, username, Reply.comment as reply
                                  FROM (SELECT Distinct Review.*, FoodORder.idUser, file
                                        FROM Review
                                        JOIN FoodOrder USING (idFoodOrder)
                                        JOIN Selection USING (idFoodOrder)
                                        JOIN Dish USING (idDish)
                                        LEFT JOIN Photo USING (idReview)
                                        WHERE dish.idRestaurant = ?
                                        ORDER BY reviewDate DESC) AS RestReview
                                    LEFT JOIN Photo USING (idUser)
                                    JOIN User USING (idUser)
                                    LEFT JOIN Reply USING (idReview)');

            $stmt->execute(array($idRestaurant));
            $reviews = array();

            while ($review = $stmt->fetch()) { 
                $reviews[] = new Review(
                    intval($review['idReview']),
                    $review['comment'],
                    intval($review['rate']),
                    intval($review['reviewDate']),
                    intval($review['idFoodOrder']),
                    $review['username'],
                    $review['reply'],
                    $review['profilePhoto'],
                    $review['file']
                );
            }

            return $reviews;
        }    


        static function saveReview(PDO $db, int $rate, $comment, int $date, int $idFoodOrder) {
            $stmt = $db->prepare('INSERT INTO Review (comment, rate, reviewDate, idFoodOrder)
                                  VALUES (?, ?, ?, ?) ');
            $stmt->execute(array($comment, $rate, $date, $idFoodOrder));

            return $db->lastInsertId();
            
        }

        static function replyReview(PDO $db, string $comment, int $owner, int $idReview) {
            $stmt = $db->prepare('INSERT INTO Reply (comment, owner, idReview)
                                  VALUES (?, ?, ?)');
            $stmt->execute(array($comment, $owner, $idReview));
        }
    }

?>