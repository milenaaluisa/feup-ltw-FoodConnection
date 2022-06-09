<?php 
    declare(strict_types = 1);
    include_once('../templates/dish.tpl.php'); 
    include_once('../templates/review.tpl.php'); 
?>


<?php 
    function output_single_restaurant(Restaurant $restaurant, array $dishes, array $shifts, array $reviews, $output_order_form = False) { ?>
        <main>
            <section id="restaurants">
                <?php output_restaurant($restaurant, $dishes, $shifts, $reviews, $output_order_form); ?>
            </section>
        </main>  
<?php } ?>


<?php
    function output_restaurant_list(array $restaurants) { ?>
        <main>
            <section id="restaurants">
                <header>
                    <h1>Restaurants</h1>
                </header>
                <?php foreach($restaurants as $restaurant) {
                    output_restaurant($restaurant);
                } ?>
            </section>
        </main>                
<?php } ?>


<?php
    function output_restaurant_photo (Restaurant $restaurant) { ?>
        <a href="restaurant.php?id=<?= $restaurant->idRestaurant ?>">
            <?php if (isset($restaurant->file)) { ?>
                    <img src="../images/restaurants/<?= $restaurant->file ?>" alt="">
            <?php }
            
            else { ?>
                <img src="../images/no_photo.jpg" alt="">
            <?php } ?>
        </a>
<?php } ?>


<?php function output_restaurant_info(Restaurant $restaurant, array $shifts) { ?>
        <section class="info">
            <h2>Shift:</h2>
            <?php foreach($shifts as $shift) { ?>
                <p><?= $shift['day'] ?>: <?= substr($shift['openingTime'],0,-3) ?>-<?= substr($shift['closingTime'],0,-3) ?></p>
            <?php } ?>
            <h2>Address:</h2>
            <p><?= $restaurant->address ?></p>
            <h2>Tel.:</h2>
            <p><?= $restaurant->phoneNum ?></p>
        </section>
<?php } ?>


<?php
    function output_restaurant(Restaurant $restaurant, array $dishes = null, array $shifts = null, array $reviews = null, $output_order_form = False) { ?>
        <article>
            <header>
                <h2><a href="restaurant.php?id=<?= $restaurant->idRestaurant ?>"><?= $restaurant->name ?></a></h2>
            </header>

            <?php output_restaurant_photo($restaurant); ?>

            <span class="avgPrice">
                <?php 
                    if($restaurant->averagePrice <= 10) echo ' € ';
                    else if($restaurant->averagePrice > 10 && $restaurant->averagePrice <= 40) echo ' €€ ';
                    else echo ' €€€ '; 
                ?>
            </span>
            
            <a class="rate" href= "restaurant.php?id=<?= $restaurant->idRestaurant ?>#reviews"><?= $restaurant->averageRate ?></a>

            <!---<img id="fav_button" src="fav_button.jpg" alt=""> --->

            <div class = "edit_options">
                <a href="edit_restaurant_info.php?id=<?= $restaurant->idRestaurant ?>">Edit Info</a>
                <a href="add_dish.php?id=<?=$restaurant->idRestaurant?>">Add Dish</a>
            </div>

            <?php if(isset($shifts) && sizeof($shifts) > 0) {
                output_restaurant_info($restaurant, $shifts);
            }
            
            if(isset($dishes) && sizeof($dishes) > 0) {
                output_dish_list($dishes);
            }

            if($output_order_form === True) { ?>
                <section id="orders">
                    <header>
                        <h3>Your Order</h3>
                    </header>
                    <form action = "../actions/action_place_order.php" method="post">
                        <input type="hidden" name="idRestaurant" value="<?=$dish->idRestaurant?>">
                        <?php /*output_restaurant_order(); */?>
                        <button type="submit">Place Order</button>
                    </form>
                </section>

                <?php if(isset($reviews) && sizeof($reviews) > 0) {
                    output_restaurant_reviews_list($reviews);
                } ?>
            <?php } ?>
        </article>
<?php } ?>


<?php
    function output_my_restaurant(Restaurant $my_restaurant) { ?>
         <article>
            <header>
                <h2><a href="edit_restaurant.php?id=<?=$my_restaurant->idRestaurant?>"><?= $my_restaurant->name ?></a></h2>
            </header>
            <?php output_restaurant_photo($my_restaurant); ?>
            <section class="info">
                <h2>Address: </h2>
                <p><?= $my_restaurant->address ?></p>    
                <h2>Tel.:</h2>
                <p><?= $my_restaurant->phoneNum ?></p>
            </section>   
            <a href="restaurant_orders.php?id=<?=$my_restaurant->idRestaurant?>"> List Orders </a>
            <a href="edit_restaurant.php?id=<?=$my_restaurant->idRestaurant?>"> Edit restaurant </a>
        </article>
<?php } ?>


<?php
    function output_my_restaurants_list(array $my_restaurants) { ?>
        <section id="restaurants">
            <header>
                <h2>My Restaurants</h2>
            </header>
            <?php foreach($my_restaurants as $my_restaurant) { 
                output_my_restaurant($my_restaurant);
            } ?>
        </section>
<?php } ?>