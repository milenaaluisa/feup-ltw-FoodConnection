<?php

  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.db.php');

  $db = getDatabaseConnection();

  $user = getUserWithPassword($db, $_POST['username'], $_POST['password']);

  if ($user) {
        $_SESSION['idUser'] = $user['idUser'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['profilePhoto'] = $user['file'];
  }
  
  header('Location: ../pages/index.php'); 
?>

