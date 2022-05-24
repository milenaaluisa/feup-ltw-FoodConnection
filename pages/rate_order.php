<?php
    declare(strict_types = 1);

    session_start();

    require_once('../templates/common.tpl.php');
    require_once('../templates/forms.tpl.php');

    output_header();
    output_rate_order();
    output_footer();
?>