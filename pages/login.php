<?php 
    declare(strict_types = 1);

    session_start(); 

    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    $_SESSION['previous'] = $_SERVER['HTTP_REFERER'];

    output_header();
    output_login_form();
    output_footer();
?>