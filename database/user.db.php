<?php 
    declare(strict_types = 1);

    function getUserWithPassword (PDO $db, string $username, string $password) {

        $stmt = $db->prepare('SELECT User.*, file
                              FROM User
                              LEFT JOIN Photo USING (username)
                              WHERE username = ?
                              AND password = ? ' );

        $stmt->execute(array($username, md5($password)));

        if ($user =  $stmt->fetch()) {
            return $user;
        }
        return null;
    }


    function getUser (PDO $db, string $username) {
        $stmt = $db->prepare('SELECT User.*, file
                              FROM User
                              LEFT JOIN Photo USING (username)
                              WHERE username = ?' );

        $stmt->execute(array($username));

        $user =  $stmt->fetch();
        return $user;
    }

    function existsUserWithEmail (PDO $db, string $email) {
        $stmt = $db->prepare('SELECT User.*, file
                              FROM User
                              LEFT JOIN Photo USING (username)
                              WHERE email = ?' );

        $stmt->execute(array(strtolower($email)));

        if ($stmt->fetch())
            return true;
        return false;
    }

    function existsUserWithUsername (PDO $db, string $username) {
        $stmt = $db->prepare('SELECT User.*, file
                              FROM User
                              LEFT JOIN Photo USING (username)
                              WHERE username = ?' );

        $stmt->execute(array(strtolower($username)));

        if ($stmt->fetch()) 
            return true;
        return false;
    }

    function updateUserInfo (PDO $db, string $name, string $email, int $phoneNum, string $address, string $city, string $zipCode, string $username, string $password, $user) {
        if ($user['email'] != strtolower($email) && existsUserWithEmail($db, $email)) {
            $_SESSION['message'] = 'Choose another email'; 
            return false;
        } 

        else if ($user['username'] != strtolower($username) && existsUserWithUsername($db, $username)){
            $_SESSION['message'] = 'Choose another username'; 
            return false;
        }

        $stmt = $db->prepare("UPDATE User
                                SET name = ?,
                                email = ?,
                                phoneNum = ?,
                                address = ?,
                                city = ?,
                                zipCode = ?,
                                username = ?,
                                password = ?
                                WHERE username = '{$user['username']}'"
                            );
         $stmt->execute(array($name, strtolower($email), $phoneNum, $address, $zipCode, $city, strtolower($username), md5($password)));

        return true;
    }


    function registerUser (PDO $db, string $name, string $email, int $phoneNum, string $address, string $zipCode, string $city, string $username, string $password) { 
        if (existsUserWithEmail($db, $email)) {
            $_SESSION['message'] = 'Choose another email'; 
            return false;
        } 

        else if (existsUserWithUsername($db, $username)){
            $_SESSION['message'] = 'Choose another username'; 
            return false;
        }

        $stmt = $db->prepare('INSERT INTO User(name, email, phoneNum, address, zipCode, city, username, password)
                              VALUES(?, ?, ?, ?, ?, ?, ?, ?) ');
        
        $stmt->execute(array($name, strtolower($email), $phoneNum, $address, $zipCode, $city, strtolower($username), md5($password)));

        return true;
    }

    function canEditRestaurant(PDO $db, int $idRestaurant, string $username) { 
        $stmt = $db->prepare('SELECT *
                              FROM Restaurant
                              WHERE idRestaurant = ?
                              AND owner = ?');
        $stmt -> execute(array($idRestaurant, $username));
        return $stmt->fetch();
   }

   function canEditDish(PDO $db, int $idDish, string $username) {
        $stmt = $db->prepare('SELECT *
                            FROM Dish
                            JOIN Restaurant USING (idRestaurant)
                            WHERE idDish = ?
                            AND owner = ?');
        $stmt -> execute(array($idDish, $username));
        return $stmt->fetch();
    }

?>