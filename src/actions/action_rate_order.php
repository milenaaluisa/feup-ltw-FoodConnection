<?php
    declare(strict_types = 1);

    session_start();

    if (!isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/review.class.php');
    require_once('../database/photo.class.php');
    require_once('../database/order.class.php');
    require_once('../includes/input_validation.php');

    $db = getDatabaseConnection();
  
    if (!is_numeric($_POST['rate']) || $_POST['rate'] < 1 || $_POST['rate'] > 5){
        echo "invalid rate";
        die();
    }

    filterText($_POST['comment']);

    $order = Order::getOrder($db, intval($_POST['idFoodOrder']));


    if ($order && ($order->state !== 'delivered' || $order->rated === true || $order->idUser !== $_SESSION['idUser'])) 
            die(header('Location: index.php'));

    if ($order) {

        $orderDate = time(); //date of the current day

        $idReview = Review::saveReview ($db, intval($_POST['rate']), $_POST['comment'], intval($orderDate), intval($_POST['idFoodOrder']));

        if($idReview) {
            if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
    
                $filename = "review". $idReview . ".jpg";
                $location = "../images/reviews/$filename";
        
                Photo::saveReviewPhoto($db, intval($idReview), $filename);
                
                move_uploaded_file($_FILES['photo']['tmp_name'], $location);
        
                $original = imagecreatefromjpeg($location);
                if (!$original) $original = imagecreatefrompng($location);
                if (!$original) $original = imagecreatefromgif($location);
        
                if (!$original) die();
        
                $width = imagesx($original);     // width of the original image
                $height = imagesy($original);    // height of the original image
        
                $mediumwidth = $width;
                $mediumheight = $height;
        
                if ($mediumwidth > 800) {
                    $mediumwidth = 800;
                    $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
                }
        
                // Create and save a medium image
                $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
                imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
                imagejpeg($medium, $location);
            }
            header('Location: ../pages/order_history.php'); 
        }
    
        
    }
    else{   
        die(header('Location: ../pages/index.php'));
    }
?>