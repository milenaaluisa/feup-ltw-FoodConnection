<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/connection.db.php');
    require_once('../database/user.class.php');
    require_once('../database/photo.class.php');

    $db = getDatabaseConnection();

    if ($idUser = User::registerUser($db, $_POST['name'], $_POST['email'], intval($_POST['phoneNum']), $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['username'], $_POST['password'])) {
        echo "Success!";

        if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
            
            $filename = "user". $idUser . ".jpg";
            $location = "../images/users/$filename";
    
            Photo::saveUserPhoto($db, intval($idUser), $filename);
            
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

        }
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