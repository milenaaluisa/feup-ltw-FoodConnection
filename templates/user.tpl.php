<?php declare(strict_types = 1); ?>

<?php 
    function output_profile_photo() {
        if (isset($_SESSION['file'])) { ?>
            <img src="..\images\users\<?= $_SESSION['file'] ?>" class ="profile_photo" alt = "profile photo">
        <?php } 

        else { ?>
            <img src="..\images\users\user_no_photo.jpg" class ="profile_photo" alt = "profile photo">
        <?php }    
} ?>