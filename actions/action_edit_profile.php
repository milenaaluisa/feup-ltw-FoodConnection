<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.db.php');

    $db = getDatabaseConnection();

    $user = getUser($db, $_SESSION['username']);

    if (empty($_POST['password'])) 
        $password = $user['password'];
    else 
        $password = $_POST['password'];


    if (updateUserInfo($db, $_POST['name'], $_POST['email'], intval($_POST['phoneNum']), $_POST['address'], $_POST['city'], $_POST['zipCode'], $_POST['username'], $password, $user)) {

        echo "Success!";
        $_SESSION['username'] = strtolower($_POST['username']);
        $_SESSION['name'] = $_POST['name'];
    }

    else
        echo $_SESSION['message'];
    
?>