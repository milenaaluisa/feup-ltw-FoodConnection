<?php 
    declare(strict_types = 1);

    class User {
        public int $idUser;
        public string $name;
        public string $email;
        public int $phoneNum;
        public string $address;
        public string $zipCode;
        public string $city;
        public string $username;
        public $file;

        public function __construct(int $idUser, string $name, string $email, int $phoneNum, string $address, string $zipCode, string $city, string $username, $file)
        {
            $this->idUser = $idUser;
            $this->name = $name;
            $this->email = $email;
            $this->phoneNum = $phoneNum;
            $this->address = $address;
            $this->zipCode = $zipCode;
            $this->city = $city;
            $this->username = $username;
            $this->file = $file;
        }

        static function getUserWithUsername (PDO $db, string $username, string $password) : ?User {

            $stmt = $db->prepare('SELECT User.*, file
                                  FROM User
                                  LEFT JOIN Photo USING (idUser)
                                  WHERE username = ?' );
    
            $stmt->execute(array(strtolower($username)));
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                return new User(
                    intval($user['idUser']),
                    $user['name'],
                    $user['email'],
                    intval($user['phoneNum']),
                    $user['address'],
                    $user['zipCode'],
                    $user['city'],
                    $user['username'],
                    $user['file']
                );
            }
            return null;
        }

        static function getUser (PDO $db, int $idUser) : ?User{
            $stmt = $db->prepare('SELECT User.*, file
                                  FROM User
                                  LEFT JOIN Photo USING (idUser)
                                  WHERE idUser = ?' );
    
            $stmt->execute(array($idUser));

            if ($user =  $stmt->fetch()) {
                return new User(
                    intval($user['idUser']),
                    $user['name'],
                    $user['email'],
                    intval($user['phoneNum']),
                    $user['address'],
                    $user['zipCode'],
                    $user['city'],
                    $user['username'],
                    $user['file']
                );
            }
            return null;
        }

        function getPassword (PDO $db) : string{
            $stmt = $db->prepare('SELECT password
                                  FROM User
                                  WHERE idUser = ?' );
    
            $stmt->execute(array($this->idUser));

            $password = $stmt->fetch();
            return md5($password['password']);
        }


        static function existsUserWithEmail (PDO $db, string $email) : bool {
            $stmt = $db->prepare('SELECT User.*
                                  FROM User
                                  WHERE email = ?' );
    
            $stmt->execute(array(strtolower($email)));
    
            if ($user =  $stmt->fetch()) {
                return true;
            }
            return false;
        }

        public static function existsUserWithUsername (PDO $db, string $username) : bool {
            $stmt = $db->prepare('SELECT User.*
                                  FROM User
                                  WHERE username = ?' );
    
            $stmt->execute(array(strtolower($username)));
    
            if ($user =  $stmt->fetch()) {
                return true;
            }
            return false;
        }

        function updateUserInfo (PDO $db, string $password) : bool{
            $stmt = $db->prepare('UPDATE User
                                    SET name = ?,
                                    email = ?,
                                    phoneNum = ?,
                                    address = ?,
                                    zipCode = ?,
                                    city = ?,
                                    username = ?,
                                    password = ?
                                    WHERE idUser = ?'
                                );
             $stmt->execute(array($this->name, strtolower($this->email), $this->phoneNum, $this->address, $this->zipCode, $this->city, strtolower($this->username), md5($password), $this->idUser));
    
            return true;
        }

        static function registerUser (PDO $db, string $name, string $email, int $phoneNum, string $address, string $zipCode, string $city, string $username, string $password) : int { 
            $options = ['cost' => 12];
            $stmt = $db->prepare('INSERT INTO User(name, email, phoneNum, address, zipCode, city, username, password)
                                  VALUES(?, ?, ?, ?, ?, ?, ?, ?) ');
            
            $stmt->execute(array($name, strtolower($email), $phoneNum, $address, $zipCode, $city, strtolower($username), password_hash($password, PASSWORD_DEFAULT, $options)));
    
            return intval($db->lastInsertId());
        }

        static function canEditRestaurant(PDO $db, int $idRestaurant, int $idUser) { 
            $stmt = $db->prepare('SELECT *
                                  FROM Restaurant
                                  WHERE idRestaurant = ?
                                  AND owner = ?');
            $stmt -> execute(array($idRestaurant, $idUser));
            return $stmt->fetch();
        }
    
       static function canEditDish(PDO $db, int $idDish, int $idUser) {
            $stmt = $db->prepare('SELECT *
                                FROM Dish
                                JOIN Restaurant USING (idRestaurant)
                                WHERE idDish = ?
                                AND owner = ?');
            $stmt -> execute(array($idDish, $idUser));
            return $stmt->fetch();
        }
    }

?>