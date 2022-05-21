<?php 
    require_once('../templates/dishes.tpl.php');

    function output_single_restaurant($restaurant, $categories, $dishes, $shifts, $reviews) { ?>
        <main>
            <section id="restaurants">
                <?php output_restaurant($restaurant, $categories, $dishes, $shifts, $reviews); ?>
            </section>
        </main>  
    <?php }

    function output_restaurant_list($restaurants) { ?>
        <main>
            <section id="restaurants">
                <h1>Restaurants</h1>
                <?php foreach($restaurants as $restaurant) {
                    output_restaurant($restaurant);
                } ?>
            </section>
        </main>                
    <?php }

    function output_restaurant_categories($categories) { ?>
        <nav id="categories">
            <ul>
                <?php foreach($categories as $category) { ?>
                    <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    <?php }

    function output_restaurant_info($restaurant, $shifts) { ?>
        <section class="info">
            <h2>Shift:</h2>
            <?php foreach($shifts as $shift) { ?>
                <p><?= $shift['day'] ?>: <?= $shift['openingTime'] ?>-<?= $shift['closingTime'] ?></p>
            <?php } ?>
            <h2>Address:</h2>
            <p><?= $restaurant['address'] ?></p>
            <h2>Tel.:</h2>
            <p><?= $restaurant['phoneNum'] ?></p>
        </section>
    <?php }

    function output_restaurant_reviews($reviews) { ?>
        <section id="reviews">
            <h1>Reviews</h1>
            <?php foreach($reviews as $review) { ?>
                <article class="review">
                    <span class="user"><?= $review['username'] ?> said:</span>
                    <span class="rate"><?= $review['rate'] ?></span>
                    <p><?= $review['comment'] ?></p>
                    <span class="date"><?= $review['reviewDate'] ?></span>
                </article> 
            <?php } ?>
        </section>
    <?php }

    function output_restaurant($restaurant, $categories = null, $dishes = null, $shifts = null, $reviews = null) { ?>
        <article>
            <header>
                <h1><a href="restaurant.php?id=<?= $restaurant['idRest'] ?>"><?= $restaurant['name'] ?></a></h1>
            </header>

            <img src= "https://picsum.photos/600/300?city">

            <span class="avgPrice">
                <?php 
                    if($restaurant['averagePrice'] <= 10) echo ' € ';
                    else if($restaurant['averagePrice'] > 10 && $restaurant['averagePrice'] <= 40) echo ' €€ ';
                    else echo ' €€€ '; 
                ?>
            </span>
            
            <a class="rate" href=restaurant.php#reviews><?= $restaurant['averageRate'] ?></span>

            <img id="fav_button" src="fav_button.jpg" alt=""> 

            <?php if(isset($categories)) {
                output_restaurant_categories($categories);
            }

            if(isset($shifts)) {
                output_restaurant_info($restaurant, $shifts);
            }
            
            if(isset($dishes)) {
                output_dish_list($dishes);
            } ?>

            <section id="order">
                <header>
                    <h1>Your Order</h1>
                </header>
                <form action = "new_order.php" method="post">
                    <button type="submit">Place Order</button>
                </form>
            </section>

            <?php if(isset($reviews)) {
                output_reviews($reviews);
            } ?>
        </article>

        <!---TODO: LIKE BUTTON-->
    <?php }
?>