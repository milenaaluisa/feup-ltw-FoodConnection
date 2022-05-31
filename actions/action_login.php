<?php

  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

  if ($user) {
    $_SESSION['idUser'] = $user->idUser;
    $_SESSION['name'] = $user->name;
    $_SESSION['username'] = strtolower($user->username);
    $_SESSION['email'] = strtolower($user->email);
    $_SESSION['phone'] = $user->phoneNum;
    $_SESSION['file'] = $user->file; 
  }
  
  header('Location: ../pages/index.php'); 
?>

