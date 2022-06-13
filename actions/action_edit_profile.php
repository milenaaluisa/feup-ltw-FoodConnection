<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/photo.class.php');

    $db = getDatabaseConnection();

    if (User::existsUserWithEmail($db, $_POST['email'])) {
        $_SESSION['message'] = 'Choose another email'; 
        //die();
    } 

    if (User::existsUserWithUsername($db, $_POST['username'])){
        $_SESSION['message'] = 'Choose another username'; 
        //die();
    }

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

            if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
            
                $filename = "user". $user->idUser . ".jpg";
                $location = "../images/users/$filename";
        
                if(!isset($user->file))
                    Photo::saveUserPhoto($db, intval($user->idUser), $filename);
                
                move_uploaded_file($_FILES['photo']['tmp_name'], $location);
    
                $original = imagecreatefromjpeg($location);
                if (!$original) $original = imagecreatefrompng($location);
                if (!$original) $original = imagecreatefromgif($location);
    
                if (!$original) die('../pages/my_restaurants.php');
    
                $width = imagesx($original);     // width of the original image
                $height = imagesy($original);    // height of the original image
    
                $mediumwidth = $width;
                $mediumheight = $height;
    
                if ($mediumwidth > 700) {
                    $mediumwidth = 700;
                    $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
                }
    
                // Create and save a medium image
                $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
                imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
                imagejpeg($medium, $location);

                $_SESSION['file'] = $filename; 
            }
        }
    
        else
            echo $_SESSION['message'];
    }
  
?>