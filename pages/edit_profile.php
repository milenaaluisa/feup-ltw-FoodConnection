<?php 
    declare(strict_types = 1);

    session_start(); 

    if (!isset($_SESSION['username'])) {
        die(header('Location: index.php'));
    }

    require_once('../database/connection.db.php');
    require_once('../database/user.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');
    
    $db = getDatabaseConnection();
    
    $user = getUser($db, $_SESSION['username']);

    output_header();
    output_profile_form($user);
    output_footer();
?>