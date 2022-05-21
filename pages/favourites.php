<?php
    require_once('../database/connection.db.php');
    require_once('../database/restaurants.db.php');
    require_once('../database/dishes.db.php');
  
    $db = getDatabaseConnection();

    $favourite_restaurants = getUserFavouriteRestaurants($db, $_GET['id']);

    $favourite_dishes = getUserFavouriteDishes($db, $_GET['id']);

    outputHeader();
?>

    <section id="favorites">
        <header>
            <h1>My Favourites</h1>
        </header>
        <?php output_restaurant_list($favourite_restaurants); 
            output_dish_list($favourite_dishes);
        ?>
    </section>    
            
<?php outputFooter() ?>