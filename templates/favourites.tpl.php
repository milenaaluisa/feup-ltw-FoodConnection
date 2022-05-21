<?php 
    require_once('../templates/restaurants.tpl.php');
    require_once('../templates/dishes.tpl.php');
    
    function output_favourites($favourite_restaurants, $favourite_dishes) { ?>
        <section id="favorites">
            <header>
                <h1>My Favourites</h1>
            </header>
            <?php output_restaurant_list($favourite_restaurants); 
                output_dish_list($favourite_dishes);
            ?>
        </section>
    <?php }
?>