<?php 
    declare(strict_types = 1);

    session_start(); 

    if (isset($_SESSION['idUser'])) {
        die(header('Location: index.php'));
    }

    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    output_header();
    output_login_form();
    output_footer();
?>