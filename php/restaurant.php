<?php
    require_once('./database/connection.db.php');
    require_once('./database/categories.db.php');
    require_once('./database/restaurants.db.php');
    require_once('./database/dishes.db.php');
  
    $db = getDatabaseConnection();

    $restaurant = getRestaurant($db, $_GET['id']);

    $categories = getRestaurantCategories($db, $_GET['id']);

    $shifts = getRestaurantShifts($db, $_GET['id']);

    $dishes = getRestaurantDishes($db, $_GET['id']);

    $reviews = getRestaurantReviews($db, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>UberEats 9<!--mudar--></title>
        <meta charset="UTF-8">
        <link href="style.css" rel="stylesheet">
        <link href="layout.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="https://picsum.photos/600/300?city" alt="Logo"></a>

            <div id="sign">
                <a href="login.php">Sign in</a> 
                <a href="register.php">Sign up</a>
            </div>

            <div id="search_bar">
                <form action="action_page.php">
                    <img src="https://picsum.photos/600/300?city" alt="search icon">
                    <input type="text" placeholder="Search..." name="search">
                </form>
            </div>

            <nav id="menu">
                <input type="checkbox" id="hamburger"> 
                <label class="hamburger" for="hamburger"></label>
                <ul>
                    <li><a href="user_profile.php"><img src="https://picsum.photos/600/300?city" class ="profile_photo" alt = "profile photo"></a></li>
                    <li><a href="user_profile.php">Luís Lima</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="favourites.php">Favourites</a></li>
                    <li><a href="order_history.php">Order History</a></li>
                    <li><a href="my_restaurants.php">My restaurants</a></li>
                    <li><a href="edit_profile.php">Edit profile</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="restaurants">
                <article class="restaurant">
                    <header>
                        <h1><a href="restaurant.php?id=<?= $restaurant['idRest'] ?>"><?= $restaurant['name'] ?></a></h1>
                    </header>

                    <img src= "https://picsum.photos/600/300?city">

                    <img id="fav_button" src="fav_button.jpg" alt=""> 

                    <nav id="categories">
                        <ul>
                            <?php foreach($categories as $category) { ?>
                                <li><a href="category.php?id=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </nav>

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
                    
                    <section id="dishes"> 
                        <header>Dishes</header>
                        <?php foreach($dishes as $dish) { ?>
                            <article class="dish">
                                <header>
                                    <h1><a href="dish.php?id=<?= $dish['idDish'] ?>"><?= $dish['name'] ?></a></h1>
                                </header>

                                <img src="..\images\<?= $dish['file'] ?>">

                                <span class="price"><?= $dish['price'] ?></span>

                                <span class="rate"><?= $dish['averageRate'] ?></span>

                                <!---TODO: like button-->
                            </article>
                        <?php } ?>
                    </section>

                    <section id="order">
                        <header>
                            <h1>Your Order</h1>
                        </header>
                        <form action = "new_order.php" method="post">
                            <?php foreach($selected_dishes as $selected_dish) { ?>
                                <label>
                                    <?= $selected_dish['name'] ?>
                                    <input name="quantity" type="number" value="1" min="0" step="1">
                                </label>
                                <span class="price"><?= $selected_dish['price'] ?></span>
                            <?php } ?>
    
                            <button type="submit">Place Order</button>
                        </form>
                    </section>

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

                </article> 
            </section>
        </main>    

        <footer>
            <img src="https://picsum.photos/600/300?city" alt="FB Logo">
            <img src="https://picsum.photos/600/300?city" alt="IG Logo">
            <span>Privacy Policy</span>
            <span>Terms</span>
            <span>Pricing</span>
        </footer>
    </body>
</html>