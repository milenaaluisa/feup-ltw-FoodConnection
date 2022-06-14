<?php
    declare(strict_types = 1);

    class Photo {
        public int $idPhoto;
        public string $filename;
        public int $idRestaurant;
        public int $idDish;
        public int $idUser;
        public int $idReview;

        static function saveDishPhoto (PDO $db, int $idDish, string $filename) : int {
            $stmt = $db->prepare('INSERT INTO Photo(idDish, file)
                                            VALUES(?, ?)');
            $stmt->execute(array($idDish, $filename));
    
            return intval($db->lastInsertId());
        }
    
    
        static function saveRestaurantPhoto (PDO $db, int $idRestaurant, string $filename) : int {
            $stmt = $db->prepare('INSERT INTO Photo(idRestaurant, file)
                                            VALUES(?, ?)');
            $stmt->execute(array($idRestaurant, $filename));
    
            return intval($db->lastInsertId());
        }
    
        static function saveUserPhoto (PDO $db, int $idUser, string $filename) : int {
            $stmt = $db->prepare('INSERT INTO Photo(idUser, file)
                                            VALUES(?, ?)');
            $stmt->execute(array($idUser, $filename));
    
            return intval($db->lastInsertId());
        }
    
        static function saveReviewPhoto (PDO $db, int $idReview, string $filename) : int {
            $stmt = $db->prepare('INSERT INTO Photo(idReview, file)
                                            VALUES(?, ?)');
            $stmt->execute(array($idReview, $filename));
    
            return intval($db->lastInsertId());
        }
    }

    
    
?>