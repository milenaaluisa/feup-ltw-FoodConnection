<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');

    $db = getDatabaseConnection();

    $user = User::getUser($db, intval($_SESSION['idUser']));

    if ($user) {

        if (empty($_POST['password'])) 
            $password = $user->getPassword($db);
        else 
            $password = $_POST['password'];

        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->phoneNum = intval($_POST['phoneNum']);
        $user->address = $_POST['address'];
        $user->city = $_POST['city'];
        $user->zipCode = $_POST['zipCode'];
        $user->username = $_POST['username'];

        if ($user->updateUserInfo($db, $password)) {
            echo "Success!";
            $_SESSION['idUser'] = $user->idUser;
            $_SESSION['name'] = $user->name;
            $_SESSION['username'] = strtolower($user->username);
            $_SESSION['email'] = strtolower($user->email);
            $_SESSION['phone'] = $user->phoneNum;
        }
    
        else
            echo $_SESSION['message'];
    }
  
?>