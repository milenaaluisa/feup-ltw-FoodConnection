<?php 
    declare(strict_types = 1);

    function getUserWithPassword (PDO $db, string $username, string $password) {

        $stmt = $db->prepare('SELECT User.*
                              FROM User
                              WHERE username = ?
                              AND password = ? ' );

        $stmt->execute(array($username, md5($password)));

        if ($user =  $stmt->fetch()) {
            return $user;
        }
        return null;
    }
?>