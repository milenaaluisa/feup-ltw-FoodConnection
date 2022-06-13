<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  //get database connection
  $db = getDatabaseConnection();

  //check if the username is valid
  if ( !preg_match ('/^[a-z0-9][a-z0-9_]*[a-z0-9]$/', $_POST['username'])) {
    echo "Invalid username";
    die();
}

  //check if password lenght >= 8
  if (strlen($_POST['password']) < 8) {
    echo "Invalid password";
    die();
  } 

  //check if username and password are correct
  $user = User::getUserWithUsername($db, $_POST['username'], $_POST['password']);
  
  if ($user) {
    $_SESSION['idUser'] = $user->idUser;
    $_SESSION['name'] = $user->name;
    $_SESSION['username'] = strtolower($user->username);
    $_SESSION['email'] = strtolower($user->email);
    $_SESSION['phone'] = $user->phoneNum;
    $_SESSION['file'] = $user->file;

    header('Location: ../pages/index.php');  
  }
  
  echo "Invalid username or password!"
?>

