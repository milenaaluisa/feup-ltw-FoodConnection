<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');

    $db = getDatabaseConnection();

    if ($idUser = User::registerUser($db, $_POST['name'], $_POST['email'], intval($_POST['phoneNum']), $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['username'], $_POST['password'])) {
        echo "Success!";

        $user = User::getUser($db, intval($idUser));
        
        $_SESSION['idUser'] = $user->idUser;
        $_SESSION['name'] = $user->name;
        $_SESSION['username'] = strtolower($user->username);
        $_SESSION['email'] = strtolower($user->email);
        $_SESSION['phone'] = $user->phoneNum;  
        $_SESSION['file'] = $user->file; 
    }

    else
        echo $_SESSION['message'];
    
?>