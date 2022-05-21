<?php
    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
  
    $db = getDatabaseConnection();

    $my_restaurants = getUserRestaurants($db, $_GET['id']);

    output_header();
?>

        <section id="restaurants">
            <header>
                <h2>My Restaurants</h2>
            </header>
            <?php foreach($my_restaurants as $my_restaurant) { ?>
                <article>
                    <header>
                        <h2><a href="restaurant.php"><?= $my_restaurant['name'] ?></a></h2>
                    </header>
                    <a href="restaurant.php"><img src="https://picsum.photos/id/237/200/300" alt=""></a>
                    <section class="info">
                        <h2>Tel.:</h2>
                        <p><?= $my_restaurant['phoneNum'] ?></p>
                        <h2>Address: </h2>
                        <p><?= $my_restaurant['address'] ?></p>    
                    </section>   
                </article>
            <?php } ?>
        </section>
        <a href="action_register_restaurant.php">Add new restaurant</a>

        <?php output_footer() ?>