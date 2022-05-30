<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.db.php');

    $db = getDatabaseConnection();

    if (registerUser($db, $_POST['name'], $_POST['email'], intval($_POST['phoneNum']), $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['username'], $_POST['password'])) {
        echo "Success!";
        $_SESSION['username'] = strtolower($_POST['username']);
        $_SESSION['name'] = $_POST['name'];   
    }

    else
        echo $_SESSION['message'];
    
?>