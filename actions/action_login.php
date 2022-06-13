<?php
  declare(strict_types = 1);
  session_start();

  if (isset($_SESSION['idUser'])) {
    echo "Already logged in";
    die(header('Location: index.php'));
  }

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');
  require_once('../includes/input_validation.php');

  //get database connection
  $db = getDatabaseConnection();

  if (!validUsername( $_POST['username'])) {
    echo "Invalid username";
    die();
  }

  //check if username and password are correct
  $user = User::getUserWithUsername($db, $_POST['username'], $_POST['password']);
  
  if ($user) {
    $_SESSION['idUser'] = $user->idUser;
    $_SESSION['name'] = $user->name;
    $_SESSION['file'] = $user->file;

    header('Location: ../pages/index.php');  
  }
  
  echo "Invalid username or password!"
?>

