<?php 
    declare(strict_types = 1);

    require_once('../database/connection.db.php');
    include_once('../templates/dish.tpl.php'); 
    include_once('../templates/review.tpl.php');
    require_once('../database/dish.class.php');
?>


<?php 
    function output_single_restaurant(Restaurant $restaurant, array $dishes, array $shifts, array $reviews, $output_order_form = False) { ?>
        <div id="restaurants">
            <?php output_restaurant($restaurant, $dishes, $shifts, $reviews, $output_order_form); ?>
        </div> 
<?php } ?>


<?php
    function output_restaurant_list(array $restaurants, bool $all_restaurants = false) { ?>
        <?php if($all_restaurants) { ?>
            <form>
                <input type="text" placeholder="Search..." id="search_restaurant">
            </form>
        <?php } ?>
        <section id="restaurants">
            <header>
                <h2>Restaurants</h2>
            </header>
            <?php foreach($restaurants as $restaurant) {
                output_restaurant($restaurant);
            } ?>
        </section>              
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
            <h2> <i class="fa-solid fa-clock"> </i> Shift:</h2>
            <?php foreach($shifts as $shift) { ?>
                <p><?= $shift['day'] ?>: <?= substr($shift['openingTime'],0,-3) ?>-<?= substr($shift['closingTime'],0,-3) ?></p>
            <?php } ?>
            <h2><i class="fa-solid fa-location-dot"></i> Address:</h2>
            <p><?= $restaurant->address ?></p>
            <h2> <i class="fa-solid fa-phone"Z«> </i> Tel.:</h2>
            <p><?= $restaurant->phoneNum ?></p>
        </section>
<?php } ?>


<?php
    function output_user_cart(){

        $price = 0;

        foreach($_SESSION['cart'] as $id => $dish){
            $price+= $dish['quantity']*$dish['price']?>
            
            <label>
                <?= $dish['name']?>
            </label>
            <span class="quantity"> 
                <?=$dish['quantity']?>
            </span>
            <span class="price">
                <?= $dish['quantity']*$dish['price']?>
            </span>
            <button type="eliminate" name="eliminate" value="<?=$id?>">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
        
        <?php
        }

        return $price;
    } ?>


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

            <?php if ($restaurant->is_favourite) { ?>
                <i class="fa fa-heart" data-id=<?=$restaurant->idRestaurant?>></i>
            <?php } else { ?>
                <i class="fa fa-heart-o" data-id=<?=$restaurant->idRestaurant?>></i>
            <?php } ?>

            <div class = "edit_options">
                <a href="edit_restaurant_info.php?id=<?= $restaurant->idRestaurant ?>">Edit Info <i class="fa-solid fa-pen-to-square"></i></a>
                <a href="add_dish.php?id=<?=$restaurant->idRestaurant?>">Add Dish <i class="fa-solid fa-plus"></i></a>
            </div>

            <?php if(isset($shifts) && sizeof($shifts) > 0) {
                output_restaurant_info($restaurant, $shifts);
            }
            
            if(isset($dishes) && sizeof($dishes) > 0) {
                output_dish_list($dishes);
            }
            
            if($output_order_form){?>

                <section id="orders">
                    <header>
                        <h3>Your Order</h3>
                    </header>

                    <?php if($_SESSION['cart'] > 0) { ?>
                        <form action = "../actions/action_place_order.php" method="post">
                            <input type="hidden" name="idRestaurant" value="<?=$restaurant->idRestaurant?>">
                            <?php $price = output_user_cart(); ?>
                            <textarea name="notes" placeholder="notes"></textarea>
                            <div>
                                <h2>Subtotal: </h2>
                                <span class="price"><?=$price?></span>
                            </div>
                            <button type="submit" name="submit">Place Order</button>
                            <button type="cancel" name="cancel">Cancel</button>
                        </form>
                    <?php } ?>
                </section>
            <?php }?>
            <?php if(isset($reviews) && sizeof($reviews) > 0) {
                    output_restaurant_reviews_list($reviews);
                } ?>
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
            <a href="restaurant_orders.php?id=<?=$my_restaurant->idRestaurant?>"> List Orders <i class="fa-solid fa-receipt"></i> </a>
            <a href="edit_restaurant.php?id=<?=$my_restaurant->idRestaurant?>"> Edit restaurant <i class="fa-regular fa-pen-to-square"></i></a>
        </article>
<?php } ?>


<?php
    function output_my_restaurants_list(array $my_restaurants) { ?>
        <section id="my_restaurants">
            <div class="new_restaurant">
                <a href="add_restaurant.php">Add new restaurant</a>
            </div>
            <header>
                <h2>My Restaurants</h2>
            </header>
            <?php foreach($my_restaurants as $my_restaurant) { 
                output_my_restaurant($my_restaurant);
            } ?>
            
        </section>
<?php } ?>