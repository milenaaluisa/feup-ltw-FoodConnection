<?php declare(strict_types = 1); ?>

<?php 
    require_once('../templates/restaurant.tpl.php');
    require_once('../templates/dish.tpl.php');
    
    function output_favourites(array $favourite_restaurants, array $favourite_dishes) { ?>
        <section id="favorites">
            <header>
                <h1>My Favourites</h1>
            </header>
            <?php 
                output_restaurant_list($favourite_restaurants); 
                output_dish_list($favourite_dishes);
            ?>
        </section>
    <?php }
?>