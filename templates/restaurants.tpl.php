<?php declare(strict_types = 1); ?>
<?php require_once('../templates/dishes.tpl.php'); ?>


<?php 
    function output_single_restaurant($restaurant, array $dishes, array $shifts, array $reviews, $output_order_form = False) { ?>
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
    function output_restaurant_categories($restaurant, array $categories) { ?>
    <!---TODO: COMPLETAR: PAGINA DO MESMO RESTAURANTE MAS APENAS OS PRATOS DA CATEGORIA SELECIONADA É QUE SÃO APRESENTADOS--->
        <nav>
            <ul>
                <?php foreach($categories as $category) { ?>
                    <li><a href="restaurant.php?id=<?= $restaurant['idRestaurant'] ?>"><?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php } ?>


<?php
    function output_restaurant_photo ($restaurant) { ?>
        <a href="restaurant.php?id=<?= $restaurant['idRestaurant'] ?>">
            <?php if (isset($restaurant['file'])) { ?>
                    <img src="..\images\restaurants\<?= $restaurant['file'] ?>">
            <?php }
            
            else { ?>
                <img src="..\images\no_photo.jpg">
            <?php } ?>
        </a>
<?php } ?>


<?php function output_restaurant_info($restaurant, array $shifts) { ?>
        <section class="info">
            <h2>Shift:</h2>
            <?php foreach($shifts as $shift) { ?>
                <p><?= $shift['day'] ?>: <?= substr($shift['openingTime'],0,-3) ?>-<?= substr($shift['closingTime'],0,-3) ?></p>
            <?php } ?>
            <h2>Address:</h2>
            <p><?= $restaurant['address'] ?></p>
            <h2>Tel.:</h2>
            <p><?= $restaurant['phoneNum'] ?></p>
        </section>
<?php } ?>

<?php
    function output_restaurant_reviews(array $reviews) { ?>
        <section id="reviews">
            <header>
                <h1>Reviews</h1>
            </header>
            <?php foreach($reviews as $review) { ?>
                <article>
                    <div>
                        <img src="https://picsum.photos/600/200?city" class ="profile_photo" alt = "profile photo">
                        <span class="user"><?= $review['username'] ?> said:</span>
                        <span class="rate"><?= $review['rate'] ?></span>
                        <p><?= $review['comment'] ?></p>
                        <span class="date"><?= $review['reviewDate'] ?></span>
                    </div>
                    <img src= "https://picsum.photos/300/200?city" alt = "review photo">
                </article> 
            <?php } ?>
        </section>
<?php } ?>


<?php
    function output_restaurant($restaurant, array $dishes = null, array $shifts = null, array $reviews = null, $output_order_form = False) { ?>
        <article>
            <header>
                <h1><a href="restaurant.php?id=<?= $restaurant['idRestaurant'] ?>"><?= $restaurant['name'] ?></a></h1>
            </header>

            <?php output_restaurant_photo($restaurant); ?>

            <span class="avgPrice">
                <?php 
                    if($restaurant['averagePrice'] <= 10) echo ' € ';
                    else if($restaurant['averagePrice'] > 10 && $restaurant['averagePrice'] <= 40) echo ' €€ ';
                    else echo ' €€€ '; 
                ?>
            </span>
            
            <a class="rate" href=restaurant.php#reviews><?= $restaurant['averageRate'] ?></a>

            <!---<img id="fav_button" src="fav_button.jpg" alt=""> --->

            <div class = "edit_options">
                <a href="edit_restaurant_info.php?id=<?= $restaurant['idRestaurant'] ?>">Edit Info</a>
                <a href="add_dish.php?id=<?=$restaurant['idRestaurant']?>">Add Dish</a>
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
                        <h1>Your Order</h1>
                    </header>
                    <form action = "new_order.php" method="post">
                        <button type="submit">Place Order</button>
                    </form>
                </section>

                <?php if(isset($reviews) && sizeof($reviews) > 0) {
                    output_restaurant_reviews($reviews);
                } ?>
            <?php } ?>
        </article>
<?php } ?>


<?php
    function output_my_restaurant($my_restaurant) { ?>
         <article>
            <header>
                <h2><a href="restaurant.php"><?= $my_restaurant['name'] ?></a></h2>
            </header>
            <?php output_restaurant_photo($my_restaurant); ?>
            <section class="info">
                <h2>Address: </h2>
                <p><?= $my_restaurant['address'] ?></p>    
                <h2>Tel.:</h2>
                <p><?= $my_restaurant['phoneNum'] ?></p>
            </section>   
            <a href="restaurant_orders.php"> List Orders </a>
            <a href="edit_restaurant.php?id=<?=$my_restaurant['idRestaurant']?>"> Edit restaurant </a>
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