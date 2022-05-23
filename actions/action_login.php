<?php

  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.db.php');

  $db = getDatabaseConnection();

  $user = getUserWithPassword($db, $_POST['username'], $_POST['password']);

  if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
  }
  
  header('Location: ' . $_SERVER['HTTP_REFERER']);  /**TODO: Redirecionar para a página anterior ao login.php */
?>

