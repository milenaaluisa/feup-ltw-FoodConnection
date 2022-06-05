<?php declare(strict_types = 1); ?>

<?php 
    function output_profile_photo($file) {
        if (isset($file)) { ?>
            <img src="../images/users/<?= $file?>" class ="profile_photo" alt = "profile photo">
        <?php } 

        else { ?>
            <img src="../images/users/user_no_photo.jpg" class ="profile_photo" alt = "profile photo">
        <?php }    
} ?>

